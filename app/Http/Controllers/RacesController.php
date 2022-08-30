<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Races;

class RacesController extends Controller
{
    public function Add(Request $request){
        $data = $request->validate(['name' => 'string|required|unique:races,name', 'animal_id' => 'integer|required']);
        Races::create($data);
    }
    
    public function Get(Request $request){
        $data = $request->validate(['id' => 'required|integer']);
        return Races::find($data['id'])['name'];
    }
    
    public function Remove(Request $request){
        $data = $request->validate(['id' => 'required|integer']);
        Races::find($data['id'])->delete();
    }
}
