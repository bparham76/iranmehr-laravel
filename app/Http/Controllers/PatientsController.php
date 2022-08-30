<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Patient;
use App\Models\Owner;

class PatientsController extends Controller
{
    public function CreatePatient(Request $request){
        try{
            $data = $request->validate([
                'owner_id' => 'required|integer',
                'name' => 'nullable|string|max:64|unique:patients,name',
                'type' => 'required|integer',
                'race' => 'nullable|integer',
                'gender' => 'nullable|integer',
                'age' => 'nullable|integer',
            ]);

            $patient = Patient::create($data);

            return response([
                'message' => 'new patient created successfully.',
                'patient_data' => $patient
            ], 201);
        }
        catch(\Throwable $error){
            return response([
                'message' => 'error creating new patient'
            ], 503);
        }
    }

    public function GetAllPatients(Request $request){
        try {
            $patients = Patient::all();
            $result = [];
            for($i = 0; $i < count($patients); $i++){
                $result[$i] = [
                    "id" => $patients[$i]->id,
                    "name" => $patients[$i]->name,
                    "age" => $patients[$i]->age,
                    "gender" => $patients[$i]->gender,
                    "type" => $patients[$i]->type()->get(['name'])[0]->name,
                    "race" => $patients[$i]->race()->get(['name'])[0]->name,
                    "owner" => $patients[$i]->owner()->get(['firstName', 'lastName'])[0]
                ];
            }
            return response(['patients' => $result], 202);
        } catch (\Throwable $error) {
            return response([
                'message' => 'error getting patient list'
            ], 503);
        }
    }

    public function FindPatientById(Request $request){
        $id = $request->validate(['id' => 'required|integer'])['id'];
        $patient = Patient::find($id);
        return [
            'name' => $patient->name,
            'age' => $patient->age,
            'gender' => $patient->gender == 0 ? 'نر' : 'ماده',
            'race' => $patient->race()->get(['name'])[0]->name,
            'type' => $patient->type()->get(['name'])[0]->name
        ];
    }

    public function FindPatient(Request $request){
        try {
            $data = $request->validate(['search'=>'string|required', 'type'=>'numeric|required']);
            $search = [];
            
            if($data['type'] == 1){
                $tmp = Patient::where('name', 'like', '%'.$data['search'].'%')->get();
                foreach($tmp as $t){
                    $search[] = [
                        'id' => $t->id,
                        'name' => $t->name,
                        'owner_name' => $t->owner->firstName . ' ' . $t->owner->lastName
                    ];
                }
            }else{
                $owners = Owner::where('firstName', 'like', '%'.$data['search'].'%')->orWhere('lastName', 'like', '%'.$data['search'].'%')->get();
                foreach($owners as $o){
                    foreach($o->patients as $p){
                        $search[] = [
                            'id' => $p->id,
                            'name' => $p->name,
                            'owner_name' => $o->firstName . ' ' . $o->lastName
                        ];
                    }
                }
            }
            
            return response($search);
        } catch (\Throwable $th) {
            return response(['message' => 'error searching for patients or owners'], 503);
        }

    }
}
