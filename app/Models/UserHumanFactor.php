<?php
// Implementato da: Andrea Amodeoù

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserHumanFactor extends Pivot
{
    protected $table = 'user_hf_vuln';

    protected $fillable = ['user_id', 'hf_id', 'vuln_id', 'score'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function humanFactor()
    {
        return $this->belongsTo(HumanFactor::class, 'hf_id');
    }

    public function vulnerability()
    {
        return $this->belongsTo(Vulnerability::class, 'vuln_id');
    }
}
