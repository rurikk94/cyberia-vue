<?php

namespace App\Http\Controllers;

use App\Models\MetadatosCliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MetadatosClienteController extends Controller
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
            'key' => 'required|string|max:100',
            'value' => 'required|string|max:100',
            'cliente_id' => 'required|integer',
        ]);


        $metadato = new MetadatosCliente;
        //$user = Auth::user();

        $metadato->key = $request->key;
        $metadato->value = $request->value;
        $metadato->cliente_id = $request->cliente_id;

        $metadato->save();

        $data = $metadato->refresh()->toArray();
        return response()->json([
            'metadato' => $data
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MetadatosCliente  $metadatosCliente
     * @return \Illuminate\Http\Response
     */
    public function show(MetadatosCliente $metadatosCliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MetadatosCliente  $metadatosCliente
     * @return \Illuminate\Http\Response
     */
    public function edit(MetadatosCliente $metadatosCliente)
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
            'value' => 'required|string|max:100',
        ]);

        $metadato = MetadatosCliente::find($id);
        $user = Auth::user();

        $metadato->value = $request->value;

        $metadato->save();

        $data = $metadato->refresh()->toArray();
        return response()->json([
            'metadato' => $data
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MetadatosCliente  $metadatosCliente
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        //
        $user = Auth::user();

        MetadatosCliente::destroy($id);
        return response()->json([
            'metadato' => $id
        ], 200);
    }
}
