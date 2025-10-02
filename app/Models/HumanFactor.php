<?php

//REALIZZATO DA LUIGI LA GIOIA

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HumanFactor extends Model
{
    use HasFactory;
    public function users()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('value')
                    ->withTimestamps();
    }

    public function vulnerabilities()
    {
        return $this->belongsToMany(Vulnerability::class, 'human_factor_vulnerability')
                    ->withPivot('impact_level', 'notes')
                    ->withTimestamps();
    }

    public function scopeHighImpact($query)
    {
        return $query->whereHas('users', function ($q) {
            $q->where('value', '>=', '1.5');
        });
    }

    public function averageValue()
    {
        return $this->users()->avg('value') ?? 0;
    }
}
