<?php

// MODIFICATO DA: Andrea Amodeo
// MODIFICATO DA: Luigi La Gioia

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Concerns\InteractsWithPivotTable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'gender',
        'dob',
        'email',
        'password',
        'role',
        'company_role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'Admin';
    }

    public function fullName(): string
    {
        return $this->name . ' ' . $this->surname;
    }

    public function age(): int
    {
        return Carbon::parse($this->dob)->age;
    }

    //AGGIUNTO DA Andrea Amodeo
    public function humanFactors(): BelongsToMany
    {
        return $this->belongsToMany(HumanFactor::class, 'user_human_factor')
            ->withPivot(['debt_level'])
            ->withTimestamps();
    }

    //AGGIUNTO DA LUIGI LA GIOIA
    public function trainingAssignments(): HasMany
    {
        return $this->hasMany(\App\Models\TrainingAssignment::class, 'user_id');
    }

    //AGGIUNTO DA LUIGI LA GIOIA
    public function trainingCampaigns()
    {
         return $this->belongsToMany(
            \App\Models\TrainingCampaign::class,
            'training_assignments',
            'user_id',
            'campaign_id'
        )
        ->withPivot(['status', 'assigned_at', 'completed_at'])
        ->withTimestamps();
    }

    //AGGIUNTO DA LUIGI LA GIOIA
    public function unitCompletions(): HasMany
    {
        return $this->hasMany(\App\Models\UnitCompletion::class, 'user_id');
    }

    //AGGIUNTO DA LUIGI LA GIOIA
    public function notifications(): HasMany
    {
        return $this->hasMany(\App\Models\Notification::class, 'user_id');
    }

    //AGGIUNTO DA LUIGI LA GIOIA
    private function countCampaignUnits(int $campaignId): array
    {
        $total = \App\Models\TrainingUnit::where('campaign_id', $campaignId)->count();

        $done = $this->unitCompletions()
            ->whereIn('unit_id', function ($query) use ($campaignId) {
                $query->from((new \App\Models\TrainingUnit)->getTable())
                    ->select('id')
                    ->where('campaign_id', $campaignId);
            })
            ->count();

        return ['total' => $total, 'done' => $done];
    }

    //AGGIUNTO DA LUIGI LA GIOIA
    public function hasCompletedCampaign(int $campaignId): bool
    {
        $counts = $this->countCampaignUnits($campaignId);

        if ($counts['total'] === 0) {
            return false;
        }

        return $counts['done'] >= $counts['total'];
    }

    //AGGIUNTO DA LUIGI LA GIOIA
    public function campaignProgress(int $campaignId): int
    {
        $counts = $this->countCampaignUnits($campaignId);

        if ($counts['total'] === 0) {
            return 0;
        }

        return (int) floor(($counts['done'] * 100) / $counts['total']);
    }

    public function role()
    {
    return $this->belongsTo(\App\Models\Role::class, 'role_id');
    }
}
