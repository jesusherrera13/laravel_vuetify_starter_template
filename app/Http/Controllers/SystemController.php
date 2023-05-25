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

    public function usuarios(Request $request)
    {

        $response = [];
        $system_administrador = SystemAdministrador::find(auth()->user()->id);

        if($system_administrador) {
            $response = DB::table("users as user")
                        ->select("user.id","user.name","user.email","admin.id as is_admin","urol.rol_id","rol.nombre as rol")
                        ->leftJoin("system_administradores as admin","admin.user_id", "user.id")
                        ->leftJoin("users_roles as urol","urol.user_id", "user.id")
                        ->leftJoin("system_roles as rol","rol.id", "urol.rol_id")
                        ->get();
        }
        else {

            $propietario = CuentaUsuario::where("user_id", auth()->user()->id)->first();
            
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
