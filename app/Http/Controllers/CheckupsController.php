<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkup;
use App\Models\Owner;
use App\Models\Patient;
use PhpParser\Node\Stmt\TryCatch;

use function PHPUnit\Framework\returnSelf;

class CheckupsController extends Controller
{
    public function CreateCheckUp(Request $request)
    {
        try {
            $data = $request->validate([
                'patient_id' => 'required|string',
                'sympthoms' => 'required|string',
                'diagnosis' => 'required|string',
                'treatment' => 'required|string',
                'day' => 'required|integer',
                'month' => 'required|integer',
                'year' => 'required|integer'
            ]);

            $checkup = Checkup::create($data);

            return response([
                'message' => 'check up session created successfully.'
            ], 201);
        } catch (\Throwable $error) {
            return response([
                'message' => 'failed to create a new checkup session'
            ], 503);
        }
    }

    public function GetAllCheckups(Request $request)
    {
        $checkups = Checkup::all();
        $res = [];
        foreach ($checkups as $c) {
            $res[] = [
                'patient_name' => $c->patient->name,
                'patient_gender' => $c->patient->gender == 0 ? 'نر' : 'ماده',
                'patient_age' => $c->patient->age,
                'owner_name' => $c->patient->owner->firstName . ' ' . $c->patient->owner->lastName,
                'year' => $c->year,
                'month' => $c->month,
                'day' => $c->day
            ];
        }
        return $res;
    }

    public function FindCheckupsByPatientName(Request $request)
    {
        $patientName = $request->validate(['name' => 'string|required'])['name'];
        $patients = Patient::where('name', 'like', '%' . $patientName . '%')->get();
        $checkups = [];
        foreach ($patients as $p) {
            $t_c = $p->checkups()->orderBy('year', 'desc')->orderBy('month', 'desc')->orderBy('day', 'desc')->get();
            foreach ($t_c as $c) {
                $checkups[] = [
                    'id' => $c->id,
                    'name' => $p->name,
                    'owner' => $p->owner->firstName . ' ' . $p->owner->lastName,
                    'age' => $p->age,
                    'gender' => $p->gender == 0 ? 'نر' : 'ماده',
                    'type' => $p->type()->get(['name'])[0]->name,
                    'race' => $p->race()->get(['name'])[0]->name,
                    'date' => $c->year . '/' . $c->month . '/' . $c->day,
                    'sympthoms' => $c->sympthoms,
                    'diagnosis' => $c->diagnosis,
                    'treatment' => $c->treatment
                ];
            }
        }
        return $checkups;
    }

    public function FindCheckupsByOwnerName(Request $request)
    {
        $ownerName = $request->validate(['name' => 'string|required'])['name'];
        $owners = Owner::where('firstName', 'like', '%' . $ownerName . '%')->orWhere('lastName', 'like', '%' . $ownerName . '%')->get();
        $checkups = [];
        foreach ($owners as $o) {
            foreach ($o->patients as $p) {
                $t_c = $p->checkups()->orderBy('year', 'desc')->orderBy('month', 'desc')->orderBy('day', 'desc')->get();
                foreach ($t_c as $c) {
                    $checkups[] = [
                        'id' => $c->id,
                        'name' => $p->name,
                        'owner' => $o->firstName . ' ' . $o->lastName,
                        'age' => $p->age,
                        'gender' => $p->gender == 0 ? 'نر' : 'ماده',
                        'type' => $p->type()->get(['name'])[0]->name,
                        'race' => $p->race()->get(['name'])[0]->name,
                        'date' => $c->year . '/' . $c->month . '/' . $c->day,
                        'sympthoms' => $c->sympthoms,
                        'diagnosis' => $c->diagnosis,
                        'treatment' => $c->treatment
                    ];
                }
            }
        }
        return $checkups;
    }

    public function FindCheckupsByDate(Request $request)
    {
    }
}
