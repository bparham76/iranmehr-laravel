<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Owner;

class OwnersController extends Controller
{
    public function CreateOwner(Request $request){
        try{
            $data = $request->validate([
                'firstName'=>'string|required',
                'lastName'=>'string|required',
                'gender'=>'digits:1|required',
                'phone'=>'digits:11|required|unique:owners,phone',
            ]);

            $owner = Owner::create($data);

            return response(['message'=>'new owner created', 'owner_data' => $owner], 201);
        }catch(\Throwable $error){
            return response(['message'=>'error creating new owner'], 503);
        }
    }

    public function FindOwner(Request $request){
        try{
            $data = $request->validate(['search' => 'string|nullable']);
            // if(strlen($data['search']) == 0) $data['search'] = '';
            $result = Owner::where('firstName', 'like', '%'.$data['search'].'%')->orWhere('lastName', 'like', '%'.$data['search'].'%')->orWhere('phone', 'like', '%'.$data['search'].'%')->get();
            return response(['search_data'=>$result], 200);
        }catch(\Throwable $error){
            return response(['message'=>'error finding the owner'], 503);
        }
    }
}
