<?php
// Implementato da: Cosimo Mandrillo
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingCampaign extends Model
{
    protected $fillable = [
        'evaluator_id',
        'title',
        'description',
        'vulnerability_id',
        'content_type',
        'verbosity',
        'template_id',
        'llm_id',
        'state',
        'creation_date',
        'expiration_date',
        'creation_phase',
    ];

    protected $casts = [
        'creation_date' => 'datetime',
        'expiration_date' => 'datetime',
    ];

    // Relazione con valutatore - Cosimo Mandrillo
    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }

    // Relazione con vulnerabilità - Cosimo Mandrillo
    public function vulnerability()
    {
        return $this->belongsTo(Vulnerability::class);
    }

    // Relazione con template - Cosimo Mandrillo
    public function template()
    {
        return $this->belongsTo(PromptTemplate::class, 'template_id');
    }

    // Relazione con LLM - Cosimo Mandrillo
    public function llm()
    {
        return $this->belongsTo(LLM::class);
    }

    // Relazione con training sessions - Cosimo Mandrillo
    public function trainingSessions()
    {
        return $this->hasMany(TrainingSession::class);
    }

    // Scope per stato - Cosimo Mandrillo
    public function scopeByState($query, $state)
    {
        return $query->where('state', $state);
    }

    // Scope per valutatore - Cosimo Mandrillo
    public function scopeByEvaluator($query, $evaluatorId)
    {
        return $query->where('evaluator_id', $evaluatorId);
    }

    // Check se scaduta - Cosimo Mandrillo
    public function isExpired()
    {
        return $this->expiration_date && $this->expiration_date->isPast();
    }

    // Calcola percentuale completamento - Cosimo Mandrillo
    public function getCompletionRateAttribute()
    {
        $total = $this->trainingSessions()->count();
        if ($total == 0) return 0;

        $completed = $this->trainingSessions()->where('isCompleted', true)->count();
        return ($completed / $total) * 100;
    }
}
