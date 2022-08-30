<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Patient;

class Owner extends Model
{
    use HasFactory;
    protected $fillable = [
        'firstName',
        'lastName',
        'gender',
        'phone'
    ];

    public $timestamps = false;

    public function patients(){
        return $this->hasMany(Patient::class);
    }
}
