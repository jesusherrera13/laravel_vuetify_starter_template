<?php

namespace App\Http\Controllers;

use App\Models\SystemRol;
use App\Models\SystemAdministrador;
use Illuminate\Http\Request;

class SystemRolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $systemAdministrador = SystemAdministrador::where("user_id", auth()->user()->id);
        
        if($systemAdministrador) $systemRol = SystemRol::all();
        else $systemRol = SystemRol::where("id","!=", 1)->get();

        return response()->json($systemRol, 200);
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
    public function show(SystemRol $systemRol)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SystemRol $systemRol)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SystemRol $systemRol)
    {
        //
    }
}
