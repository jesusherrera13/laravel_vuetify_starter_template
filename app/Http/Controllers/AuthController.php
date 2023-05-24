<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SystemAdministrador;
use App\Models\SystemModulo;
use App\Models\SystemModuloMenu;
use App\Models\Cuenta;
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

        // $token = $user->createToken('myapptoken')->plainTextToken;
        if($request['cuenta_id']) {
            $cuenta = Cuenta::find($request['cuenta_id']);

            CuentaUsuario::create([
                'cuenta_id' => $request['cuenta_id'],
                'user_id' => $user->id,
                'rol_id' => 2,
                'propietario_id' => $cuenta->user_id,
            ]);
        }

        $response = [
            'user' => $user,
            // 'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request) {

        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        
        $user = User::where('email', $fields['email'])->first();
        $user->tokens()->delete();

        if(!$user || !Hash::check($fields['password'], $user->password)) {
            
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $system_modulos = [];
        $administrador = SystemAdministrador::where("user_id", $user->id)->first();

        if($administrador) {
            $system_modulos = SystemModulo::all();

            foreach($system_modulos as $k => $row) {
                
                $system_modulos[$k]['menus'] = SystemModuloMenu::where("modulo_id", $row->id)->get();
            }
        }
        else {
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
            $fields = $request->validate([
                'name' => 'required',
            ]);

            $validated = [
                'name' => $fields['name'],
            ];
        }

        $user->update($validated);



        $cuenta_usuario = CuentaUsuario::where("user_id", $user->id);
        $request['user_id'] = $user->id;
        // dd($request);

        $fields = $request->validate([
            'cuenta_id' => 'required',
            'user_id' => 'required',
            'rol_id' => 'required',
            'propietario_id' => 'required',
        ]);

        if($cuenta_usuario) {

            $cuenta_usuario->update([
                'cuenta_id' => $fields['cuenta_id'],
                'user_id' => $fields['user_id'],
                'rol_id' => $fields['rol_id'],
                'propietario_id' => $fields['propietario_id'],
            ]);
        }
        else {

            $cuenta_usuario = CuentaUsuario::create([
                'cuenta_id' => $fields['cuenta_id'],
                'user_id' => $fields['cuenta_id'],
                'rol_id' => $fields['rol_id'],
                'propietario_id' => $fields['propietario_id'],
            ]);
        }




        return response()->json([
            'message' => 'User updated'
        ]);
    }
}
