<?php

namespace App\Http\Controllers;

use App\Models\System;
use App\Models\User;
use App\Models\CuentaUsuario;
use App\Models\SystemAdministrador;
use App\Models\SystemModulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SystemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(System $system)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, System $system)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(System $system)
    {
        //
    }

    public function users(Request $request)
    {
        $response = [];
        $administrador = SystemAdministrador::find($request['id_usuario']);

        if($administrador) {
            $response = DB::table("users as user")
                        ->select("user.id","user.name","user.email","admin.id as is_admin","cuenta.id as cuenta_id")
                        ->leftJoin("system_administradores as admin","admin.user_id", "user.id")
                        ->leftJoin("cuentas as cuenta","cuenta.user_id", "user.id")
                        ->get();
        }
        else {

            $propietario = CuentaUsuario::where("user_id", $request['id_usuario'])->first();
            
            if($propietario) {
                if($propietario->rol_id == 1) {

                    $response = DB::table("cuentas_usuarios as cuser")
                                ->select("user.id","user.name","user.email","cuenta.id as cuenta_id","cuser.rol_id","rol.nombre as rol")
                                ->join("users as user","user.id", "cuser.user_id")
                                ->join("cuentas as cuenta","cuenta.user_id", "cuser.propietario_id")
                                ->join("system_roles as rol","rol.id", "cuser.rol_id")
                                ->where("cuser.cuenta_id", $propietario->cuenta_id)
                                ->get();
                }
            }
        }

        return response()->json($response, 200);
    }

    public function systemModulos() {
        return response()->json(SystemModulo::with("menus")->get(), 200);
    }
}
