<?php

namespace App\Http\Controllers;

use App\Models\SystemModulo;
use Illuminate\Http\Request;
use App\Http\Requests\SystemModuloCreateRequest;
use App\Http\Requests\SystemModuloUpdateRequest;

class SystemModuloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(SystemModulo::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SystemModuloCreateRequest $request)
    {
        $validated = $request->validated();

        $systemModulo = SystemModulo::create($validated);

        return response()->json($systemModulo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(SystemModulo $systemModulo)
    {
        return response()->json($systemModulo->load('menus'), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SystemModuloUpdateRequest $request, SystemModulo $systemModulo)
    {
        $validated = $request->validated();
        $systemModulo->update($validated);
        
        return response()->json($systemModulo, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SystemModulo $systemModulo)
    {
        //
    }
}