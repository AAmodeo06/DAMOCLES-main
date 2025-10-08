<?php
// Realizzato da: Cosimo Mandrillo

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttackType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function campaigns(): HasMany
    {
        return $this->hasMany(TrainingCampaign::class);
    }
}
