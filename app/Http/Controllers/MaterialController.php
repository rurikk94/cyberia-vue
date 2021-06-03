<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = Auth::user();
        $materiales = Material::where('electricista_id', $user->id)->get();

        //return view('materiales.index')->with('materiales', $materiales);
        return Inertia::render('Materiales',[
            'materiales' => $materiales
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:191',
            'marca' => 'required|string|max:191',
            'modelo' => 'required|string|max:191',
        ]);


        $material = new Material;
        $user = Auth::user();

        $material->nombre = $request->nombre;
        $material->marca = $request->marca;
        $material->modelo = $request->modelo;
        $material->electricista_id = $user->id;

        $material->save();

        $data = $material->refresh()->toArray();
        return response()->json([
            'material' => $data
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:191',
            'marca' => 'required|string|max:191',
            'modelo' => 'required|string|max:191',
        ]);

        $material = Material::find($id);
        $user = Auth::user();

        $material->nombre = $request->nombre;
        $material->marca = $request->marca;
        $material->modelo = $request->modelo;

        $material->save();

        $data = $material->refresh()->toArray();
        return response()->json([
            'material' => $data
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        $user = Auth::user();

        Material::destroy($id);
        return response()->json([
            'material' => $id
        ], 200);
    }
}
