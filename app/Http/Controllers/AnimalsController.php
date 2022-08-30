<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animals;

class AnimalsController extends Controller
{
    public function All(Request $request){
        return Animals::all();
    }

    public function Add(Request $request){
        $data = $request->validate(['name' => 'required|string|unique:animals,name']);
        Animals::create($data);
    }
    
    public function Get(Request $request){
        $data = $request->validate(['id' => 'integer|required']);
        return Animals::find($data['id'])['name'];
    }
    
    public function Remove(Request $request){
        $data = $request->validate(['id' => 'required|integer']);
        return Animals::find($data['id'])->delete();
    }

    public function GetAnimalRaces(Request $request){
        $data = $request->validate(['id' => 'required|integer']);
        return Animals::find($data['id'])->races;
    }
}
