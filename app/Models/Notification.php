<?php
<<<<<<< Updated upstream
// Realizzato da: Luigi La Gioia

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'campaign_id',
        'message',
        'read_at'
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function user(): BelongsTo
=======
// Implementato da: Luigi La Gioia
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'content',
        'isVisualized',
        'type',
        'related_id', // ID della training session o campagna correlata
    ];

    protected $casts = [
        'isVisualized' => 'boolean',
    ];

    // Relazione con utente - Luigi La Gioia
    public function user()
>>>>>>> Stashed changes
    {
        return $this->belongsTo(User::class);
    }

<<<<<<< Updated upstream
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(TrainingCampaign::class, 'campaign_id');
    }

    public function isRead(): bool
    {
        return !is_null($this->read_at);
=======
    // Scope per non lette - Luigi La Gioia
    public function scopeUnread($query)
    {
        return $query->where('isVisualized', false);
    }

    // Scope per tipo - Luigi La Gioia
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Crea notifica per nuova training session - Luigi La Gioia
    public static function createTrainingNotification($userId, $trainingSessionId, $campaignTitle)
    {
        return self::create([
            'user_id' => $userId,
            'content' => "Nuova campagna di training disponibile: {$campaignTitle}",
            'type' => 'new_training',
            'related_id' => $trainingSessionId,
            'isVisualized' => false,
        ]);
>>>>>>> Stashed changes
    }
}
