<?php
// REALIZZATO DA: Andrea Amodeo

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LLMIntegration extends Model
{
    use HasFactory;

    protected $table = 'llm_integrations';

    protected $fillable = [
        'campaign_id',
        'content_type',
        'prompt_template',
        'generated_content',
        'generation_parameters',
        'model_used',
        'tokens_consumed',
        'generation_time_ms',
        'quality_score',
        'status',
        'error_message',
        'voice_generated',
        'voice_url',
        'voice_duration',
        'metadata'
    ];

    protected $casts = [
        'generated_content' => 'array',
        'generation_parameters' => 'array',
        'tokens_consumed' => 'integer',
        'generation_time_ms' => 'integer',
        'quality_score' => 'float',
        'voice_generated' => 'boolean',
        'voice_duration' => 'integer',
        'metadata' => 'array'
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_GENERATING = 'generating';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCELLED = 'cancelled';

    // Content type constants
    const TYPE_EMAIL_PHISHING = 'email_phishing';
    const TYPE_VISHING_SCRIPT = 'vishing_script';
    const TYPE_SOCIAL_ENGINEERING = 'social_engineering';
    const TYPE_CEO_FRAUD = 'ceo_fraud';
    const TYPE_SMISHING = 'smishing';
    const TYPE_QUIZ_QUESTIONS = 'quiz_questions';

    /**
     * Relazione con la campagna
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * Scope per generazioni completate
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    /**
     * Scope per tipo di contenuto
     */
    public function scopeByContentType($query, $type)
    {
        return $query->where('content_type', $type);
    }

    /**
     * Scope per generazioni con voice
     */
    public function scopeWithVoice($query)
    {
        return $query->where('voice_generated', true);
    }

    /**
     * Verifica se la generazione è completata
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Verifica se la generazione è fallita
     */
    public function hasFailed(): bool
    {
        return $this->status === self::STATUS_FAILED;
    }

    /**
     * Verifica se ha contenuto audio
     */
    public function hasVoice(): bool
    {
        return $this->voice_generated && !empty($this->voice_url);
    }

    /**
     * Ottieni il contenuto formattato per display
     */
    public function getFormattedContent(): array
    {
        return $this->generated_content ?? [];
    }

    /**
     * Calcola il costo stimato basato sui token
     */
    public function getEstimatedCost(): float
    {
        $costPerToken = match($this->model_used) {
            'gpt-4-turbo-preview' => 0.00003,
            'gpt-3.5-turbo' => 0.000002,
            default => 0.00001
        };

        return ($this->tokens_consumed ?? 0) * $costPerToken;
    }

    /**
     * Ottieni la durata formattata dell'audio
     */
    public function getFormattedVoiceDuration(): string
    {
        if (!$this->voice_duration) {
            return '0:00';
        }

        $minutes = floor($this->voice_duration / 60);
        $seconds = $this->voice_duration % 60;

        return sprintf('%d:%02d', $minutes, $seconds);
    }

    /**
     * Ottieni il badge di stato colorato
     */
    public function getStatusBadge(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => '<span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">In Attesa</span>',
            self::STATUS_GENERATING => '<span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Generando...</span>',
            self::STATUS_COMPLETED => '<span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Completato</span>',
            self::STATUS_FAILED => '<span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">Fallito</span>',
            self::STATUS_CANCELLED => '<span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Cancellato</span>',
            default => '<span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Sconosciuto</span>'
        };
    }

    /**
     * Verifica se può essere rigenerato
     */
    public function canRegenerate(): bool
    {
        return in_array($this->status, [self::STATUS_FAILED, self::STATUS_COMPLETED]);
    }

    /**
     * Boot method per eventi del model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($llm) {
            if (!$llm->status) {
                $llm->status = self::STATUS_PENDING;
            }
        });

        static::updating(function ($llm) {
            if ($llm->isDirty('status') && $llm->status === self::STATUS_COMPLETED) {
                $llm->generated_at = now();
            }
        });
    }
}
