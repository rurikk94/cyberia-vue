<?php

namespace App\Http\Controllers;

use App\Models\Agendamiento;
use App\Models\Trabajo;
use App\Models\MetadatosCliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use App\Mail\AgendamientoEmail;
use App\Mail\AgendamientoEmailElectricista;
use Illuminate\Support\Facades\Mail;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;
use DateTime;
use Illuminate\Support\Facades\Storage;


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

        $desde = Carbon::now()->subWeeks(24)->startOfMonth();
        $hasta = Carbon::now()->addWeeks(24)->endOfMonth();

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
        $validated = $request->validate([
            //'trabajo' => 'required|integer',
            'trabajo_id' => 'required|integer',
            'fecha_hora_inicio' => 'required|date|after:today',
            'fecha_hora_fin' => 'required|date|after:fecha_hora_inicio',
        ]);

        $user = Auth::user();

        $ahora = Carbon::now();

        $trabajo = Trabajo::where('id',$request->trabajo_id)->with('cliente')->with('electricista')->first();

        $emails = MetadatosCliente::where('key','=','email')->where('cliente_id',$trabajo->cliente_id)->get();
        $emails = $emails->toArray();

        $objDemo = new \stdClass();
        $objDemo->url = url('/trabajo/'.$request->trabajo_id);
        $objDemo->codigo_trabajo = $trabajo->codigo_trabajo;
        $objDemo->ubicacion = $trabajo->ubicacion;

        $objDemo->inicio =  Carbon::parse($request->fecha_hora_inicio); // 1975-05-21 22:00:00
        $objDemo->inicio->setTimezone('America/Santiago')->toDateTimeString();
        $objDemo->fin =     Carbon::parse($request->fecha_hora_fin); // 1975-05-21 22:00:00
        $objDemo->fin->setTimezone('America/Santiago')->toDateTimeString();

        $evento = Event::create()
            ->name('Visita el??ctrica '.$trabajo->electricista->name)
            ->address($trabajo->ubicacion)
            ->organizer($trabajo->electricista->email, $trabajo->electricista->name)
            ->description($trabajo->descripcion)
            ->createdAt($ahora)
            ->startsAt(new DateTime( $request->fecha_hora_inicio))
            ->endsAt(new DateTime($request->fecha_hora_fin));

        $calendar = Calendar::create('Laracon online')
            ->event($evento)
            ->get();

        $name_file = $trabajo->codigo_trabajo.'_'.$ahora->format('Y-m-d_H-i-s').'.ics';
        Storage::put('ical/'.$name_file, $calendar);

        $objDemo->ical = $name_file;
        $objDemo->ahora = $ahora->setTimezone('America/Santiago')->format('d-m-Y H:i:s');

        $objDemo->sender = $trabajo->electricista->name;
        $objDemo->receiver = $trabajo->electricista->name;

        Mail::to($trabajo->electricista->email)->send(new AgendamientoEmailElectricista($objDemo));

        $objDemo->url = url('/trabajo');
        $objDemo->sender = $trabajo->electricista->name;
        $objDemo->receiver = $trabajo->cliente->nombres . ' ' . $trabajo->cliente->apellidos;

        foreach ($emails as $e) {
            Mail::to($e["value"])->send(new AgendamientoEmail($objDemo));
        }

        $agendamiento = new Agendamiento;

        $agendamiento->trabajo_id =         $request->id;
        $agendamiento->fecha_hora_inicio =  $request->fecha_hora_inicio;
        $agendamiento->fecha_hora_fin =     $request->fecha_hora_fin;

        $agendamiento->save();
        $agendamiento = $agendamiento->refresh()->toArray();

        return response()->json([
            'agendamiento' => $agendamiento
        ], 200);
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
    public function destroy(Agendamiento $agendamiento, $id)
    {
        $user = Auth::user();

        Agendamiento::destroy($id);
        return response()->json([
            'agendamiento' => $id
        ], 200);
    }
}
