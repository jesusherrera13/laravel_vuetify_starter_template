<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SystemAdministrador;
use App\Models\SystemModulo;
use App\Models\SystemModuloMenu;
use App\Models\SystemUserRol;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(Request $request) {

        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        if($request['rol_id']) {
            SystemUserRol::create([
                'user_id' => $user->id,
                'rol_id' => $request['rol_id'],
            ]);
        }

        $response = [
            'user' => $user,
        ];

        return response($response, 201);
    }

    public function login(Request $request) {

        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        
        $user = User::where('email', $fields['email'])->first();
        
        if($user) $user->tokens()->delete();

        if(!$user || !Hash::check($fields['password'], $user->password)) {
            
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $system_modulos = [];
        $administrador = SystemAdministrador::where("user_id", $user->id)->first();

        if($administrador) $system_modulos = SystemModulo::with("menus")->get();
        else {
            $tmp = DB::table("users_accesos_modulos")
                        ->select("modulo_id")
                        ->where("user_id",$user->id)
                        ->get();

            $cond = [];

            if($tmp->count()) {
                foreach($tmp as $row) {
                    $cond[] = $row->modulo_id;
                }
            }

            $system_modulos = SystemModulo::whereIn("id", $cond)->with("menus")->get();
        }

        $response = [
            'user' => $user,
            'token' => $token,
            'system_modulos' => $system_modulos,
        ];

        return response($response, 201);
    }

    public function logout(Request $request) {

        auth()->user()->tokens()->delete();

        return response([
            'message' => 'Logged out'
        ], 201);
    }

    public function userUpdate(Request $request, User $user) {

        $validated = [];

        if($request['password_reset']) {
            $fields = $request->validate([
                'name' => 'required',
                'password' => 'required|string|confirmed',
            ]);
            
            $validated = [
                'name' => $fields['name'],
                'password' => bcrypt($fields['password']),
            ];
        }
        else {
            $fields = $request->validate(['name' => 'required']);
            $validated = ['name' => $fields['name']];
        }

        $user->update($validated);

        if($request['rol_id']) {
            DB::table('users_roles')
                ->where("user_id",  $user->id)
                ->update(['rol_id' => $request['rol_id']]);
        }

        return response()->json([
            'message' => 'User updated'
        ]);
    }
}
