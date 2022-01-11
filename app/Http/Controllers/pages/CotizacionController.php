<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Ciudad;
use App\Models\pages\Agente;
use App\Models\pages\Cotizacion;
use App\Models\pages\cot_logs;
use App\Models\pages\Estado;
use App\Models\pages\Notas;
use App\Models\pages\Productos;
use App\Models\pages\Referencia;
use App\Models\pages\Sucursal;
use App\Models\pages\TipoCliente;
use App\Models\pages\TipoOperacion;
use App\Models\pages\TipoTransporte;
use App\Models\Pais;
use App\Models\User;
use Illuminate\Http\Request;

class CotizacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexmn()
    {
        $users = User::orderBy('id')
            ->where('id', '!=', '1')
            ->where('id', '!=', '2')
            ->get();
        $agentes = Agente::orderBy('agente_id')->get();
        $estados = Estado::where('mod', 'CT')->orderBy('estado_id')->get();
        $sucursales = Sucursal::orderBy('sucursal_id')->get();
        $productos = Productos::orderBy('producto')->get();
        $tipoclientes = TipoCliente::orderBy('tipocliente')->get();
        $tipooperaciones = TipoOperacion::orderBy('tipooperacion')->get();
        $tipotransportes = TipoTransporte::orderBy('tipotransporte')->get();
        $paises = Pais::orderBy('pais')->get();
        return view('pages.cotizaciones.index_mn', compact('estados', 'sucursales', 'productos', 'tipoclientes', 'tipooperaciones', 'tipotransportes', 'paises', 'users', 'agentes'));
    }
    public function indexexpo()
    {
        $users = User::orderBy('id')
            ->where('id', '!=', '1')
            ->where('id', '!=', '2')
            ->get();
        $agentes = Agente::orderBy('agente_id')->get();
        $estados = Estado::where('mod', 'CT')->orderBy('estado_id')->get();
        $sucursales = Sucursal::orderBy('sucursal_id')->get();
        $productos = Productos::orderBy('producto')->get();
        $tipoclientes = TipoCliente::orderBy('tipocliente')->get();
        $tipooperaciones = TipoOperacion::orderBy('tipooperacion')->get();
        $tipotransportes = TipoTransporte::orderBy('tipotransporte')->get();
        $paises = Pais::orderBy('pais')->get();
        return view('pages.cotizaciones.index_expo', compact('estados', 'sucursales', 'productos', 'tipoclientes', 'tipooperaciones', 'tipotransportes', 'paises', 'users', 'agentes'));
    }

    public function indeximpo()
    {
        $users = User::orderBy('id')
            ->where('id', '!=', '1')
            ->where('id', '!=', '2')
            ->get();
        $agentes = Agente::orderBy('agente_id')->get();
        $estados = Estado::where('mod', 'CT')->orderBy('estado_id')->get();
        $sucursales = Sucursal::orderBy('sucursal_id')->get();
        $productos = Productos::orderBy('producto')->get();
        $tipoclientes = TipoCliente::orderBy('tipocliente')->get();
        $tipooperaciones = TipoOperacion::orderBy('tipooperacion')->get();
        $tipotransportes = TipoTransporte::orderBy('tipotransporte')->get();
        $paises = Pais::orderBy('pais')->get();
        return view('pages.cotizaciones.index_impo', compact('estados', 'sucursales', 'productos', 'tipoclientes', 'tipooperaciones', 'tipotransportes', 'paises', 'users', 'agentes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        $users_ej = User::orderBy('id')
            ->where('id', '!=', '1')
            ->where('id', '!=', '2')
            ->where('id', '!=', '7')
            ->where('id', '!=', '10')
            ->where('id', '!=', '13')
            ->where('id', '!=', '24')
            ->where('id', '!=', '29')
            ->where('id', '!=', '30')
            ->get();
        $agentes = Agente::leftjoin("av_ciudades", "av_agentes.ciudad_id", "=", "av_ciudades.ciudad_id")
            ->leftjoin("av_paises", "av_agentes.cod_pais", "=", "av_paises.cod")
            ->orderBy('razon_social')->get();
        $sucursales = Sucursal::orderBy('sucursal_id')->get();
        $productos = Productos::orderBy('producto')->get();
        $tipoclientes = TipoCliente::orderBy('tipocliente')->get();
        $tipooperaciones = TipoOperacion::orderBy('tipooperacion')->get();
        $tipotransportes = TipoTransporte::orderBy('tipotransporte')->get();
        $paises = Pais::orderBy('pais')->get();
        return view('pages.cotizaciones.crear', compact('sucursales', 'productos', 'tipoclientes', 'tipooperaciones', 'tipotransportes', 'paises', 'users_ej', 'agentes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(Request $request)
    {
        $datos = $request->all();

        if ($request->has('valor_o')) {
            if ($datos['valor_o'] == null) {
                $datos['valor_o'] = 0;
            }
        }

        if ($request->has('valor_d')) {
            if ($datos['valor_d'] == null) {
                $datos['valor_d'] = 0;
            }
        }

        if ($request->has('cbm')) {
            if ($datos['cbm'] == null) {
                $datos['cbm'] = 0;
            }
        }

        if ($request->has('cbm_a')) {
            if ($datos['cbm_a'] == null) {
                $datos['cbm_a'] = 0;
            }
        }

        if ($request->has('cbm_m')) {
            if ($datos['cbm_m'] == null) {
                $datos['cbm_m'] = 0;
            }
        }

        if ($request->has('libras')) {
            if ($datos['libras'] == null) {
                $datos['libras'] = 0;
            }
        }

        if ($request->has('libras_a')) {
            if ($datos['libras_a'] == null) {
                $datos['libras_a'] = 0;
            }
        }

        if ($request->has('libras_m')) {
            if ($datos['libras_m'] == null) {
                $datos['libras_m'] = 0;
            }
        }
        $anio_actual = date("Y");
        switch ($datos['tcotizacion']) {
            case '1':
                $consecutivo = Cotizacion::whereNotnull('consecutivo_mn')
                    ->whereyear("fecha", $anio_actual)
                    ->count();
                if (date("Y") == "2021") {
                    $datos['consecutivo_mn'] = str_pad($consecutivo + 1, 4, "0", STR_PAD_LEFT);
                    $datos['usuario_realiza_id'] = auth()->user()->id;
                    Cotizacion::create($datos);
                    return redirect('pages/cotizaciones_mn')->with('alerta', $datos['consecutivo_mn']);
                } else {
                    $datos['consecutivo_mn'] = date("Y") . "-" . str_pad($consecutivo + 1, 4, "0", STR_PAD_LEFT);
                    $datos['usuario_realiza_id'] = auth()->user()->id;
                    Cotizacion::create($datos);
                    return redirect('pages/cotizaciones_mn')->with('alerta', $datos['consecutivo_mn']);
                }

                break;
            case '2':
                $consecutivo = Cotizacion::whereNotnull('consecutivo_expo')
                    ->whereyear("fecha", $anio_actual)
                    ->count();
                $datos['consecutivo_expo'] = "8-" . date("m") . date("y") . "-" . str_pad($consecutivo + 1, 4, "0", STR_PAD_LEFT);
                $datos['usuario_realiza_id'] = auth()->user()->id;
                Cotizacion::create($datos);
                return redirect('pages/cotizaciones_expo')->with('alerta', $datos['consecutivo_expo']);
                break;
            case '3':
                $consecutivo = Cotizacion::whereNotnull('consecutivo_impo')
                    ->whereyear("fecha", $anio_actual)
                    ->count();
                $datos['consecutivo_impo'] =  "4-" . date("m") . date("y") . "-" . str_pad($consecutivo + 1, 4, "0", STR_PAD_LEFT);
                $datos['usuario_realiza_id'] = auth()->user()->id;
                Cotizacion::create($datos);
                return redirect('pages/cotizaciones_impo')->with('alerta', $datos['consecutivo_impo']);
                break;
            default:
                # code...
                break;
        }
    }

    public function prueba()
    {
        return redirect('pages/cotizaciones_mn')->with('alerta', '0974');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function mostrar($id)
    {
        $cotizacion = Cotizacion::leftjoin("av_usuarios AS ejecutivo", "av_cotizaciones.usuario_ejecutivo_id", "=", "ejecutivo.id")
            ->leftjoin("av_agentes AS controlador", "av_cotizaciones.agente_id_c", "=", "controlador.agente_id")
            ->leftjoin("av_agentes AS agent_origen", "av_cotizaciones.agente_id_o", "=", "agent_origen.agente_id")
            ->leftjoin("av_agentes AS agent_destino", "av_cotizaciones.agente_id_d", "=", "agent_destino.agente_id")
            ->leftjoin("av_sucursal AS sucursal", "av_cotizaciones.sucursal_id", "=", "sucursal.sucursal_id")
            ->leftjoin("av_tipooperacion AS toper", "av_cotizaciones.toper_id", "=", "toper.toper_id")
            ->leftjoin("av_tipocliente AS cliente", "av_cotizaciones.tcliente_id", "=", "cliente.tcliente_id")
            ->leftjoin("av_productos AS productos", "av_cotizaciones.producto_id", "=", "productos.producto_id")
            ->leftjoin("av_tipotransporte AS transporte", "av_cotizaciones.ttrans_id", "=", "transporte.ttrans_id")
            ->leftjoin("av_ciudades AS ciudad_or", "av_cotizaciones.ciudad_id_or", "=", "ciudad_or.ciudad_id")
            ->leftjoin("av_paises AS pais_or", "av_cotizaciones.cod_pais_or", "=", "pais_or.cod")
            ->leftjoin("av_ciudades AS ciudad_ds", "av_cotizaciones.ciudad_id_ds", "=", "ciudad_ds.ciudad_id")
            ->leftjoin("av_paises AS pais_ds", "av_cotizaciones.cod_pais_ds", "=", "pais_ds.cod")
            ->leftjoin("av_usuarios AS realizado", "av_cotizaciones.usuario_realiza_id", "=", "realizado.id")
            ->leftjoin("av_estados AS estado_cot", "av_cotizaciones.estado_id", "=", "estado_cot.estado_id")
            ->where("cot_id", $id)
            ->orderBy('cot_id')->get([
                '*', 'ejecutivo.nombre as NombreE', 'ejecutivo.apellidos as ApellidosE', 'controlador.razon_social as Controlador', 'agent_origen.razon_social as AgenteO',
                'agent_destino.razon_social as AgenteD', 'ciudad_or.ciudad AS CiudadO', 'pais_or.pais as PaisO', 'ciudad_ds.ciudad AS CiudadD',
                'pais_ds.pais AS PaisD', 'realizado.nombre AS NombreR', 'realizado.apellidos AS ApellidosR', 'estado_cot.estado AS EstadoC'
            ]);
        return view('pages.cotizaciones.modal', compact('cotizacion', '$datos_nota'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editar($id)
    {
        $cotizacion = Cotizacion::findOrFail($id);
        $users = User::orderBy('id')->get();
        $agentes = Agente::orderBy('agente_id')->get();
        $sucursales = Sucursal::orderBy('sucursal_id')->get();
        $productos = Productos::orderBy('producto')->get();
        $tipoclientes = TipoCliente::orderBy('tipocliente')->get();
        $tipooperaciones = TipoOperacion::orderBy('tipooperacion')->get();
        $tipotransportes = TipoTransporte::orderBy('tipotransporte')->get();
        $paises = Pais::orderBy('pais')->get();
        $ciudad_or = Ciudad::where('cod_pais', $cotizacion->cod_pais_or)->orderBy('ciudad')->get();
        $ciudad_ds = Ciudad::where('cod_pais', $cotizacion->cod_pais_ds)->orderBy('ciudad')->get();
        return view('pages.cotizaciones.editar', compact('cotizacion', 'ciudad_or', 'ciudad_ds', 'sucursales', 'productos', 'tipoclientes', 'tipooperaciones', 'tipotransportes', 'paises', 'users', 'agentes'));
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
        switch ($request->tcotizacion) {
            case '1':
                Cotizacion::findOrFail($id)->update($request->all());
                return redirect('pages/cotizaciones_mn');
                break;
            case '2':
                Cotizacion::findOrFail($id)->update($request->all());
                return redirect('pages/cotizaciones_expo');
                break;
            case '3':
                Cotizacion::findOrFail($id)->update($request->all());
                return redirect('pages/cotizaciones_impo');
                break;

            default:
                # code...
                break;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar_est(Request $request, $id)
    {
        $datos = $request->all();
        $log_cot = new Request();
        $cot = Cotizacion::findOrFail($id)->get();
        foreach ($cot as $cot1) {
            if ($cot1->cot_id == $id) {
                //dd($cot1->cot_id . ' ' . $datos['estado_id']);
                Cotizacion::findOrFail($id)->update($datos);
                if ($cot1->consecutivo_mn != null) {
                    switch ($datos['estado_id']) {
                        case '3':
                            $log_cot['cot_id'] =  $id;
                            $log_cot['fecha_a'] =  date('Y-m-d');
                            $log_cot['tipo'] =  'Aprobación';
                            $log_cot['usuario_id'] = auth()->user()->id;
                            //dd($log_cot->all());
                            cot_logs::create($log_cot->all());
                            return redirect('pages/cotizaciones_mn')->with('estado3', $cot1->consecutivo_mn);
                            break;
                        case '4':
                            return redirect('pages/cotizaciones_mn')->with('estado4', $cot1->consecutivo_mn);
                            break;
                        case '5':
                            return redirect('pages/cotizaciones_mn')->with('estado5', $cot1->consecutivo_mn);
                            break;
                        case '10':
                            return redirect('pages/cotizaciones_mn')->with('estado10', $cot1->consecutivo_mn);
                            break;
                        case '11':
                            return redirect('pages/cotizaciones_mn')->with('estado11', $cot1->consecutivo_mn);
                            break;
                        case '2':
                            return redirect('pages/cotizaciones_mn')->with('estado2', $cot1->consecutivo_mn);
                            break;
                        case '8':
                            return redirect('pages/cotizaciones_mn')->with('estado8', $cot1->consecutivo_mn);
                            break;
                        case '12':
                            return redirect('pages/cotizaciones_mn')->with('estado12', $cot1->consecutivo_mn);
                            break;
                        case '13':
                            return redirect('pages/cotizaciones_mn')->with('estado13', $cot1->consecutivo_mn);
                            break;
                        case '14':
                            return redirect('pages/cotizaciones_mn')->with('estado14', $cot1->consecutivo_mn);
                            break;
                        case '15':
                            return redirect('pages/cotizaciones_mn')->with('estado15', $cot1->consecutivo_mn);
                            break;
                        case '16':
                            return redirect('pages/cotizaciones_mn')->with('estado16', $cot1->consecutivo_mn);
                            break;
                        case '17':
                            return redirect('pages/cotizaciones_mn')->with('estado17', $cot1->consecutivo_mn);
                            break;
                        case '18':
                            return redirect('pages/cotizaciones_mn')->with('estado18', $cot1->consecutivo_mn);
                            break;
                    }
                } elseif ($cot1->consecutivo_expo != null) {
                    switch ($datos['estado_id']) {
                        case '3':
                            $log_cot['cot_id'] =  $id;
                            $log_cot['fecha_a'] =  date('Y-m-d');
                            $log_cot['tipo'] =  'Aprobación';
                            $log_cot['usuario_id'] = auth()->user()->id;
                            //dd($log_cot->all());
                            cot_logs::create($log_cot->all());
                            return redirect('pages/cotizaciones_expo')->with('estado3', $cot1->consecutivo_expo);
                            break;
                        case '4':
                            return redirect('pages/cotizaciones_expo')->with('estado4', $cot1->consecutivo_expo);
                            break;
                        case '5':
                            return redirect('pages/cotizaciones_expo')->with('estado5', $cot1->consecutivo_expo);
                            break;
                        case '10':
                            return redirect('pages/cotizaciones_expo')->with('estado10', $cot1->consecutivo_expo);
                            break;
                        case '11':
                            return redirect('pages/cotizaciones_expo')->with('estado11', $cot1->consecutivo_expo);
                            break;
                        case '2':
                            return redirect('pages/cotizaciones_expo')->with('estado2', $cot1->consecutivo_expo);
                            break;
                        case '8':
                            return redirect('pages/cotizaciones_expo')->with('estado8', $cot1->consecutivo_expo);
                            break;
                        case '12':
                            return redirect('pages/cotizaciones_expo')->with('estado12', $cot1->consecutivo_expo);
                            break;
                        case '13':
                            return redirect('pages/cotizaciones_expo')->with('estado13', $cot1->consecutivo_expo);
                            break;
                        case '14':
                            return redirect('pages/cotizaciones_expo')->with('estado14', $cot1->consecutivo_expo);
                            break;
                        case '15':
                            return redirect('pages/cotizaciones_expo')->with('estado15', $cot1->consecutivo_expo);
                            break;
                        case '16':
                            return redirect('pages/cotizaciones_expo')->with('estado16', $cot1->consecutivo_expo);
                            break;
                        case '17':
                            return redirect('pages/cotizaciones_expo')->with('estado17', $cot1->consecutivo_expo);
                            break;
                        case '18':
                            return redirect('pages/cotizaciones_expo')->with('estado18', $cot1->consecutivo_expo);
                            break;
                    }
                    //return redirect('pages/cotizaciones_expo')->with('estado', $cot1->consecutivo_expo);
                } else {
                    switch ($datos['estado_id']) {
                        case '3':
                            $log_cot['cot_id'] =  $id;
                            $log_cot['fecha_a'] =  date('Y-m-d');
                            $log_cot['tipo'] =  'Aprobación';
                            $log_cot['usuario_id'] = auth()->user()->id;
                            //dd($log_cot->all());
                            cot_logs::create($log_cot->all());
                            return redirect('pages/cotizaciones_impo')->with('estado3', $cot1->consecutivo_impo);
                            break;
                        case '4':
                            return redirect('pages/cotizaciones_impo')->with('estado4', $cot1->consecutivo_impo);
                            break;
                        case '5':
                            return redirect('pages/cotizaciones_impo')->with('estado5', $cot1->consecutivo_impo);
                            break;
                        case '10':
                            return redirect('pages/cotizaciones_impo')->with('estado10', $cot1->consecutivo_impo);
                            break;
                        case '11':
                            return redirect('pages/cotizaciones_impo')->with('estado11', $cot1->consecutivo_impo);
                            break;
                        case '2':
                            return redirect('pages/cotizaciones_impo')->with('estado2', $cot1->consecutivo_impo);
                            break;
                        case '8':
                            return redirect('pages/cotizaciones_impo')->with('estado8', $cot1->consecutivo_impo);
                            break;
                        case '12':
                            return redirect('pages/cotizaciones_impo')->with('estado12', $cot1->consecutivo_impo);
                            break;
                        case '13':
                            return redirect('pages/cotizaciones_impo')->with('estado13', $cot1->consecutivo_impo);
                            break;
                        case '14':
                            return redirect('pages/cotizaciones_impo')->with('estado14', $cot1->consecutivo_impo);
                            break;
                        case '15':
                            return redirect('pages/cotizaciones_impo')->with('estado15', $cot1->consecutivo_impo);
                            break;
                        case '16':
                            return redirect('pages/cotizaciones_impo')->with('estado16', $cot1->consecutivo_impo);
                            break;
                        case '17':
                            return redirect('pages/cotizaciones_impo')->with('estado17', $cot1->consecutivo_impo);
                            break;
                        case '18':
                            return redirect('pages/cotizaciones_impo')->with('estado18', $cot1->consecutivo_impo);
                            break;
                    }
                    //return redirect('pages/cotizaciones_impo')->with('estado', $cot1->consecutivo_impo);
                }
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar_est_na(Request $request, $id)
    {
        $datos = $request->all();
        $cot = Cotizacion::findOrFail($id)->get();
        foreach ($cot as $cot1) {
            if ($cot1->cot_id == $id) {
                $datos['estado_id'] = 8;
                Cotizacion::findOrFail($id)->update($datos);
                if ($cot1->consecutivo_mn != null) {
                    return redirect('pages/cotizaciones_mn')->with('estado_na', $cot1->consecutivo_mn);
                } elseif ($cot1->consecutivo_expo != null) {
                    return redirect('pages/cotizaciones_expo')->with('estado_na', $cot1->consecutivo_expo);
                } else {
                    return redirect('pages/cotizaciones_impo')->with('estado_na', $cot1->consecutivo_impo);
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eliminar($id)
    {
        //
    }

    public function getPais_cot()
    {
        try {
            $paises = Pais::all();
            $response = ['data' => $paises];
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Error al traer registros'], 500);
        }
        return response()->json($response);
    }

    public function getCiudades_cot(Request $request)
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

    public function getNotas(Request $request)
    {
        try {
            $cot_id = $request->input('cot_id');
            $notas = Notas::where('cot_id', $cot_id)->get();
            $response = ['data' => $notas];
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Error al traer registros'], 500);
        }
        return response()->json($response);
    }

    public function getEstados()
    {
        try {
            $estados = Estado::where('mod', 'CT')->get();
            $response = ['data' => $estados];
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Error al traer registros'], 500);
        }
        return response()->json($response);
    }

    public function getReferencia(Request $request)
    {
        try {
            $toper = $request->input('toper_id');
            $tcliente = $request->input('tcliente_id');
            $producto = $request->input('producto_id');
            $referencias = Referencia::where([['toper_id', '=', $toper], ['tcliente_id', '=', $tcliente], ['producto_id', '=', $producto]])->get();
            $response = ['data' => $referencias];
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Error al traer registros'], 500);
        }
        return response()->json($response);
    }

    public function getTransporte()
    {
        try {
            $tipotransportes = TipoTransporte::orderBy('tipotransporte')->get();
            $response = ['data' => $tipotransportes];
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Error al traer registros'], 500);
        }
        return response()->json($response);
    }

    public function getCuenta_mn()
    {
        try {
            $cotizacion = Cotizacion::whereNotNull('consecutivo_mn')->count();
            $response = ['data' => $cotizacion];
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Error al traer registros'], 500);
        }
        return response()->json($response);
    }

    public function getCuenta_impo()
    {
        try {
            $cotizacion = Cotizacion::whereNotNull('consecutivo_impo')->count();
            $response = ['data' => $cotizacion];
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Error al traer registros'], 500);
        }
        return response()->json($response);
    }

    public function getCuenta_expo()
    {
        try {
            $cotizacion = Cotizacion::whereNotNull('consecutivo_expo')->count();
            $response = ['data' => $cotizacion];
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Error al traer registros'], 500);
        }
        return response()->json($response);
    }
}
