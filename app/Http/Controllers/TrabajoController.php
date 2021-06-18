<?php

namespace App\Http\Controllers;

use App\Models\Trabajo;
use App\Models\Agendamiento;
use App\Models\Cliente;
use App\Models\TrabajoMaterial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;

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
        $clientes = Cliente::where('electricista_id', $user->id)->get();

        return Inertia::render('Trabajos',[
            'trabajos' => $trabajos,
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
            'nombre_trabajo' => 'required|string|max:191',
            'ubicacion' => 'required|string|max:191',
            'descripcion' => 'required|string|max:191',
            'cliente_id' => 'required|integer',
        ]);


        $user = Auth::user();


        $codigo = strtoupper(substr(md5(time()),0,10));
        $codigo = 'AA3H8K52';
        $trabajo = Trabajo::where('codigo_trabajo','=',$codigo)->first();
        while ($trabajo) {
            $codigo = strtoupper(substr(md5(time()),0,10));
            $trabajo = Trabajo::where('codigo_trabajo','=',$codigo)->first();
        }

        $trabajo = new Trabajo;

        $trabajo->electricista_id  = $user->id;
        $trabajo->codigo_trabajo  = $codigo;
        $trabajo->nombre_trabajo  = $request->nombre_trabajo;
        $trabajo->cliente_id  = $request->cliente_id;
        $trabajo->ubicacion  = $request->ubicacion;
        $trabajo->descripcion  = $request->descripcion;
        $trabajo->cotizacion_estado  = 1;
        $trabajo->avance_estado  = 0;
        $trabajo->potencia  = '{"potencias": []}';
        $trabajo->tipo_trabajo  = 1;

        $trabajo->save();

        $data = $trabajo->refresh()->toArray();
        return response()->json([
            'trabajo' => $data
        ], 200);
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
            ->with('materiales')->with('materiales.material')->with('materiales.negocio_material')
            ->get();

        $agendamientos = Agendamiento::where('trabajo_id',$id)
            ->orderBy('fecha_hora_inicio')
            ->get();

        $trabajo = $trabajo->toArray()[0];
        $trabajo["potencia"] = json_decode($trabajo["potencia"]);
        $material_precio = DB::table('negocio_materials')
             ->selectRaw('negocio_materials.material_id, materials.nombre, materials.marca, materials.modelo')
             ->join('materials', 'materials.id', '=', 'negocio_materials.material_id')
             //->join('negocios', 'negocios.id', '=', 'negocio_materials.negocio_id')
             ->where('negocio_materials.electricista_id', $user->id)
             ->groupBy('negocio_materials.material_id')
             ->orderBy('materials.nombre')
             ->get();

        foreach ($material_precio as $mp) {
            $material = DB::table('negocio_materials')
            ->selectRaw('negocio_materials.id, negocio_materials.negocio_id, negocios.nombre, negocios.ubicacion, negocio_materials.precio')
            ->join('negocios', 'negocios.id', '=', 'negocio_materials.negocio_id')
            ->where('negocio_materials.material_id', $mp->material_id)
            //->groupBy('negocio_materials.material_id')
            ->orderBy('negocio_materials.precio')
            ->first();
            $mp->id = $material->id;
            $mp->precio = $material->precio;
            $mp->negocio_id = $material->negocio_id;
            $mp->negocio_nombre = $material->nombre;
            $mp->negocio_ubicacion = $material->ubicacion;
        }

        $materiales = [
        ];


        return Inertia::render('Trabajo',[
            'trabajo' => $trabajo,
            'agendamientos' => $agendamientos,
            'materiales' => $materiales,
            'precios' => $material_precio,
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
            ->with('materiales')->with('materiales.material')->with('materiales.negocio_material')
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
    public function update_potencias(Request $request, $id)
    {
        $validated = $request->validate([
            'aparato' => 'required|string',
            'potencia' => 'required|integer',
            'tiempo_uso' => 'required|integer',
        ]);
        $user = Auth::user();

        $trabajo = Trabajo::find($id);

        $potencias = json_decode($trabajo->potencia);

        $potencias->potencias[] = [
            'aparato' => $request->aparato,
            'potencia' => $request->potencia,
            'tiempo_uso' => $request->tiempo_uso,
        ];


        $trabajo->potencia = json_encode($potencias);

        $trabajo->save();
        $data = $trabajo->refresh()->toArray();

        $data["potencia"] = json_decode($data["potencia"]);
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
    public function update_estado(Request $request, $id)
    {
        $validated = $request->validate([
            'estado' => 'required|integer',
            'change' => 'required|string',
        ]);

        $user = Auth::user();

        $trabajo = Trabajo::find($id);

        switch ($request->change) {
            case 'tipo_trabajo':
                $trabajo->tipo_trabajo = $request->estado;
                break;
            case 'cotizacion_estado':
                $trabajo->cotizacion_estado = $request->estado;
                break;
            case 'avance_estado':
                $trabajo->avance_estado = $request->estado;
                break;

            default:
                # code...
                break;
        }
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
    public function destroy(Request $request, $id)
    {
        //
        $user = Auth::user();

        Trabajo::destroy($id);
        return response()->json([
            'trabajo' => $id
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Trabajo  $trabajo
     * @return \Illuminate\Http\Response
     */
    public function destroy_potencia(Request $request, $id)
    {
        $validated = $request->validate([
            //'trabajo' => 'required|integer',
            'index' => 'required|integer',
        ]);

        $user = Auth::user();

        $trabajo = Trabajo::find($id);
        $index = $request->index;

        $potencias = json_decode($trabajo->potencia, true);
        $p = $potencias["potencias"];
        $borrar = $potencias["potencias"][$index];

        unset($potencias["potencias"][$index]);
        $p = [];
        foreach ($potencias["potencias"] as $po) {
            $p[] = $po;
        }
        $potencias["potencias"] = $p;

        $trabajo->potencia = json_encode($potencias);

        $trabajo->save();
        $data = $trabajo->refresh()->toArray();

        $data["potencia"] = json_decode($data["potencia"]);
        return response()->json([
            'trabajo' => $data
        ], 200);
    }

    // Generate PDF
    public function create_pdf($id) {

        $trabajo = Trabajo::where('id',$id)
            ->with('materiales')
            ->with('materiales.material')
            ->with('cliente')
            ->with('cliente.metadatos')
            ->with('electricista')
            ->with('electricista.metadato')
            ->first();

        $t = $trabajo->toArray();
        $total = 0;
        foreach ($t["materiales"] as $m) {
            $total += $m["cantidad"] * $m["precio"];
        }
        $trabajo->total = $total ;
        $trabajo->ahora = Carbon::now()->setTimezone('America/Santiago')->format('d-m-Y H:i');



        return view('materiales', $trabajo);

        view()->share('materiales',$trabajo);
        $pdf = PDF::loadView('materiales', $trabajo);

        return $pdf->download('pdf_file.pdf');
    }
    // Generate PDF
    public function create_pdf_cliente($id,$codigo_trabajo) {

        $trabajo = Trabajo::where('id',$id)
            ->where('codigo_trabajo', $codigo_trabajo)
            ->with('materiales')
            ->with('materiales.material')
            ->with('cliente')
            ->with('cliente.metadatos')
            ->with('electricista')
            ->with('electricista.metadato')
            ->first();

        $t = $trabajo->toArray();
        $total = 0;
        foreach ($t["materiales"] as $m) {
            $total += $m["cantidad"] * $m["precio"];
        }
        $trabajo->total = $total ;
        $trabajo->ahora = Carbon::now()->setTimezone('America/Santiago')->format('d-m-Y H:i');



        return view('materiales', $trabajo);

        view()->share('materiales',$trabajo);
        $pdf = PDF::loadView('materiales', $trabajo);

        return $pdf->download('pdf_file.pdf');
    }
}
