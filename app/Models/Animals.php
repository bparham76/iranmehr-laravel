<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Races;
use App\Models\Patient;

class Animals extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name'];

    public function races(){
        return $this->hasMany(Races::class, 'animal_id');
    }

    public function patients(){
        return $this->hasMany(Patient::class, 'type', 'id');
    }

    public function delete()
    {
        $this->races()->delete();
        parent::delete();
    }
}
