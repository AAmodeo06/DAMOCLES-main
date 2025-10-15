<?php

// REALIZZATO DA: Andrea Amodeo

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class HumanFactor extends Model
{
    protected $fillable = ['name','slug','description'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_human_factor')
            ->withPivot(['debt_level'])
            ->withTimestamps();
    }

     public function vulnerabilities()
    {
        return $this->belongsToMany(Vulnerability::class, 'human_factor_vulnerability')
            ->withTimestamps();
    }

    public function getDebtLevelForUser($userId): ?string
    {
        $pivot = $this->users()->where('user_id', $userId)->first()?->pivot;
        return $pivot?->debt_level;
    }

    public function usersWithMinDebt(string $minLevel = 'medium')
    {
        $rank = ['none'=>0,'low'=>1,'medium'=>2,'high'=>3,'max'=>4];
        $minLevel = strtolower($minLevel);
        if (!array_key_exists($minLevel, $rank)) $minLevel = 'medium';
        $allowedLevels = array_keys(array_filter($rank, fn($v) => $v >= $rank[$minLevel]));
        return $this->users()->wherePivotIn('debt_level', $allowedLevels)->get();
    }
}
