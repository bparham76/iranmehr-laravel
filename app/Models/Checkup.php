<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;

class Checkup extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'sympthoms',
        'diagnosis',
        'treatment',
        'day',
        'month',
        'year'
    ];

    public $timestamps = false;

    public function patient(){
        return $this->hasOne(Patient::class, 'id', 'patient_id');
    }
}
