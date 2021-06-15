<?php

namespace App\Http\Controllers;

use App\Models\TrabajoMaterial;
use App\Models\Trabajo;
use App\Models\Material;
use App\Models\NegocioMaterial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TrabajoMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'trabajo_id' => 'required|integer',
            'material_id' => 'required|integer',
            'cantidad' => 'required|integer|min:1',
            //'precio' => 'required|integer|min:1',
        ]);


        $trabajo = Trabajo::find($request->trabajo_id);
        $negocio_material = NegocioMaterial::where('material_id',$request->material_id)->with("material")->first();

        $material = new TrabajoMaterial;

        $material->trabajo_id  = $trabajo->id;
        $material->negocio_material_id  = $negocio_material->negocio_id;
        $material->material_id  = $negocio_material->material_id;
        $material->cantidad  = $request->cantidad;

        $material->precio  = $negocio_material->precio;
       // $material->precio  = $request->precio;

        $material->save();

        $data = $material->refresh()->toArray();
        $data["material"]["nombre"] = $negocio_material->material->nombre;
        $data["material"]["marca"] = $negocio_material->material->marca;
        $data["material"]["modelo"] = $negocio_material->material->modelo;
        return response()->json([
            'material' => $data
        ], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrabajoMaterial  $trabajoMaterial
     * @return \Illuminate\Http\Response
     */
    public function show(TrabajoMaterial $trabajoMaterial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrabajoMaterial  $trabajoMaterial
     * @return \Illuminate\Http\Response
     */
    public function edit(TrabajoMaterial $trabajoMaterial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'cantidad' => 'integer|min:1',
            'precio' => 'integer|min:1',
        ]);
        $user = Auth::user();

        $material = TrabajoMaterial::find($id);

        if ($request->filled('cantidad')) {
            $material->cantidad = $request->cantidad;
        }
        if ($request->filled('precio')) {
            $material->precio = $request->precio;
        }

        $material->save();
        $data = $material->refresh()->toArray();
        return response()->json([
            'material' => $data
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();

        TrabajoMaterial::destroy($id);
        return response()->json([
            'material' => $id
        ], 200);
    }
}
