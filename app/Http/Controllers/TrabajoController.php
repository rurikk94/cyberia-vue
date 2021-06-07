<?php

namespace App\Http\Controllers;

use App\Models\Trabajo;
use App\Models\Agendamiento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class TrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $trabajos = Trabajo::where('electricista_id', $user->id)
            ->with('cliente')->with('cliente.metadatos')
            ->with('agendamientos')
            ->get();

        return Inertia::render('Trabajos',[
            'trabajos' => $trabajos
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
        //
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
        $trabajo = Trabajo::where('id',$id)
            ->with('cliente')->with('cliente.metadatos')->with('documentos')
            ->get();

        $agendamientos = Agendamiento::where('trabajo_id',$id)
            ->orderBy('fecha_hora_inicio')
            ->get();

        $trabajo = $trabajo->toArray()[0];
        $trabajo["potencia"] = json_decode($trabajo["potencia"]);


        return Inertia::render('Trabajo',[
            'trabajo' => $trabajo,
            'agendamientos' => $agendamientos,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Trabajo  $trabajo
     * @return \Illuminate\Http\Response
     */
    public function edit(Trabajo $trabajo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Trabajo  $trabajo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trabajo $trabajo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Trabajo  $trabajo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trabajo $trabajo)
    {
        //
    }
}
