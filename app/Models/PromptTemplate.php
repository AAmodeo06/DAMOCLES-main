<?php

//REALIZZATO DA: Andrea Amodeo

namespace App\Models;

<<<<<<< Updated upstream
use Illuminate\Database\Eloquent\Factories\HasFactory;
=======
>>>>>>> Stashed changes
use Illuminate\Database\Eloquent\Model;

Class PromptTemplate extends Model
{
<<<<<<< Updated upstream
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'template',
    ];
=======
     protected $fillable = [
        'content',
        'content_type',
        'name',
        'description',
    ];

    public function trainingCampaigns()
    {
        return $this->hasMany(TrainingCampaign::class, 'template_id');
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('content_type', $type);
    }
>>>>>>> Stashed changes
}
