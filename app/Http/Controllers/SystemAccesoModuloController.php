<?php

namespace App\Http\Controllers;

use App\Models\SystemAccesoModulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SystemAccesoModuloController extends Controller
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
    public function show(SystemAccesoModulo $systemAccesoModulo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SystemAccesoModulo $systemAccesoModulo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SystemAccesoModulo $systemAccesoModulo)
    {
        //
    }

    public function setup(Request $request)
    {
        foreach($request['selected_modules'] as $modulo_id) {
            
            $validator = Validator::make(['user_id' => $request['user_id'], 'modulo_id' => $modulo_id], [
                'user_id' => 'required',
                'modulo_id' => 'required',
            ]);

            $validated = $validator->validated();

            SystemAccesoModulo::create($validated);
        }

        return response()->json(["message" => "Accesos actualizados"]);
    }
}
