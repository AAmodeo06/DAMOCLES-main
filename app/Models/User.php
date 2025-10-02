<?php
//MODIFICATO DA LUIGI LA GIOIA

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

    //AGGIUNTO DA LUIGI LA GIOIA
    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class, 'campaign_user')
            ->withPivot('status', 'completion_date', 'score')
            ->withTimestamps();
    }

    //AGGIUNTO DA LUIGI LA GIOIA
    public function riskProfile()
    {
        return $this->hasOne(UserRiskProfile::class);
    }

    //AGGIUNTO DA LUIGI LA GIOIA
    public function securityIncidents()
    {
        return $this->hasMany(SecurityIncident::class);
    }

    //AGGIUNTO DA LUIGI LA GIOIA
    public function calculateRiskLevel()
    {
        if (!$this->riskProfile) {
            return 'unknown';
        }

        $score = $this->riskProfile->overall_risk_score;

        if ($score >= 70) return 'high';
        if ($score >= 40) return 'medium';
        return 'low';
    }

}
