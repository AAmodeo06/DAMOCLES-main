<?php
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
// Realizzato da: Luigi La Gioia
=======

//REALIZZATO DA: Luigi La Gioia
>>>>>>> Stashed changes
=======

//REALIZZATO DA: Luigi La Gioia
>>>>>>> Stashed changes
=======

//REALIZZATO DA: Luigi La Gioia
>>>>>>> Stashed changes

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
    use HasFactory;
=======
    protected $table = 'notifications';
>>>>>>> Stashed changes
=======
    protected $table = 'notifications';
>>>>>>> Stashed changes
=======
    protected $table = 'notifications';
>>>>>>> Stashed changes

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
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
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
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
    {
        return $this->belongsTo(User::class);
    }

<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(TrainingCampaign::class, 'campaign_id');
    }

<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
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
=======
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
    public function markAsRead(): void
    {
        if (is_null($this->read_at)) $this->update(['read_at' => now()]);
    }

    public function scopeUnread($q): bool
    {
        return $q->whereNull('read_at');
<<<<<<< Updated upstream
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
    }
}
