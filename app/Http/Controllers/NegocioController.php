<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Negocio;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class NegocioController extends Controller
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
        $negocios = Negocio::where('electricista_id', $user->id)->get();

        //return view('negocios.index')->with('negocios', $negocios);
        return Inertia::render('Negocios',[
            'negocios' => $negocios
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
            'nombre' => 'required|string|max:191',
            'ubicacion' => 'required|string|max:191',
        ]);


        $negocio = new Negocio;
        $user = Auth::user();

        $negocio->nombre = $request->nombre;
        $negocio->ubicacion = $request->ubicacion;
        $negocio->electricista_id = $user->id;

        $negocio->save();

        //return Redirect::route('negocios');
        //return redirect()->back();
        $data = $negocio->refresh()->toArray();
        return response()->json([
            'negocio' => $data
        ], 200);

        //return redirect()->route('negocios');
        /* $negocios = Negocio::where('electricista_id', $user->id)->get();
        return Inertia::render('Negocios',[
            'negocios' => $negocios
        ]); */
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
            'nombre' => 'required|string|max:191',
            'ubicacion' => 'required|string|max:191',
        ]);

        $negocio = Negocio::find($id);
        $user = Auth::user();

        $negocio->nombre = $request->nombre;
        $negocio->ubicacion = $request->ubicacion;
        //$negocio->electricista_id = $user->id;

        $negocio->save();

        //return Redirect::route('negocios');
        //return redirect()->back();
        $data = $negocio->refresh()->toArray();
        return response()->json([
            'negocio' => $data
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = Auth::user();
        //$negocios = Negocio::where('electricista_id', $user->id)->get();
        Negocio::destroy($id);
        return response()->json([
            'negocio' => $id
        ], 200);
    }
}
