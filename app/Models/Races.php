<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Animals;
use App\Models\Patient;

class Races extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'animal_id'];

    public function animal(){
        return $this->hasOne(Animals::class);
    }

    public function patients(){
        return $this->hasMany(Patient::class, 'race', 'id');
    }
}
