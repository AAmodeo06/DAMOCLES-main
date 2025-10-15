<?php
// Implementato da: Cosimo Mandrillo
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CampaignUser extends Pivot
{
    protected $table = 'campaign_user';

    protected $fillable = [
        'campaign_id',
        'user_id',
        'assigned_at',
        'started_at',
        'completed_at',
        'status',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relazione con campagna - Cosimo Mandrillo
    public function campaign()
    {
        return $this->belongsTo(TrainingCampaign::class);
    }

    // Relazione con utente - Cosimo Mandrillo
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Check se completato - Cosimo Mandrillo
    public function isCompleted()
    {
        return $this->status === 'completed';
    }
}
