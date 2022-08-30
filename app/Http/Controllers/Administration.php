<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Support\Facades\Hash;
use App\Models\User;

use function GuzzleHttp\Promise\exception_for;

class Administration extends Controller
{
    public function register(Request $request){

        $data = $request->validate([
            'first_name' => 'required|string|max:64',
            'last_name' => 'required|string|max:64',
            'role' => 'required|digits:1',
            'phone' => 'nullable|digits:11',
            'username' => 'string|required|unique:users,username|max:64',
            'email' => 'string|nullable|unique:users,email|max:64',
            'password' => 'string|required|confirmed|max:64'
        ]);

        $user = User::create($data);
        $token = $user->createToken('iranmehr-webapp')->plainTextToken;

        return response([
            'user_data' => $user,
            'token' => $token
        ], 201);
    }

    public function login(Request $request){
        $data = $request->validate([
            'username' => 'string|required',
            'password' => 'string|required'
        ]);

        $user = User::where('username', $data['username'])->first();
        
        if(!$user || $user->password !== $data['password']){
            return response([
                'message' => 'user not found'
            ], 401);
        }

        $token = $user->createToken('iranmehr-webapp')->plainTextToken;

        return response([
            'user_data' => $user,
            'token' => $token
        ], 202);
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        return ['message' => 'logged out successfully'];
    }

    public function updateUserInfo(Request $request){
        $data = $request->validate([
            'first_name' => 'required|string|max:32',
            'last_name' => 'required|string|max:32',
            'email' => 'nullable|string|unique:users,email',
            'phone' => 'nullable|digits:11|unique:users,phone',
            'role' => 'required|digit'
        ]);
        
        $user = User::where('username', '=', $data['username'])->first();
        
        if(!isset($user) || empty($user))
            return response([
                "message" => "user not found"
            ], 404);

        $user->update($data);
        
        return response(['user_data' => $user], 201);
    }

    public function getUserData(Request $request){
        $data = $request->validate(['user_id' => 'string|required']);
        
        $user = User::where('id', '=', $data['user_id'])->first();

        if(!isset($user) || empty($user))
            return response(['message' => 'user not found'], 403);

        return response(['user_data' => $user], 202);
    }

    public function getAllUsers(Request $request){
        $users = User::all();
        return response(['all_users' => $users], 202);
    }

    public function deleteUser(Request $request){
        $data = $request->validate(['id'=>'numeric|required']);
        User::where('id', $data['id'])->delete();

        // $request->validate(['id'=>'numeric|required']);
        // User::where('id', $request->get('id'))->first();
    }
}
