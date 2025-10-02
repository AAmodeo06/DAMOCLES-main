<?php
// app/Models/WizardSession.php
// REALIZZATO DA: Andrea Amodeo

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WizardSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'current_step',
        'step_data',
        'campaign_id',
        'completed',
        'expires_at',
        'last_activity_at'
    ];

    protected $casts = [
        'step_data' => 'array',
        'completed' => 'boolean',
        'expires_at' => 'datetime',
        'last_activity_at' => 'datetime'
    ];

    // Step constants
    const STEP_1_ATTACK_TYPES = 1;
    const STEP_2_TARGET_AUDIENCE = 2;
    const STEP_3_DURATION = 3;
    const STEP_4_HUMAN_FACTORS = 4;
    const STEP_5_NOTIFICATIONS = 5;
    const STEP_6_FINALIZATION = 6;

    const TOTAL_STEPS = 6;

    /**
     * Relazione con l'utente
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relazione con la campagna creata (se completata)
     */
    public function campaign(): HasOne
    {
        return $this->hasOne(Campaign::class);
    }

    /**
     * Scope per sessioni attive (non scadute)
     */
    public function scopeActive($query)
    {
        return $query->where('expires_at', '>', now())
                    ->orWhereNull('expires_at');
    }

    /**
     * Scope per sessioni incomplete
     */
    public function scopeIncomplete($query)
    {
        return $query->where('completed', false);
    }

    /**
     * Scope per utente specifico
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Ottieni i dati per uno step specifico
     */
    public function getStepData(int $step): ?array
    {
        return $this->step_data["step_{$step}"] ?? null;
    }

    /**
     * Salva i dati per uno step specifico
     */
    public function saveStepData(int $step, array $data): void
    {
        $stepData = $this->step_data ?? [];
        $stepData["step_{$step}"] = $data;

        $this->update([
            'step_data' => $stepData,
            'last_activity_at' => now()
        ]);
    }

    /**
     * Verifica se uno step è completato
     */
    public function isStepCompleted(int $step): bool
    {
        return isset($this->step_data["step_{$step}"]);
    }

    /**
     * Calcola la percentuale di completamento
     */
    public function getProgressPercentage(): float
    {
        return ($this->current_step / self::TOTAL_STEPS) * 100;
    }

    /**
     * Avanza al prossimo step
     */
    public function advanceToNextStep(): void
    {
        if ($this->current_step < self::TOTAL_STEPS) {
            $this->increment('current_step');
            $this->touch('last_activity_at');
        }
    }

    /**
     * Verifica se la sessione è scaduta
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Estende la scadenza della sessione
     */
    public function extendExpiration(int $hours = 2): void
    {
        $this->update([
            'expires_at' => now()->addHours($hours),
            'last_activity_at' => now()
        ]);
    }

    /**
     * Completa la sessione wizard
     */
    public function complete(Campaign $campaign): void
    {
        $this->update([
            'completed' => true,
            'campaign_id' => $campaign->id,
            'last_activity_at' => now()
        ]);
    }

    /**
     * Ottieni il nome dello step corrente
     */
    public function getCurrentStepName(): string
    {
        return match($this->current_step) {
            1 => 'Selezione Tipi di Attacco',
            2 => 'Pubblico Target e Difficoltà',
            3 => 'Durata Campagna',
            4 => 'Fattori Umani',
            5 => 'Impostazioni Notifiche',
            6 => 'Finalizzazione',
            default => 'Step Sconosciuto'
        };
    }

    /**
     * Ottieni tutti i dati raccolti nel wizard
     */
    public function getAllWizardData(): array
    {
        $allData = [];

        for ($i = 1; $i <= self::TOTAL_STEPS; $i++) {
            $stepData = $this->getStepData($i);
            if ($stepData) {
                $allData = array_merge($allData, $stepData);
            }
        }

        return $allData;
    }

    /**
     * Pulisce sessioni scadute (metodo statico per cleanup)
     */
    public static function cleanupExpired(): int
    {
        return static::where('expires_at', '<', now())
                    ->where('completed', false)
                    ->delete();
    }

    /**
     * Verifica se può continuare al prossimo step
     */
    public function canAdvanceToStep(int $targetStep): bool
    {
        // Deve aver completato tutti i step precedenti
        for ($i = 1; $i < $targetStep; $i++) {
            if (!$this->isStepCompleted($i)) {
                return false;
            }
        }

        return !$this->isExpired() && !$this->completed;
    }

    /**
     * Boot method per eventi del model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($session) {
            if (!$session->expires_at) {
                $session->expires_at = now()->addHours(4); // Default 4 ore
            }

            if (!$session->current_step) {
                $session->current_step = 1;
            }

            $session->last_activity_at = now();
        });

        static::updating(function ($session) {
            $session->last_activity_at = now();
        });
    }
}
