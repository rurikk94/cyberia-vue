<?php

namespace App\Http\Controllers;

use App\Models\MetadatosUsuario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class MetadatosUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $electricista = User::where('id', $user->id)
            ->with('metadato')->first();

        return Inertia::render('Perfil',[
            'electricista' => $electricista
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
            'key' => 'required|string|max:100',
            'value' => 'required|string|max:100',
        ]);


        $metadato = new MetadatosUsuario;
        $user = Auth::user();

        $metadato->key = $request->key;
        $metadato->value = $request->value;
        $metadato->user_id = $user->id;

        $metadato->save();

        $data = $metadato->refresh()->toArray();
        return response()->json([
            'metadato' => $data
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MetadatosUsuario  $metadatosUsuario
     * @return \Illuminate\Http\Response
     */
    public function show(MetadatosUsuario $metadatosUsuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MetadatosUsuario  $metadatosUsuario
     * @return \Illuminate\Http\Response
     */
    public function edit(MetadatosUsuario $metadatosUsuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MetadatosUsuario  $metadatosUsuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'value' => 'required|string|max:100',
        ]);

        $metadato = MetadatosUsuario::find($id);
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
     * @param  \App\Models\MetadatosUsuario  $metadatosUsuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = Auth::user();

        MetadatosUsuario::destroy($id);
        return response()->json([
            'metadato' => $id
        ], 200);
    }
}
