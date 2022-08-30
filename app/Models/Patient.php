<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Owner;
use App\Models\Animals;
use App\Models\Races;
use App\Models\Checkup;

class Patient extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'owner_id',
        'type',
        'race',
        'gender',
        'age'
    ];

    public $timestamps = false;

    public function type(){
        return $this->belongsTo(Animals::class, 'type', 'id');
    }

    public function race(){
        return $this->belongsTo(Races::class, 'race', 'id');
    }

    public function owner(){
        return $this->belongsTo(Owner::class);
    }

    public function checkups(){
        return $this->hasMany(Checkup::class, 'patient_id', 'id');
    }
}
