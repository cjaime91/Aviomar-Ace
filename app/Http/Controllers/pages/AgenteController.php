<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidacionAgente;
use App\Models\Ciudad;
use App\Models\pages\Agente;
use App\Models\pages\Estado;
use App\Models\Pais;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agentes = Agente::leftjoin("av_ciudades", "av_agentes.ciudad_id", "=", "av_ciudades.ciudad_id")
            ->leftjoin("av_paises", "av_agentes.cod_pais", "=", "av_paises.cod")
            ->orderBy('razon_social')->get();
            
        if (Auth::check()) {
            if (auth()->user()->rol_id == 2 || auth()->user()->rol_id == 1) {
                return view('pages.Agentes.index', compact('agentes'));
            } else {
                return view('pages.Agentes.index2', compact('agentes'));
            }
        }else{
            return view('auth.login');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        $estados = Estado::where('mod', 'AG')->orderBy('estado')->get();
        return view('pages.Agentes.crear', compact('estados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(ValidacionAgente $request)
    {
        Agente::create($request->all());
        //dd($request->all());
        return redirect('pages/agentes');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function mostrar($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editar($id)
    {
        $agente = Agente::findOrFail($id);
        $estados = Estado::where('mod', 'AG')->orderBy('estado')->get();
        $paises = Pais::orderBy('pais')->get();
        $ciudades = Ciudad::where('cod_pais', $agente->cod_pais)->orderBy('ciudad')->get();
        return view('pages.Agentes.editar', compact('agente', 'estados', 'paises', 'ciudades'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar(Request $request, $id)
    {
        Agente::findOrFail($id)->update($request->all());
        return redirect('pages/agentes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eliminar(Request $request, $id)
    {
        if ($request->ajax()) {
            if (Agente::destroy($id)) {
                return response()->json(['mensaje' => 'ok']);
            } else {
                return response()->json(['mensaje' => 'ng']);
            }
        } else {
            abort(404);
        }
    }

    public function getpais()
    {
        try {
            $paises = Pais::all();
            $response = ['data' => $paises];
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Error al traer registros'], 500);
        }
        return response()->json($response);
    }

    public function getCiudades(Request $request)
    {
        try {
            $cod_pais = $request->input('cod_pais');
            $ciudades = Ciudad::when($cod_pais, function ($query) use ($cod_pais) {
                $query->where('cod_pais', $cod_pais);
            })->get();
            $response = ['data' => $ciudades];
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Error al traer registros'], 500);
        }
        return response()->json($response);
    }
}
