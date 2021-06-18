<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;


class MaterialController extends Controller
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
        $materiales = Material::where('electricista_id', $user->id)->get();

        $mat =$materiales->toArray();
        $mats = [];
        foreach ($mat as $m) {
            if ($m["imagen"] !== '')
                //$m["imagen"] = URL::to('/storage/'.$m["imagen"]);
                //$m["imagen"] = asset($m["imagen"]);
                //$m["imagen"] = str_replace("public/","",$m["imagen"]);
                //$asd = Storage::url($m["imagen"]);
            $mats[] = $m;
        }

        //return view('materiales.index')5->with('materiales', $materiales);
        return Inertia::render('Materiales',[
            'materiales' => $mats
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
            'marca' => 'required|string|max:191',
            'modelo' => 'required|string|max:191',
            //'link' => 'string|max:191',
        ]);


        $material = new Material;
        $user = Auth::user();

        $material->nombre = $request->nombre;
        $material->marca = $request->marca;
        $material->modelo = $request->modelo;
        //$material->link = $request->link;
        $material->electricista_id = $user->id;

        $material->save();

        $data = $material->refresh()->toArray();
        return response()->json([
            'material' => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function store_imagen(Request $request, $id)
    {
        $validated = $request->validate([
            'file' => 'required|file',
        ]);


        $material = Material::find($id);
        $user = Auth::user();

        $path = Storage::putFile('public/materiales', $request->file('file'));
        $material->imagen = $path;

        $material->save();

        $data = $material->refresh()->toArray();
        return response()->json([
            'material' => $data
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
            'marca' => 'required|string|max:191',
            'modelo' => 'required|string|max:191',
            //'link' => 'string|max:191',
        ]);

        $material = Material::find($id);
        $user = Auth::user();

        $material->nombre = $request->nombre;
        $material->marca = $request->marca;
        $material->modelo = $request->modelo;
        //$material->link = $request->link;

        $material->save();

        $data = $material->refresh()->toArray();
        return response()->json([
            'material' => $data
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

        Material::destroy($id);
        return response()->json([
            'material' => $id
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_imagen(Request $request, $id)
    {
        //
        $user = Auth::user();

        $material = Material::find($id);

        $material->imagen = '';

        
        $material->save();

        $data = $material->refresh()->toArray();
        return response()->json([
            'material' => $data
        ], 200);
    }
}
