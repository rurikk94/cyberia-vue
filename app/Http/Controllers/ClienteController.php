<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\MetadatosCliente;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class ClienteController extends Controller
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
        $clientes = Cliente::where('electricista_id', $user->id)->get();

        return Inertia::render('Clientes',[
            'clientes' => $clientes
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
            'nombres' => 'required|string|max:191',
            'apellidos' => 'required|string|max:191',
        ]);


        $cliente = new Cliente;
        $user = Auth::user();

        $cliente->nombres = $request->nombres;
        $cliente->apellidos = $request->apellidos;
        $cliente->electricista_id = $user->id;

        $cliente->save();
        $data = $cliente->refresh()->toArray();

        if ($request->hasAny(['telefono', 'email']))
        {

            if ($request->filled('telefono'))
            {
                $metadato = new MetadatosCliente;
                $metadato->key = 'telefono';
                $metadato->value = $request->telefono;
                $metadato->cliente_id = $data["id"];

                $metadato->save();

            }

            if ($request->filled('email'))
            {
                $metadato = new MetadatosCliente;
                $metadato->key = 'email';
                $metadato->value = $request->email;
                $metadato->cliente_id = $data["id"];

                $metadato->save();

            }
        }



        return response()->json([
            'cliente' => $data
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
        $cliente = Cliente::where('id', $id)
            ->with('metadatos')
            ->with('trabajos')
            ->first();

        if( !$cliente || $cliente->electricista_id != $user->id)
        return response()->json([
            'message' => 'Error: the cliente no existe.'], 412);

        //$cliente_metadatos = MetadatosCliente::find($id);

        return Inertia::render('Cliente',[
            'cliente' => $cliente
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
            'nombres' => 'required|string|max:191',
            'apellidos' => 'required|string|max:191',
        ]);

        $cliente = Cliente::find($id);
        $user = Auth::user();

        $cliente->nombres = $request->nombres;
        $cliente->apellidos = $request->apellidos;

        $cliente->save();

        $data = $cliente->refresh()->toArray();
        return response()->json([
            'cliente' => $data
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

        Cliente::destroy($id);
        return response()->json([
            'cliente' => $id
        ], 200);
    }
}
