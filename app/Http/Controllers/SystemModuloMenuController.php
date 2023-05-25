<?php

namespace App\Http\Controllers;

use App\Models\SystemModuloMenu;
use Illuminate\Http\Request;
use App\Http\Requests\SystemModuloMenuCreateRequest;
use App\Http\Requests\SystemModuloMenuUpdateRequest;

class SystemModuloMenuController extends Controller
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
    public function store(SystemModuloMenuCreateRequest $request)
    {
        $validated = $request->validated();
        $systemModuloMenu = SystemModuloMenu::create($validated);

        return response()->json($systemModuloMenu, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(SystemModuloMenu $systemModuloMenu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SystemModuloMenu $systemModuloMenu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SystemModuloMenu $systemModuloMenu)
    {
        //
    }
}
