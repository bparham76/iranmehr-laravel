<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;

class SettingsController extends Controller
{
    public function SetSettings(Request $request){
        $data = $request->validate(['name' => 'string|required|max:64', 'content' => 'string|required']);
        Settings::updateOrCreate(['name' => $data['name']], ['value' => $data['content']]);
    }

    public function GetSettings(Request $request){
        $data = $request->validate(['name'=>'string|required|max:64']);

        $res = Settings::where('name', '=', $data['name'])->get('value')->firstOrFail();
        return $res['value'];
    }
}
