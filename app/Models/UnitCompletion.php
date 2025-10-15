<?php

//REALIZZATO DA : Luigi La Gioia

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitCompletion extends Model
{
    protected $table = 'unit_completions';

    protected $fillable = ['assignment_id','unit_id','completed_at'];
    protected $casts = ['completed_at'=>'datetime'];

    public function assignment()
    {
        return $this->belongsTo(TrainingAssignment::class, 'assignment_id');
    }
    public function unit()
    {
        return $this->belongsTo(TrainingUnit::class, 'unit_id');
    }
}
