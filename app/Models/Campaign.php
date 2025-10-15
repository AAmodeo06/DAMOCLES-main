<?php

//REALIZZATO DA: Andrea Amodeo

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relation\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relation\BelongToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'creator_id',
        'wizard_session_id',
        'target_audience',
        'difficulty_level',
        'duration_weeks',
        'attack_types',
        'human_factors',
        'notification_settings',
        'status',
        'settings',
        'starts_at',
        'ends_at',
        'total_participants',
        'completed_participants',
        'success_rate'
    ];

    protected $casts = [
        'settings' => 'array',
        'attack_types' => 'array',
        'human_factors' => 'array',
        'notification_settings' => 'array',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'success_rate' => 'float',
    ];

    protected $dates = ['deleted_at'];

    // Status constants
    const STATUS_DRAFT = 'draft';
    const STATUS_ACTIVE = 'active';
    const STATUS_COMPLETED = 'completed';
    const STATUS_PAUSED = 'paused';
    const STATUS_CANCELLED = 'cancelled';

    //Difficulty constants
    const DIFFICULTY_BEGINNER = 'beginner';
    const DIFFICULTY_INTERMEDIATE = 'intermediate';
    const DIFFICULTY_ADVANCED = 'advanced';

    /**
     * Relazione con l'utente creatore.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Relazione con la sessione wizard che l'ha generata.
     */
    public function wizardSession(): BelongsTo
    {
        return $this->belongsTo(WizardSession::class);
    }

    /**
     * Relazione con le generazioni LLM associate.
     */
    public function llmGenerations(): HasMany
    {
        return $this->hasMany(LLMGeneration::class);
    }

    /**
     * Relazione con i partecipanti alla campagna.
     */
    public function partecipants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'campaign_participants')
                    ->withPivot(['joined_at', 'status', 'progress', 'last_activity'])
                    ->withTimestamps();
    }

    /**
     * Scope per filtrare per status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope per campagne attive.
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE)
                     ->where('starts_at', '<=', now())
                     ->where('ends_at', '>=', now());
    }

    /**
     * Scope per campagne del creatore.
     */
    public function scopeByCreator($query, $creatorId)
    {
        return $query->where('creator_id', $creatorId);
    }

    /**
     * Verifica se la campagna è modificabile.
     */
    public function isEditable(): bool
    {
        return in_array($this->status, [self::STATUS_DRAFT, self::STATUS_PAUSED]);
    }

    /**
     * Verifica se la campagna può essere avviata.
     */
    public function canStart(): bool
    {
        return $this->status === self::STATUS_DRAFT &&
               $this->llmGenerations()->where('status', 'completed')->exists();
    }

    /**
     * Calcola la percentuale di completamento.
     */
    public function getCompletionPercentage(): float
    {
        if ($this->total_participants === 0) {
            return 0;
        }
        return ($this->completed_participants / $this->total_participants) * 100;
    }

    /**
     * Ottieni la configurazione per un tipo di attacco specifico.
     */
    public function getAttackTypeConfig($attackType): ?array
    {
        return $this->attack_types[$attackType] ?? null;
    }

    /**
     * Verifica se un fattore umano specifico è incluso.
     */
    public function hasHumanFactor($factor): bool
    {
        return in_array($factor, $this->human_factors ?? []);
    }

    /**
     * Ottieni l'URL di visualizzazione della campagna.
     */
    public function getViewUrl(): string
    {
        return route('campaigns.show', $this->id);
    }

    /**
     * Ottieni la durata in giorni.
     */
    public function getDurationInDays(): int
    {
        return $this->duration_weeks * 7;
    }

    /**
     * Boot method per eventi del modello.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($campaign) {
            if (!$campaign->status) {
                $campaign->starts_at = self::STATUS_DRAFT;
            }
        });

        static::creating(function ($campaign) {
            logger()->info("Campagna creata: {$campaign->name} da {$campaign->creator->name}");
        });
    }
}
