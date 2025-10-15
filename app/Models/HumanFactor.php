<?php
<<<<<<< Updated upstream

<<<<<<< Updated upstream
//REALIZZATO DA: Andrea Amodeo
=======
//REALIZZATO DA LUIGI LA GIOIA
=======
//REALIZZATO DA: Andrea Amodeo
>>>>>>> Stashed changes
>>>>>>> Stashed changes

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HumanFactor extends Model
{
<<<<<<< Updated upstream
    use HasFactory;

<<<<<<< Updated upstream
    protected $fillable = [
        'name',
        'level',
        'description',
    ];
=======
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
=======
    protected $fillable = ['name', 'description'];

   public function vulnerabilities()
   {
       return $this->belongsToMany(Vulnerability::class, 'human_factor_vulnerability');
   }

   public function users()
   {
       return $this->belongsToMany(User::class, 'user_hf_vuln')->withPivot('vuln_id', 'score')->withTimestamps();
   }
>>>>>>> Stashed changes
>>>>>>> Stashed changes
}
