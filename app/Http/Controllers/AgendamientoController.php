<?php

namespace App\Http\Controllers;

use App\Models\Agendamiento;
use App\Models\Trabajo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class AgendamientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $now = Carbon::now();

        /* $trabajos = Trabajo::where('electricista_id', $user->id)
            ->get();
        $trabajos = $trabajos->toArray(); */
        $agenda = [];
        //foreach ($trabajos as $t) {
            //$agendamientos = Agendamiento::where('trabajo_id', $t["id"])
            //$agendamientos = Agendamiento::where('fecha_hora_inicio', '>', $now)
                //->where('fecha_hora_inicio', '>', $now)
                /* ->with('trabajo')
                ->where('trabajo.electricista_id', $user->id)
                ->get(); */
            //foreach ($agendamientos->toArray() as $a){
                //$agenda[] = $a;
                //$agenda[] = $agendamientos->toArray();
            //};
        //}
        $agenda = Agendamiento::whereHas('trabajo', function ($query) {
            $user = Auth::user();
            return $query->where('electricista_id', $user->id);
        })
        ->orderBy('fecha_hora_inicio')
        ->with('trabajo')
        ->get();
        $agenda = $agenda->toArray();

        return Inertia::render('Agenda',[
            'agenda' => $agenda
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
     * @param  \App\Models\Agendamiento  $agendamiento
     * @return \Illuminate\Http\Response
     */
    public function show(Agendamiento $agendamiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Agendamiento  $agendamiento
     * @return \Illuminate\Http\Response
     */
    public function edit(Agendamiento $agendamiento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Agendamiento  $agendamiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agendamiento $agendamiento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agendamiento  $agendamiento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agendamiento $agendamiento)
    {
        //
    }
}
