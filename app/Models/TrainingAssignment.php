<?php
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream

//REALIZZATO DA: Luigi La Gioia
=======
// Realizzato da: Luigi La Gioia
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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TrainingAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'campaign_id',
        'status',
        'progress',
        'assigned_at',
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
        'completed_at',
=======
        'completed_at'
>>>>>>> Stashed changes
=======
        'completed_at',
>>>>>>> Stashed changes
=======
        'completed_at',
>>>>>>> Stashed changes
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(TrainingCampaign::class, 'campaign_id');
    }

<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
     public function completedUnits(): BelongsToMany
=======
    public function completedUnits(): BelongsToMany
>>>>>>> Stashed changes
=======
     public function completedUnits(): BelongsToMany
>>>>>>> Stashed changes
=======
     public function completedUnits(): BelongsToMany
>>>>>>> Stashed changes
    {
        return $this->belongsToMany(TrainingUnit::class, 'unit_completions', 'assignment_id', 'unit_id')
            ->withPivot('completed_at')
            ->withTimestamps();
    }
}
