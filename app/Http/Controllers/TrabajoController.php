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
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show_estado()
    {
        /* $user = Auth::user();
        $trabajo = Trabajo::where('id',$id)
            ->with('cliente')->with('cliente.metadatos')->with('documentos')
            ->get();

        $agendamientos = Agendamiento::where('trabajo_id',$id)
            ->orderBy('fecha_hora_inicio')
            ->get();

        $trabajo = $trabajo->toArray()[0];
        $trabajo["potencia"] = json_decode($trabajo["potencia"]); */


        return Inertia::render('EstadoTrabajo',[
            /* 'trabajo' => $trabajo,
            'agendamientos' => $agendamientos, */
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function get_estado(Request $request)
    {
        $validated = $request->validate([
            'codigo_trabajo' => 'required|string',
        ]);

        //$user = Auth::user();
        $trabajo = Trabajo::where('codigo_trabajo',$request->codigo_trabajo)
            ->with('cliente')->with('cliente.metadatos')->with('documentos')
            ->with('electricista')->with('electricista.metadato')
            ->first();

        $agendamientos = Agendamiento::where('trabajo_id',$trabajo->id)
            ->orderBy('fecha_hora_inicio')
            ->get();

        $trabajo = $trabajo->toArray();
        $trabajo["potencia"] = json_decode($trabajo["potencia"]);

        return response()->json([
            'trabajo' => $trabajo,
            'agendamientos' => $agendamientos,
        ], 200);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update_descripcion(Request $request, $id)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string',
        ]);
        $user = Auth::user();

        $trabajo = Trabajo::find($id);

        $trabajo->descripcion = $request->descripcion;

        $trabajo->save();
        $data = $trabajo->refresh()->toArray();
        return response()->json([
            'trabajo' => $data
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update_nombre(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre_trabajo' => 'required|string',
        ]);
        $user = Auth::user();

        $trabajo = Trabajo::find($id);

        $trabajo->nombre_trabajo = $request->nombre_trabajo;

        $trabajo->save();
        $data = $trabajo->refresh()->toArray();
        return response()->json([
            'trabajo' => $data
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update_ubicacion(Request $request, $id)
    {
        $validated = $request->validate([
            'ubicacion' => 'required|string',
        ]);
        $user = Auth::user();

        $trabajo = Trabajo::find($id);

        $trabajo->ubicacion = $request->ubicacion;

        $trabajo->save();
        $data = $trabajo->refresh()->toArray();
        return response()->json([
            'trabajo' => $data
        ], 200);
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
