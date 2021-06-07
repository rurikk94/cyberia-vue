<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Trabajo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class DocumentoController extends Controller
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
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $validated = $request->validate([
            //'trabajo' => 'required|integer',
            'file' => 'required|file',
        ]);
        $user = Auth::user();

        $trabajo = Trabajo::find($id);
        $documento = new Documento;

        $documento->trabajo_id = $trabajo->id;

        $documento->nombre_original = $request->file('file')->getClientOriginalName();
        $documento->extension = $request->file('file')->extension();
        $path = Storage::putFile('documentos', $request->file('file'));
        $documento->nombre_archivo = $path;
        $documento->descripcion = $documento->nombre_original;
        $documento->documento_historial_id = null;
        $documento->peso = Storage::size($path);

        $documento->save();
        $data = $documento->refresh()->toArray();
        return response()->json([
            'documento' => $data
        ], 200);
        $a=0;
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $documento = Documento::find($id);

        return Storage::download($documento->nombre_archivo, $documento->nombre_original);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function edit(Documento $documento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Documento $documento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Documento $documento)
    {
        //
    }
}
