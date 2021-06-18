<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use App\Models\Agendamiento;
use Carbon\Carbon;

class InicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $estado_avance = [
            ['key' =>'0', 'value' =>'Realizar visita previa'],
            ['key' =>'1', 'value' =>'Esperando aprobación del presupuesto'],
            ['key' =>'2', 'value' =>'Presupuesto aprobado'],
            ['key' =>'3', 'value' =>'Presupuesto rechazado'],
            ['key' =>'4', 'value' =>'Trabajando'],
            ['key' =>'5', 'value' =>'Trabajo Finalizado']
        ];
        $tipo_trabajos = [
            ['key' =>'1', 'value' =>'Instalación eléctrica'],
            ['key' =>'2', 'value' =>'Actualización de planos'],
            ['key' =>'3', 'value' =>'Certificación'],
        ];
        $estado_cotizacion = [
            ['key' =>'0', 'value' =>'Obteniendo lista de materiales'],
            ['key' =>'1', 'value' =>'Cotizando materiales'],
            ['key' =>'2', 'value' =>'Esperando aprobación'],
            ['key' =>'3', 'value' =>'Cotizacón rechazada'],
            ['key' =>'4', 'value' =>'Cotizacón aceptada'],
        ];

        $estadisticas = [];

        foreach ($tipo_trabajos as $t) {

            $trabajos_get = DB::table('trabajos')
                ->selectRaw('*')
                ->where('tipo_trabajo', $t["key"])
                ->where('electricista_id', $user->id)
                ->count();

            $estadisticas["tipo_trabajos"][]= [
                "tipo_trabajos" => $t["key"],
                "nombre" => $t["value"],
                "cantidad" => $trabajos_get,
            ];
        }

        foreach ($estado_avance as $t) {

            $trabajos_get = DB::table('trabajos')
                ->selectRaw('*')
                ->where('avance_estado', $t["key"])
                ->where('electricista_id', $user->id)
                ->count();

            $estadisticas["estado_avance"][]= [
                "estado_avance" => $t["key"],
                "nombre" => $t["value"],
                "cantidad" => $trabajos_get,
            ];
        }

        $estadisticas["trabajos"] = DB::table('trabajos')
                                    ->selectRaw('*')
                                    ->where('electricista_id', $user->id)
                                    ->count();
        $estadisticas["trabajos_realizados"] = DB::table('trabajos')
                                    ->selectRaw('*')
                                    ->where('avance_estado', 5)
                                    ->where('electricista_id', $user->id)
                                    ->count();
        $estadisticas["trabajos_por_hacer"] = DB::table('trabajos')
                                    ->selectRaw('*')
                                    ->where('avance_estado','<>',5)
                                    ->where('electricista_id', $user->id)
                                    ->count();

        $ahora = Carbon::now();
        $estadisticas["agendamientos"] = Agendamiento::whereHas('trabajo', function ($query) {
                                $user = Auth::user();
                                return $query->where('electricista_id', $user->id);
                            })
                            ->count();
        $estadisticas["agendamientos_realizados"] = Agendamiento::whereHas('trabajo', function ($query) {
                                $user = Auth::user();
                                return $query->where('electricista_id', $user->id);
                            })
                            ->where('fecha_hora_fin', '<', $ahora)
                            ->count();
        $estadisticas["agendamientos_por_hacer"] = Agendamiento::whereHas('trabajo', function ($query) {
                                $user = Auth::user();
                                return $query->where('electricista_id', $user->id);
                            })
                            ->where('fecha_hora_inicio', '>', $ahora)
                            ->count();

/*
        $estadisticas["tipo_trabajos"] = [
            ["tipo_trabajos" => 1, "cantidad" => 5],
            ["tipo_trabajos" => 2, "cantidad" => 7],
            ["tipo_trabajos" => 3, "cantidad" => 8],
        ]; */
/*
        $estadisticas["estado_avance"] = [
            ["estado_avance" => 0, "cantidad" => 1],
            ["estado_avance" => 1, "cantidad" => 2],
            ["estado_avance" => 2, "cantidad" => 3],
            ["estado_avance" => 3, "cantidad" => 5],
            ["estado_avance" => 4, "cantidad" => 5],
            ["estado_avance" => 5, "cantidad" => 5],
        ]; */

        return Inertia::render('Dashboard',[
            'estado_avance' => $estado_avance,
            'estado_cotizacion' => $estado_cotizacion,
            'tipo_trabajos' => $tipo_trabajos,

            'estadisticas' => $estadisticas
        ]);
    }
}
