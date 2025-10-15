<?php

//REALIZZATO DA: Andrea Amodeo

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingUnit extends Model
{
    protected $table = 'training_units';

    protected $fillable = [
        'campaign_id',
        'content_type',
        'content_body',
        'order_index',
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(TrainingCampaign::class, 'campaign_id');
    }

    public function completions(): HasMany
    {
        return $this->hasMany(UnitCompletion::class, 'unit_id');
    }

    public function isAudio(): bool
    {
        return $this->content_type === 'audio';
    }
}
