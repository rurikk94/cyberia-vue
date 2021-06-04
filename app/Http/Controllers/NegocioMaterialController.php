<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Negocio;
use App\Models\Material;
use App\Models\NegocioMaterial;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class NegocioMaterialController extends Controller
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
     * @param  int  $id negocio
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $validated = $request->validate([
            'material' => 'required|integer',
            'precio' => 'required|integer',
        ]);


        $user = Auth::user();


        $materiales_negocio = NegocioMaterial::where('negocio_id', $id)
        ->where('electricista_id', $user->id)
        ->where('material_id', $request->material)
        ->first();

        if ( $materiales_negocio )
            return response()->json([
                'material' => $materiales_negocio
            ], 401);


        $material = new NegocioMaterial;

        $material->electricista_id = $user->id;
        $material->material_id = $request->material;
        $material->negocio_id = $id;
        $material->precio = $request->precio;

        $material->save();
        $material->refresh();

        $materiales_negocio = NegocioMaterial::find($material->id)
            ->where('electricista_id', $user->id)
            ->where('negocio_id', $id)
            ->with('material')->get();


        $data = $materiales_negocio->toArray();
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
        $user = Auth::user();
        $negocio = Negocio::find($id);
        $materiales = Material::where('electricista_id', $user->id)->get();
        $materiales_negocio = NegocioMaterial::where('negocio_id', $negocio->id)
            ->where('electricista_id', $user->id)
            ->with('material')
            ->get();

        //return view('negocios.index')->with('negocios', $negocios);
        return Inertia::render('NegociosMaterial',[
            'negocio' => $negocio,
            'materiales' => $materiales,
            'materiales_negocio' => $materiales_negocio
        ]);
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
            'precio' => 'required|integer',
        ]);

        $material = NegocioMaterial::find($id);
        $user = Auth::user();

        $material->precio = $request->precio;
        //$negocio->electricista_id = $user->id;

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
        //$negocios = Negocio::where('electricista_id', $user->id)->get();
        NegocioMaterial::destroy($id);
        return response()->json([
            'material' => $id
        ], 200);
    }
}
