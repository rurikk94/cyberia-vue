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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'desde' => 'string',
            'hasta' => 'string',
            'option' => 'string',
        ]);
        $user = Auth::user();

        $desde_antes = Carbon::now()->subWeeks(2);
        $desde = Carbon::now();
        $desde_despues = Carbon::now()->addWeeks(2);

        $hasta_antes = Carbon::now();
        $hasta = Carbon::now()->addWeeks(2);
        $hasta_despues = Carbon::now()->addWeeks(4);

        if ($request->hasAny(['desde', 'hasta']))
        {
            $desde_antes = Carbon::create($request->desde)->subWeeks(2);
            $desde = Carbon::create($request->desde);
            $desde_despues = Carbon::create($request->desde)->addWeeks(2);

            $hasta_antes = Carbon::create($request->hasta)->subWeeks(2);
            $hasta = Carbon::create($request->hasta);
            $hasta_despues = Carbon::create($request->hasta)->addWeeks(2);
        }
        if ($request->has('option'))
        {
            if ($request->option == 'antes'){

                $desde_antes = $desde_antes->subWeeks(2);
                $desde = $desde->subWeeks(2);
                $desde_despues = $desde_despues->subWeeks(2);

                $hasta_antes = $hasta_antes->subWeeks(2);
                $hasta = $hasta->subWeeks(2);
                $hasta_despues = $hasta_despues->subWeeks(2);
            }

            if ($request->option == 'despues'){

                $desde_antes = $desde_antes->addWeeks(2);
                $desde = $desde->addWeeks(2);
                $desde_despues = $desde_despues->addWeeks(2);

                $hasta_antes = $hasta_antes->addWeeks(2);
                $hasta = $hasta->addWeeks(2);
                $hasta_despues = $hasta_despues->addWeeks(2);
            }
        }

        $agenda = [];

        $agenda_antes = Agendamiento::whereHas('trabajo', function ($query) {
                $user = Auth::user();
                return $query->where('electricista_id', $user->id);
            })
            ->where('fecha_hora_inicio', '>', $desde_antes)
            ->where('fecha_hora_fin', '<', $hasta_antes)
            ->orderBy('fecha_hora_inicio')
            ->with('trabajo')
            ->get();

        $agenda = Agendamiento::whereHas('trabajo', function ($query) {
                $user = Auth::user();
                return $query->where('electricista_id', $user->id);
            })
            ->where('fecha_hora_inicio', '>', $desde)
            ->where('fecha_hora_fin', '<', $hasta)
            ->orderBy('fecha_hora_inicio')
            ->with('trabajo')
            ->get();

        $agenda_despues = Agendamiento::whereHas('trabajo', function ($query) {
                $user = Auth::user();
                return $query->where('electricista_id', $user->id);
            })
            ->where('fecha_hora_inicio', '>', $desde_despues)
            ->where('fecha_hora_fin', '<', $hasta_despues)
            ->orderBy('fecha_hora_inicio')
            ->with('trabajo')
            ->get();

        $agenda_antes = $agenda_antes->toArray();
        $agenda = $agenda->toArray();
        $agenda_despues = $agenda_despues->toArray();

        if ($request->hasAny(['desde', 'hasta']))
            return response()->json([
                'agenda_antes' => $agenda_antes,
                'agenda' => $agenda,
                'agenda_despues' => $agenda_despues,
                'desde' => $desde,
                'hasta' => $hasta,
            ], 200);

        return Inertia::render('Agenda',[
            'agenda_antes' => $agenda_antes,
            'agenda' => $agenda,
            'agenda_despues' => $agenda_despues,
            'desde' => $desde,
            'hasta' => $hasta,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function calendario(Request $request)
    {
        $validated = $request->validate([
            'desde' => 'string',
            'hasta' => 'string',
            'option' => 'string',
        ]);
        $user = Auth::user();

        $desde = Carbon::now()->startOfMonth();
        $hasta = Carbon::now()->endOfMonth();

        if ($request->hasAny(['desde', 'hasta']))
        {
            $desde = Carbon::create($request->desde);
            $hasta = Carbon::create($request->hasta);
        }
        if ($request->has('option'))
        {
            if ($request->option == 'antes'){
                $desde = $desde->subWeeks(2);
                $hasta = $hasta->subWeeks(2);
            }

            if ($request->option == 'despues'){
                $desde = $desde->addWeeks(2);
                $hasta = $hasta->addWeeks(2);
            }
        }

        $agenda = Agendamiento::whereHas('trabajo', function ($query) {
                $user = Auth::user();
                return $query->where('electricista_id', $user->id);
            })
            ->where('fecha_hora_inicio', '>', $desde)
            ->where('fecha_hora_fin', '<', $hasta)
            ->orderBy('fecha_hora_inicio')
            ->with('trabajo')
            ->get();

        $agenda = $agenda->toArray();
        $atributos = [];
        $customData = [];
        foreach ($agenda as $a) {
            $customData['title'] = $a["trabajo"]["nombre_trabajo"];
            $customData['class'] = "bg-red-600 text-white";

            $evento['key'] = $a["trabajo"]["id"];
            $evento['customData'] =  $customData;
            $evento['dates'] =  $a["fecha_hora_inicio"];
            $atributos[] = $evento;
        }

        if ($request->hasAny(['desde', 'hasta']))
            return response()->json([
                'agenda' => $atributos,
                'desde' => $desde,
                'hasta' => $hasta,
            ], 200);

        return Inertia::render('Calendario',[
            'agenda' => $atributos,
            'desde' => $desde,
            'hasta' => $hasta,
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
