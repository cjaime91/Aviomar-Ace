<?php

use App\Models\Ciudad;
use App\Models\pages\Agente;
use App\Models\pages\cot_logs;
use App\Models\pages\Cotizacion;
use App\Models\pages\Estado;
use App\Models\pages\Notas;
use App\Models\pages\Referencia;
use App\Models\pages\TipoTransporte;
use App\Models\Pais;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/cotizaciones_mn', function () {
    return datatables()
        ->collection(Cotizacion::join("av_usuarios AS ejecutivo", "av_cotizaciones.usuario_ejecutivo_id", "=", "ejecutivo.id")
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
            ->whereNotnull('consecutivo_mn')
            ->orderBy('cot_id')
            ->get([
                '*', DB::raw('CONCAT(ejecutivo.nombre," ", ejecutivo.apellidos) as ejec'),
                DB::raw('CONCAT(realizado.nombre," ", realizado.apellidos) as reali'), 'ejecutivo.nombre AS NombreE', 'ejecutivo.apellidos AS ApellidosE',
                'controlador.razon_social as Controlador', 'controlador.codigo as ControladorC',
                'agent_origen.razon_social as AgenteO', 'agent_origen.codigo as AgenteOC', 'agent_destino.codigo as AgenteDC',
                'agent_destino.razon_social as AgenteD', 'ciudad_or.ciudad AS CiudadO', 'pais_or.pais as PaisO', 'ciudad_ds.ciudad AS CiudadD',
                'pais_ds.pais AS PaisD', 'realizado.nombre AS NombreR', 'realizado.apellidos AS ApellidosR', 'estado_cot.estado AS EstadoC'
            ]))
        ->addColumn('info', 'pages.cotizaciones.detalles')
        ->rawColumns(['info'])
        ->toJson();
});

Route::get('/cotizaciones_expo', function () {
    return datatables()
        ->collection(Cotizacion::join("av_usuarios AS ejecutivo", "av_cotizaciones.usuario_ejecutivo_id", "=", "ejecutivo.id")
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
            ->whereNotnull('consecutivo_expo')
            ->orderBy('cot_id')->get([
                '*', DB::raw('CONCAT(ejecutivo.nombre," ", ejecutivo.apellidos) as ejec'),
                DB::raw('CONCAT(realizado.nombre," ", realizado.apellidos) as reali'), 'ejecutivo.nombre as NombreE', 'ejecutivo.apellidos as ApellidosE', 'controlador.razon_social as Controlador', 'controlador.codigo as ControladorC',
                'agent_origen.razon_social as AgenteO', 'agent_origen.codigo as AgenteOC', 'agent_destino.codigo as AgenteDC',
                'agent_destino.razon_social as AgenteD', 'ciudad_or.ciudad AS CiudadO', 'pais_or.pais as PaisO', 'ciudad_ds.ciudad AS CiudadD',
                'pais_ds.pais AS PaisD', 'realizado.nombre AS NombreR', 'realizado.apellidos AS ApellidosR', 'estado_cot.estado AS EstadoC'
            ]))
        ->addColumn('info', 'pages.cotizaciones.detalles')
        ->rawColumns(['info'])
        ->toJson();
});

Route::get('/cotizaciones_impo', function () {
    return datatables()
        ->collection(Cotizacion::join("av_usuarios AS ejecutivo", "av_cotizaciones.usuario_ejecutivo_id", "=", "ejecutivo.id")
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
            ->whereNotnull('consecutivo_impo')
            ->orderBy('cot_id')->get([
                '*', DB::raw('CONCAT(ejecutivo.nombre," ", ejecutivo.apellidos) as ejec'),
                DB::raw('CONCAT(realizado.nombre," ", realizado.apellidos) as reali'), 'ejecutivo.nombre as NombreE', 'ejecutivo.apellidos as ApellidosE', 'controlador.razon_social as Controlador', 'controlador.codigo as ControladorC',
                'agent_origen.razon_social as AgenteO', 'agent_origen.codigo as AgenteOC', 'agent_destino.codigo as AgenteDC',
                'agent_destino.razon_social as AgenteD', 'ciudad_or.ciudad AS CiudadO', 'pais_or.pais as PaisO', 'ciudad_ds.ciudad AS CiudadD',
                'pais_ds.pais AS PaisD', 'realizado.nombre AS NombreR', 'realizado.apellidos AS ApellidosR', 'estado_cot.estado AS EstadoC'
            ]))
        ->addColumn('info', 'pages.cotizaciones.detalles')
        ->rawColumns(['info'])
        ->toJson();
});

Route::get('/agentes', function () {
    return datatables()
        ->collection(Agente::join("av_estados", "av_agentes.estado_id", "=", "av_estados.estado_id")
            ->join("av_ciudades", "av_agentes.ciudad_id", "=", "av_ciudades.ciudad_id")
            ->join("av_paises", "av_agentes.cod_pais", "=", "av_paises.cod")
            ->orderBy('agente_id')
            ->get())
        ->addColumn('info', 'pages.cotizaciones.detalles')
        ->rawColumns(['info'])
        ->toJson();
});


Route::get('/paises', function () {
    try {
        $paises = Pais::all();
        $response = ['data' => $paises];
    } catch (\Exception $exception) {
        return response()->json(['message' => 'Error al traer registros'], 500);
    }
    return response()->json($response);
});


Route::get('/ciudades', function (Request $request) {
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
});


Route::get('/referencia', function (Request $request) {
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
});


Route::get('/transporte', function () {
    try {
        $tipotransportes = TipoTransporte::orderBy('tipotransporte')->get();
        $response = ['data' => $tipotransportes];
    } catch (\Exception $exception) {
        return response()->json(['message' => 'Error al traer registros'], 500);
    }
    return response()->json($response);
});


Route::get('/estados_cot', function () {
    try {
        $estados = Estado::where('mod', 'CT')->get();
        $response = ['data' => $estados];
    } catch (\Exception $exception) {
        return response()->json(['message' => 'Error al traer registros'], 500);
    }
    return response()->json($response);
});


Route::get('/notas', function (Request $request) {
    try {
        $cot_id = $request->input('cot_id');
        $notas = Notas::leftjoin("av_usuarios AS realizado", "av_notascot.usuario_com_id", "=", "realizado.id")
            ->where('cot_id', $cot_id)
            ->orderBy('nota_id')->get();
        $response = ['data' => $notas];
    } catch (\Exception $exception) {
        return response()->json(['message' => 'Error al traer registros'], 500);
    }
    return response()->json($response);
});

Route::get('/fecha_a', function (Request $request) {
    try {
        $cot_id = $request->input('cot_id');
        $logs = cot_logs::leftjoin("av_usuarios AS aprueba", "av_cot_logs.usuario_id", "=", "aprueba.id")
            ->leftjoin("av_cotizaciones as cot", "av_cot_logs.cot_id", "=", "cot.cot_id")
            ->where('cot.cot_id', $cot_id)
            ->orderBy('cot.cot_id')->get();
        $response = ['data' => $logs];
    } catch (\Exception $exception) {
        return response()->json(['message' => 'Error al traer registros'], 500);
    }
    return response()->json($response);
});

Route::get('/mercados', function (Request $request) {
    try {
        $mercado = $request->input('mercado');
        $anio = $request->input('anio');
        if ($anio == 0) {
            $anio = DATE('Y');
        }
        if ($mercado == '') {
            $estado_x_mes = Cotizacion::select(DB::raw("MONTH(fecha), DATE_FORMAT(fecha,'%M') AS mes, COUNT(*) AS cuenta"))
                ->whereYear('fecha', $anio)
                ->groupBy(DB::raw("DATE_FORMAT(fecha,'%M'),MONTH(fecha)"))
                ->orderBy(DB::raw("MONTH(fecha)"))
                ->get();
        } else {
            $estado_x_mes = Cotizacion::select(DB::raw("MONTH(fecha), DATE_FORMAT(fecha,'%M') AS mes, COUNT(*) AS cuenta"))
                ->whereYear('fecha', $anio)
                ->whereNotnull($mercado)
                ->groupBy(DB::raw("DATE_FORMAT(fecha,'%M'),MONTH(fecha)"))
                ->orderBy(DB::raw("MONTH(fecha)"))
                ->get();
        }
        $response = ['data' => $estado_x_mes];
    } catch (\Exception $exception) {
        return response()->json(['message' => 'Error al traer registros'], 500);
    }
    return response()->json($response);
});

Route::get('/estados', function (Request $request) {
    try {
        $mes = $request->input('mes');
        $mercado = $request->input('mercado');
        $anio = $request->input('anio');
        if ($anio == 0) {
            $anio = DATE('Y');
        }
        if ($mercado == '' && $mes == '') {
            $estados_mn = DB::select("SELECT estado AS name, COUNT(*) AS cuenta, color
            FROM av_cotizaciones
            LEFT JOIN av_estados AS e ON av_cotizaciones.estado_id = e.estado_id
            WHERE YEAR(fecha) = '$anio'
            GROUP BY estado, color");
            $response = ['data' => $estados_mn];
        } else if ($mercado == '') {
            $estados_mn = DB::select("SELECT estado AS name, COUNT(*) AS cuenta, color
            FROM av_cotizaciones
            LEFT JOIN av_estados AS e ON av_cotizaciones.estado_id = e.estado_id
            WHERE MONTH(fecha) = '$mes'
            AND YEAR(fecha) = '$anio'
            GROUP BY estado, color");

            $response = ['data' => $estados_mn];
        } else if ($mes == '') {
            $estados_mn = DB::select("SELECT estado AS name, COUNT(*) AS cuenta, color
            FROM av_cotizaciones
            LEFT JOIN av_estados AS e ON av_cotizaciones.estado_id = e.estado_id
            WHERE $mercado IS NOT null
            AND YEAR(fecha) = '$anio'
            GROUP BY estado, color");

            $response = ['data' => $estados_mn];
        } else {
            $estados_mn = DB::select("SELECT estado AS name, COUNT(*) AS cuenta, color
            FROM av_cotizaciones
            LEFT JOIN av_estados AS e ON av_cotizaciones.estado_id = e.estado_id
            WHERE MONTH(fecha) = '$mes'
            AND YEAR(fecha) = '$anio'
            AND $mercado IS NOT null
            GROUP BY estado, color");

            $response = ['data' => $estados_mn];
        }
    } catch (\Exception $exception) {
        return response()->json(['message' => 'Error al traer registros'], 500);
    }
    return response()->json($response);
});



Route::get('/productos_m', function (Request $request) {
    try {
        $mes = $request->input('mes');
        $mercado = $request->input('mercado');
        $anio = $request->input('anio');
        if ($anio == 0) {
            $anio = DATE('Y');
        }
        if ($mercado == '' && $mes == '') {
            $por_producto_m = DB::select("SELECT producto, CONVERT(SUM(Sol),UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap),UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT producto, COUNT(*) AS Sol, 0 AS Ap
            FROM av_cotizaciones
            LEFT JOIN av_productos AS p ON av_cotizaciones.producto_id = p.producto_id
            WHERE YEAR(fecha) = '$anio'
            GROUP BY producto
            UNION ALL
            SELECT producto, 0 AS Sol, COUNT(*) AS Ap
            FROM av_cotizaciones
            LEFT JOIN av_productos AS p ON av_cotizaciones.producto_id = p.producto_id
            WHERE YEAR(fecha) = '$anio'
            AND estado_id = 3
            GROUP BY producto) product
            GROUP BY producto
            ORDER BY Producto");
        } else if ($mercado == '') {
            $por_producto_m = DB::select("SELECT producto, CONVERT(SUM(Sol),UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap),UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT producto, COUNT(*) AS Sol, 0 AS Ap
            FROM av_cotizaciones
            LEFT JOIN av_productos AS p ON av_cotizaciones.producto_id = p.producto_id
            WHERE YEAR(fecha) = '$anio'
            AND MONTH(fecha) = '$mes'
            GROUP BY producto
            UNION ALL
            SELECT producto, 0 AS Sol, COUNT(*) AS Ap
            FROM av_cotizaciones
            LEFT JOIN av_productos AS p ON av_cotizaciones.producto_id = p.producto_id
            WHERE YEAR(fecha) = '$anio'
            AND MONTH(fecha) = '$mes'
            AND estado_id = 3
            GROUP BY producto) product
            GROUP BY producto
            ORDER BY Producto");
        } else if ($mes == '') {
            $por_producto_m = DB::select("SELECT producto, CONVERT(SUM(Sol),UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap),UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT producto, COUNT(*) AS Sol, 0 AS Ap
            FROM av_cotizaciones
            LEFT JOIN av_productos AS p ON av_cotizaciones.producto_id = p.producto_id
            WHERE YEAR(fecha) = '$anio'
            AND $mercado IS NOT NULL
            GROUP BY producto
            UNION ALL
            SELECT producto, 0 AS Sol, COUNT(*) AS Ap
            FROM av_cotizaciones
            LEFT JOIN av_productos AS p ON av_cotizaciones.producto_id = p.producto_id
            WHERE YEAR(fecha) = '$anio'
            AND $mercado IS NOT NULL
            AND estado_id = 3
            GROUP BY producto) product
            GROUP BY producto
            ORDER BY Producto");
        } else {
            $por_producto_m = DB::select("SELECT producto, CONVERT(SUM(Sol),UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap),UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT producto, COUNT(*) AS Sol, 0 AS Ap
            FROM av_cotizaciones
            LEFT JOIN av_productos AS p ON av_cotizaciones.producto_id = p.producto_id
            WHERE YEAR(fecha) = '$anio'
            AND MONTH(fecha) = '$mes'
            AND $mercado IS NOT NULL
            GROUP BY producto
            UNION ALL
            SELECT producto, 0 AS Sol, COUNT(*) AS Ap
            FROM av_cotizaciones
            LEFT JOIN av_productos AS p ON av_cotizaciones.producto_id = p.producto_id
            WHERE YEAR(fecha) = '$anio'
            AND MONTH(fecha) = '$mes'
            AND $mercado IS NOT NULL
            AND estado_id = 3
            GROUP BY producto) product
            GROUP BY producto
            ORDER BY Producto");
        }
        $response = ['data' => $por_producto_m];
    } catch (\Exception $exception) {
        return response()->json(['message' => 'Error al traer registros'], 500);
    }
    return response()->json($response);
});



Route::get('/productos_ap', function (Request $request) {
    try {
        $mes = $request->input('mes');
        $mercado = $request->input('mercado');
        $anio = $request->input('anio');
        if ($anio == 0) {
            $anio = DATE('Y');
        }
        if ($mercado == '' && $mes == '') {
            $por_producto_ap = DB::select("SELECT producto AS name, COUNT(*) as cuenta
            FROM av_cotizaciones
            LEFT JOIN av_productos AS p ON av_cotizaciones.producto_id = p.producto_id
            WHERE YEAR(fecha) = '$anio'
            AND estado_id = 3
            GROUP BY producto
            ORDER BY producto");
        } else if ($mercado == '') {
            $por_producto_ap = DB::select("SELECT producto AS name, COUNT(*) as cuenta
            FROM av_cotizaciones
            LEFT JOIN av_productos AS p ON av_cotizaciones.producto_id = p.producto_id
            WHERE MONTH(fecha) = '$mes'
            AND YEAR(fecha) = '$anio'
            AND estado_id = 3
            GROUP BY producto
            ORDER BY producto");
        } else if ($mes == '') {
            $por_producto_ap = DB::select("SELECT producto AS name, COUNT(*) as cuenta
            FROM av_cotizaciones
            LEFT JOIN av_productos AS p ON av_cotizaciones.producto_id = p.producto_id
            WHERE YEAR(fecha) = '$anio'
            AND $mercado IS NOT null
            AND estado_id = 3
            GROUP BY producto
            ORDER BY producto");
        } else {
            $por_producto_ap = DB::select("SELECT producto AS name, COUNT(*) as cuenta
            FROM av_cotizaciones
            LEFT JOIN av_productos AS p ON av_cotizaciones.producto_id = p.producto_id            
            WHERE MONTH(fecha) = '$mes'
            AND YEAR(fecha) = '$anio'
            AND $mercado IS NOT null
            AND estado_id = 3
            GROUP BY producto
            ORDER BY producto");
        }
        $response = ['data' => $por_producto_ap];
    } catch (\Exception $exception) {
        return response()->json(['message' => 'Error al traer registros'], 500);
    }
    return response()->json($response);
});


Route::get('/operaciones_m', function (Request $request) {
    try {
        $mes = $request->input('mes');
        $mercado = $request->input('mercado');
        $anio = $request->input('anio');
        if ($anio == 0) {
            $anio = DATE('Y');
        }
        if ($mercado == '' && $mes == '') {
            $por_operacion_m = DB::select("SELECT tipooperacion, CONVERT(SUM(Sl),UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap),UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT tipooperacion, COUNT(*) AS Sl, 0 AS Ap
            FROM av_cotizaciones
            LEFT JOIN av_tipooperacion AS t ON av_cotizaciones.toper_id = t.toper_id
            WHERE YEAR(fecha) = '$anio'
            GROUP BY tipooperacion
            UNION ALL
            SELECT tipooperacion, 0 AS Sl, COUNT(*) AS Ap
            FROM av_cotizaciones
            LEFT JOIN av_tipooperacion AS t ON av_cotizaciones.toper_id = t.toper_id
            WHERE YEAR(fecha) = '$anio'
            AND estado_id = 3
            GROUP BY tipooperacion) tipo_operacion
            GROUP BY tipooperacion");
        } else if ($mercado == '') {
            $por_operacion_m = DB::select("SELECT tipooperacion, CONVERT(SUM(Sl),UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap),UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT tipooperacion, COUNT(*) AS Sl, 0 AS Ap
            FROM av_cotizaciones
            LEFT JOIN av_tipooperacion AS t ON av_cotizaciones.toper_id = t.toper_id
            WHERE YEAR(fecha) = '$anio'
            AND MONTH(fecha) = '$mes'
            GROUP BY tipooperacion
            UNION ALL
            SELECT tipooperacion, 0 AS Sl, COUNT(*) AS Ap
            FROM av_cotizaciones
            LEFT JOIN av_tipooperacion AS t ON av_cotizaciones.toper_id = t.toper_id
            WHERE YEAR(fecha) = '$anio'
            AND MONTH(fecha) = '$mes'
            AND estado_id = 3
            GROUP BY tipooperacion) tipo_operacion
            GROUP BY tipooperacion");
        } else if ($mes == '') {
            $por_operacion_m = DB::select("SELECT tipooperacion, CONVERT(SUM(Sl),UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap),UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT tipooperacion, COUNT(*) AS Sl, 0 AS Ap
            FROM av_cotizaciones
            LEFT JOIN av_tipooperacion AS t ON av_cotizaciones.toper_id = t.toper_id
            WHERE YEAR(fecha) = '$anio'
            AND $mercado IS NOT NULL
            GROUP BY tipooperacion
            UNION ALL
            SELECT tipooperacion, 0 AS Sl, COUNT(*) AS Ap
            FROM av_cotizaciones
            LEFT JOIN av_tipooperacion AS t ON av_cotizaciones.toper_id = t.toper_id
            WHERE YEAR(fecha) = '$anio'
            AND $mercado IS NOT NULL
            AND estado_id = 3
            GROUP BY tipooperacion) tipo_operacion
            GROUP BY tipooperacion");
        } else {
            $por_operacion_m = DB::select("SELECT tipooperacion, CONVERT(SUM(Sl),UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap),UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT tipooperacion, COUNT(*) AS Sl, 0 AS Ap
            FROM av_cotizaciones
            LEFT JOIN av_tipooperacion AS t ON av_cotizaciones.toper_id = t.toper_id
            WHERE YEAR(fecha) = '$anio'
            AND MONTH(fecha) = '$mes'
            AND $mercado IS NOT NULL
            GROUP BY tipooperacion
            UNION ALL
            SELECT tipooperacion, 0 AS Sl, COUNT(*) AS Ap
            FROM av_cotizaciones
            LEFT JOIN av_tipooperacion AS t ON av_cotizaciones.toper_id = t.toper_id
            WHERE YEAR(fecha) = '$anio'
            AND MONTH(fecha) = '$mes'
            AND $mercado IS NOT NULL
            AND estado_id = 3
            GROUP BY tipooperacion) tipo_operacion
            GROUP BY tipooperacion");
        }
        $response = ['data' => $por_operacion_m];
    } catch (\Exception $exception) {
        return response()->json(['message' => 'Error al traer registros'], 500);
    }
    return response()->json($response);
});


Route::get('/paises_sl', function (Request $request) {
    try {
        $mes = $request->input('mes');
        $mercado = $request->input('mercado');
        $anio = $request->input('anio');
        if ($anio == 0) {
            $anio = DATE('Y');
        }
        if ($mercado == '' && $mes == '') {
            $por_paises = DB::select("SELECT pais, CONVERT(SUM(Sol), UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap), UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT pais, 0 AS Sol, COUNT(*) AS Ap
            FROM av_cotizaciones AS c
            JOIN av_paises AS p ON c.cod_pais_or= p.cod
            WHERE estado_id=3 AND YEAR(fecha) = '$anio' AND NOT pais='Colombia'
            GROUP BY pais UNION ALL
            SELECT pais, COUNT(*) AS Sol,0 AS Ap
            FROM av_cotizaciones AS c
            JOIN av_paises AS p ON c.cod_pais_or= p.cod
            WHERE NOT pais='Colombia' AND YEAR(fecha) = '$anio'
            GROUP BY pais) ps
            GROUP BY pais
            ORDER BY Aprobadas DESC
            LIMIT 15");
        } else if ($mercado == '') {
            $por_paises = DB::select("SELECT pais, CONVERT(SUM(Sol), UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap), UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT pais, 0 AS Sol, COUNT(*) AS Ap
            FROM av_cotizaciones AS c
            JOIN av_paises AS p ON c.cod_pais_or= p.cod
            WHERE estado_id=3 AND MONTH(fecha) = '$mes' AND YEAR(fecha) = '$anio' AND NOT pais='Colombia'
            GROUP BY pais UNION ALL
            SELECT pais, COUNT(*) AS Sol,0 AS Ap
            FROM av_cotizaciones AS c
            JOIN av_paises AS p ON c.cod_pais_or= p.cod
            WHERE MONTH(fecha) = '$mes' AND NOT pais='Colombia' AND YEAR(fecha) = '$anio'
            GROUP BY pais) ps
            GROUP BY pais
            ORDER BY Aprobadas DESC
            LIMIT 15");
        } else if ($mes == '') {
            $por_paises = DB::select("SELECT pais, CONVERT(SUM(Sol), UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap), UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT pais, 0 AS Sol, COUNT(*) AS Ap
            FROM av_cotizaciones AS c
            JOIN av_paises AS p ON c.cod_pais_or= p.cod
            WHERE estado_id=3 AND YEAR(fecha) = '$anio' AND NOT pais='Colombia' AND $mercado IS NOT NULL
            GROUP BY pais UNION ALL
            SELECT pais, COUNT(*) AS Sol,0 AS Ap
            FROM av_cotizaciones AS c
            JOIN av_paises AS p ON c.cod_pais_or= p.cod
            WHERE NOT pais='Colombia' AND YEAR(fecha) = '$anio' AND $mercado IS NOT NULL
            GROUP BY pais) ps
            GROUP BY pais
            ORDER BY Aprobadas DESC
            LIMIT 15");
        } else {
            $por_paises = DB::select("SELECT pais, CONVERT(SUM(Sol), UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap), UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT pais, 0 AS Sol, COUNT(*) AS Ap
            FROM av_cotizaciones AS c
            JOIN av_paises AS p ON c.cod_pais_or= p.cod
            WHERE estado_id=3 AND MONTH(fecha) = '$mes' AND YEAR(fecha) = '$anio' AND NOT pais='Colombia' AND $mercado IS NOT NULL
            GROUP BY pais UNION ALL
            SELECT pais, COUNT(*) AS Sol,0 AS Ap
            FROM av_cotizaciones AS c
            JOIN av_paises AS p ON c.cod_pais_or= p.cod
            WHERE MONTH(fecha) = '$mes' AND NOT pais='Colombia' AND YEAR(fecha) = '$anio' AND $mercado IS NOT NULL
            GROUP BY pais) ps
            GROUP BY pais
            ORDER BY Aprobadas DESC
            LIMIT 15");
        }
        $response = ['data' => $por_paises];
    } catch (\Exception $exception) {
        return response()->json(['message' => 'Error al traer registros'], 500);
    }
    return response()->json($response);
});


Route::get('/agentes_c', function (Request $request) {
    try {
        $mes = $request->input('mes');
        $mercado = $request->input('mercado');
        $anio = $request->input('anio');
        if ($anio == 0) {
            $anio = DATE('Y');
        }
        if ($mercado == '' && $mes == '') {
            $por_agente = DB::select("SELECT razon_social, CONVERT(SUM(Sol), UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap), UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT razon_social, 0 AS Sol, COUNT(*) AS Ap
            FROM av_cotizaciones AS c
            JOIN av_agentes AS Controlador ON c.agente_id_c=Controlador.agente_id
            JOIN av_paises AS p ON Controlador.cod_pais= p.cod
            WHERE c.estado_id=3 AND YEAR(fecha) = '$anio' AND NOT pais='Colombia'
            GROUP BY razon_social UNION ALL
            SELECT razon_social, COUNT(*) AS Sol,0 AS Ap
            FROM av_cotizaciones AS c
            JOIN av_agentes AS Controlador ON c.agente_id_c=Controlador.agente_id
            JOIN av_paises AS p ON Controlador.cod_pais= p.cod
            WHERE NOT pais='Colombia' AND YEAR(fecha) = '$anio'
            GROUP BY razon_social) rs
            GROUP BY razon_social
            ORDER BY Aprobadas DESC
            LIMIT 20");
        } else if ($mercado == '') {
            $por_agente = DB::select("SELECT razon_social, CONVERT(SUM(Sol), UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap), UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT razon_social, 0 AS Sol, COUNT(*) AS Ap
            FROM av_cotizaciones AS c
            JOIN av_agentes AS Controlador ON c.agente_id_c=Controlador.agente_id
            JOIN av_paises AS p ON Controlador.cod_pais= p.cod
            WHERE c.estado_id=3 AND YEAR(fecha) = '$anio' AND MONTH(fecha) = '$mes' AND NOT pais='Colombia'
            GROUP BY razon_social UNION ALL
            SELECT razon_social, COUNT(*) AS Sol,0 AS Ap
            FROM av_cotizaciones AS c
            JOIN av_agentes AS Controlador ON c.agente_id_c=Controlador.agente_id
            JOIN av_paises AS p ON Controlador.cod_pais= p.cod
            WHERE NOT pais='Colombia' AND YEAR(fecha) = '$anio' AND MONTH(fecha) = '$mes'
            GROUP BY razon_social) rs
            GROUP BY razon_social
            ORDER BY Aprobadas DESC
            LIMIT 20");
        } else if ($mes == '') {
            $por_agente = DB::select("SELECT razon_social, CONVERT(SUM(Sol), UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap), UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT razon_social, 0 AS Sol, COUNT(*) AS Ap
            FROM av_cotizaciones AS c
            JOIN av_agentes AS Controlador ON c.agente_id_c=Controlador.agente_id
            JOIN av_paises AS p ON Controlador.cod_pais= p.cod
            WHERE c.estado_id=3 AND YEAR(fecha) = '$anio' AND NOT pais='Colombia' AND $mercado IS NOT NULL
            GROUP BY razon_social UNION ALL
            SELECT razon_social, COUNT(*) AS Sol,0 AS Ap
            FROM av_cotizaciones AS c
            JOIN av_agentes AS Controlador ON c.agente_id_c=Controlador.agente_id
            JOIN av_paises AS p ON Controlador.cod_pais= p.cod
            WHERE NOT pais='Colombia' AND YEAR(fecha) = '$anio' AND $mercado IS NOT NULL
            GROUP BY razon_social) rs
            GROUP BY razon_social
            ORDER BY Aprobadas DESC
            LIMIT 20");
        } else {
            $por_agente = DB::select("SELECT razon_social, CONVERT(SUM(Sol), UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap), UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT razon_social, 0 AS Sol, COUNT(*) AS Ap
            FROM av_cotizaciones AS c
            JOIN av_agentes AS Controlador ON c.agente_id_c=Controlador.agente_id
            JOIN av_paises AS p ON Controlador.cod_pais= p.cod
            WHERE c.estado_id=3 AND YEAR(fecha) = '$anio' AND MONTH(fecha) = '$mes' AND NOT pais='Colombia' AND $mercado IS NOT NULL
            GROUP BY razon_social UNION ALL
            SELECT razon_social, COUNT(*) AS Sol,0 AS Ap
            FROM av_cotizaciones AS c
            JOIN av_agentes AS Controlador ON c.agente_id_c=Controlador.agente_id
            JOIN av_paises AS p ON Controlador.cod_pais= p.cod
            WHERE NOT pais='Colombia' AND YEAR(fecha) = '$anio' AND MONTH(fecha) = '$mes' AND $mercado IS NOT NULL
            GROUP BY razon_social) rs
            GROUP BY razon_social
            ORDER BY Aprobadas DESC
            LIMIT 20");
        }
        $response = ['data' => $por_agente];
    } catch (\Exception $exception) {
        return response()->json(['message' => 'Error al traer registros'], 500);
    }
    return response()->json($response);
});

Route::get('/reciprocidad', function (Request $request) {
    try {
        $producto = $request->input('producto');
        $operacion = $request->input('operacion');
        $mes = $request->input('mes');
        switch ($operacion) {
            case 1:
                $rec = DB::select("SELECT Agente AS 'Agente', 
                    CONVERT(SUM(GANADOS1), UNSIGNED INTEGER) AS GANADAS_AG, 
                    CONVERT(SUM(PERDIDAS1), UNSIGNED INTEGER) AS PERDIDAS_AG, 
                    CONVERT(SUM(PENDIENTES1), UNSIGNED INTEGER) AS PENDIENTES_AG, 
                    CONVERT(SUM(GANADOS1)+ SUM(PERDIDAS1)+ SUM(PENDIENTES1), UNSIGNED INTEGER) AS TOTAL_AG, 
                    CONVERT(SUM(GANADOS2), UNSIGNED INTEGER) AS GANADAS_AV, 
                    CONVERT(SUM(PERDIDAS2), UNSIGNED INTEGER) AS PERDIDAS_AV, 
                    CONVERT(SUM(PENDIENTES2), UNSIGNED INTEGER) AS PENDIENTES_AV, 
                    CONVERT(SUM(GANADOS2)+ SUM(PERDIDAS2)+ SUM(PENDIENTES2), UNSIGNED INTEGER) AS TOTAL_AV, 
                    CONVERT(SUM(CBM_GE_AG), UNSIGNED INTEGER) AS CBM_GE_AG, 
                    CONVERT(SUM(CBM_PE_AG), UNSIGNED INTEGER) AS CBM_PE_AG, 
                    CONVERT(SUM(CBM_PDE_AG), UNSIGNED INTEGER) AS CBM_PDE_AG, 
                    CONVERT(SUM(CBM_GE_AV), UNSIGNED INTEGER) AS CBM_GE_AV, 
                    CONVERT(SUM(CBM_PE_AV), UNSIGNED INTEGER) AS CBM_PE_AV, 
                    CONVERT(SUM(CBM_PDE_AV), UNSIGNED INTEGER) AS CBM_PDE_AV, 
                    CONVERT(SUM(LIBRAS_GE_AG), UNSIGNED INTEGER) AS LIBRAS_GE_AG, 
                    CONVERT(SUM(LIBRAS_PE_AG), UNSIGNED INTEGER) AS LIBRAS_PE_AG, 
                    CONVERT(SUM(LIBRAS_PDE_AG), UNSIGNED INTEGER) AS LIBRAS_PDE_AG, 
                    CONVERT(SUM(LIBRAS_GE_AV), UNSIGNED INTEGER) AS LIBRAS_GE_AV, 
                    CONVERT(SUM(LIBRAS_PE_AV), UNSIGNED INTEGER) AS LIBRAS_PE_AV, 
                    CONVERT(SUM(LIBRAS_PDE_AV), UNSIGNED INTEGER) AS LIBRAS_PDE_AV 
                    FROM (
                    SELECT DISTINCT a_destino.razon_social AS 'Agente', 
                    COUNT(a_destino.razon_social) AS 'GANADOS1', 
                    0 AS 'PERDIDAS1', 
                    0 AS 'PENDIENTES1',
                    0 AS 'GANADOS2',
                    0 AS 'PERDIDAS2',
                    0 AS 'PENDIENTES2',
                    SUM(coti.cbm)+SUM(coti.cbm_a)+SUM(coti.cbm_m) AS 'CBM_GE_AG',
                    0 AS 'CBM_PE_AG',
                    0 AS 'CBM_PDE_AG',
                    0 AS 'CBM_GE_AV',
                    0 AS 'CBM_PE_AV',
                    0 AS 'CBM_PDE_AV',
                    SUM(coti.libras)+SUM(coti.libras_a)+SUM(coti.libras_m) AS 'LIBRAS_GE_AG',
                    0 AS 'LIBRAS_PE_AG',
                    0 AS 'LIBRAS_PDE_AG',
                    0 AS 'LIBRAS_GE_AV',
                    0 AS 'LIBRAS_PE_AV',
                    0 AS 'LIBRAS_PDE_AV'
                    FROM av_cotizaciones AS coti
                    JOIN av_agentes AS controlador ON coti.agente_id_c=controlador.agente_id
                    JOIN av_agentes AS a_origen ON coti.agente_id_o=a_origen.agente_id
                    JOIN av_agentes AS a_destino ON coti.agente_id_d=a_destino.agente_id
                    JOIN av_tipooperacion AS operacion ON coti.toper_id=operacion.toper_id
                    JOIN av_productos AS producto ON coti.producto_id=producto.producto_id
                    WHERE controlador.razon_social IN ('Aviomar S.A.S') 
                    AND a_destino.razon_social NOT IN ('Aviomar S.A.S') 
                    AND coti.estado_id IN (3) 
                    AND operacion.toper_id=1 
                    AND MONTH(fecha) LIKE '%$mes%' 
                    AND producto.producto LIKE '%$producto%'
                    GROUP BY a_destino.razon_social UNION ALL
                    SELECT DISTINCT a_destino.razon_social AS 'Agente',
                    0 AS 'GANADOS1', 
                    COUNT(a_destino.razon_social) AS 'PERDIDAS1', 
                    0 AS 'PENDIENTES1',
                    0 AS 'GANADOS2',
                    0 AS 'PERDIDAS2',
                    0 AS 'PENDIENTES2',
                    0 AS 'CBM_GE_AG',
                    SUM(coti.cbm)+SUM(coti.cbm_a)+SUM(coti.cbm_m) AS 'CBM_PE_AG',
                    0 AS 'CBM_PDE_AG',
                    0 AS 'CBM_GE_AV',
                    0 AS 'CBM_PE_AV',
                    0 AS 'CBM_PDE_AV',
                    0 AS 'LIBRAS_GE_AG',
                    SUM(coti.libras)+SUM(coti.libras_a)+SUM(coti.libras_m) AS 'LIBRAS_PE_AG',
                    0 AS 'LIBRAS_PDE_AG',
                    0 AS 'LIBRAS_GE_AV',
                    0 AS 'LIBRAS_PE_AV',
                    0 AS 'LIBRAS_PDE_AV'
                    FROM av_cotizaciones AS coti
                    JOIN av_agentes AS controlador ON coti.agente_id_c=controlador.agente_id
                    JOIN av_agentes AS a_origen ON coti.agente_id_o=a_origen.agente_id
                    JOIN av_agentes AS a_destino ON coti.agente_id_d=a_destino.agente_id
                    JOIN av_tipooperacion AS operacion ON coti.toper_id=operacion.toper_id
                    JOIN av_productos AS producto ON coti.producto_id=producto.producto_id
                    WHERE controlador.razon_social IN ('Aviomar S.A.S') 
                    AND a_destino.razon_social NOT IN ('Aviomar S.A.S') 
                    AND coti.estado_id IN (2,8,15,16,18,19) 
                    AND operacion.toper_id=1 
                    AND MONTH(fecha) LIKE '%$mes%' 
                    AND producto.producto LIKE '%$producto%'
                    GROUP BY a_destino.razon_social UNION ALL
                    SELECT DISTINCT a_destino.razon_social AS 'Agente',
                    0 AS 'GANADOS1',
                    0 AS 'PERDIDAS1', 
                    COUNT(a_destino.razon_social) AS 'PENDIENTES1',
                    0 AS 'GANADOS2',
                    0 AS 'PERDIDAS2',
                    0 AS 'PENDIENTES2',
                    0 AS 'CBM_GE_AG',
                    0 AS 'CBM_PE_AG',
                    SUM(coti.cbm)+SUM(coti.cbm_a)+SUM(coti.cbm_m) AS 'CBM_PDE_AG',
                    0 AS 'CBM_GE_AV',
                    0 AS 'CBM_PE_AV',
                    0 AS 'CBM_PDE_AV',
                    0 AS 'LIBRAS_GE_AG',
                    0 AS 'LIBRAS_PE_AG',
                    SUM(coti.libras)+SUM(coti.libras_a)+SUM(coti.libras_m) AS 'LIBRAS_PDE_AG',
                    0 AS 'LIBRAS_GE_AV',
                    0 AS 'LIBRAS_PE_AV',
                    0 AS 'LIBRAS_PDE_AV'
                    FROM av_cotizaciones AS coti
                    JOIN av_agentes AS controlador ON coti.agente_id_c=controlador.agente_id
                    JOIN av_agentes AS a_origen ON coti.agente_id_o=a_origen.agente_id
                    JOIN av_agentes AS a_destino ON coti.agente_id_d=a_destino.agente_id
                    JOIN av_tipooperacion AS operacion ON coti.toper_id=operacion.toper_id
                    JOIN av_productos AS producto ON coti.producto_id=producto.producto_id
                    WHERE controlador.razon_social IN ('Aviomar S.A.S') 
                    AND a_destino.razon_social NOT IN ('Aviomar S.A.S') 
                    AND coti.estado_id IN (4,5,10,11,12) 
                    AND operacion.toper_id=1 
                    AND MONTH(fecha) LIKE '%$mes%' 
                    AND producto.producto LIKE '%$producto%'
                    GROUP BY a_destino.razon_social UNION ALL
                    SELECT DISTINCT controlador.razon_social AS 'Agente', 
                    0 AS 'GANADOS1',
                    0 AS 'PERDIDAS1',
                    0 AS 'PENDIENTES1', 
                    COUNT(a_origen.razon_social) AS 'GANADOS2', 
                    0 AS 'PERDIDAS2', 
                    0 AS 'PENDIENTES2',
                    0 AS 'CBM_GE_AG',
                    0 AS 'CBM_PE_AG',
                    0 AS 'CBM_PDE_AG',
                    SUM(coti.cbm)+SUM(coti.cbm_a)+SUM(coti.cbm_m) AS 'CBM_GE_AV',
                    0 AS 'CBM_PE_AV',
                    0 AS 'CBM_PDE_AV',
                    0 AS 'LIBRAS_GE_AG',
                    0 AS 'LIBRAS_PE_AG',
                    0 AS 'LIBRAS_PDE_AG',
                    SUM(coti.libras)+SUM(coti.libras_a)+SUM(coti.libras_m) AS 'LIBRAS_GE_AV',
                    0 AS 'LIBRAS_PE_AV',
                    0 AS 'LIBRAS_PDE_AV'
                    FROM av_cotizaciones AS coti
                    JOIN av_agentes AS controlador ON coti.agente_id_c=controlador.agente_id
                    JOIN av_agentes AS a_origen ON coti.agente_id_o=a_origen.agente_id
                    JOIN av_agentes AS a_destino ON coti.agente_id_d=a_destino.agente_id
                    JOIN av_tipooperacion AS operacion ON coti.toper_id=operacion.toper_id
                    JOIN av_productos AS producto ON coti.producto_id=producto.producto_id
                    WHERE controlador.razon_social NOT IN ('Aviomar S.A.S') 
                    AND a_origen.razon_social IN ('Aviomar S.A.S') 
                    AND coti.estado_id IN (3) 
                    AND operacion.toper_id=1 
                    AND MONTH(fecha) LIKE '%$mes%' 
                    AND producto.producto LIKE '%$producto%'
                    GROUP BY controlador.razon_social UNION ALL
                    SELECT DISTINCT controlador.razon_social AS 'Agente', 
                    0 AS 'GANADOS1',
                    0 AS 'PERDIDAS1',
                    0 AS 'PENDIENTES1',
                    0 AS 'GANADOS2', 
                    COUNT(a_origen.razon_social) AS 'PERDIDAS2', 
                    0 AS 'PENDIENTES2',
                    0 AS 'CBM_GE_AG',
                    0 AS 'CBM_PE_AG',
                    0 AS 'CBM_PDE_AG',
                    0 AS 'CBM_GE_AV',
                    SUM(coti.cbm)+SUM(coti.cbm_a)+SUM(coti.cbm_m) AS 'CBM_PE_AV',
                    0 AS 'CBM_PDE_AV',
                    0 AS 'LIBRAS_GE_AG',
                    0 AS 'LIBRAS_PE_AG',
                    0 AS 'LIBRAS_PDE_AG',
                    0 AS 'LIBRAS_GE_AV',
                    SUM(coti.libras)+SUM(coti.libras_a)+SUM(coti.libras_m) AS 'LIBRAS_PE_AV',
                    0 AS 'LIBRAS_PDE_AV'
                    FROM av_cotizaciones AS coti
                    JOIN av_agentes AS controlador ON coti.agente_id_c=controlador.agente_id
                    JOIN av_agentes AS a_origen ON coti.agente_id_o=a_origen.agente_id
                    JOIN av_agentes AS a_destino ON coti.agente_id_d=a_destino.agente_id
                    JOIN av_tipooperacion AS operacion ON coti.toper_id=operacion.toper_id
                    JOIN av_productos AS producto ON coti.producto_id=producto.producto_id
                    WHERE controlador.razon_social NOT IN ('Aviomar S.A.S') 
                    AND a_origen.razon_social IN ('Aviomar S.A.S') 
                    AND coti.estado_id IN (2,8,15,16,18,19) 
                    AND operacion.toper_id=1 
                    AND MONTH(fecha) LIKE '%$mes%' 
                    AND producto.producto LIKE '%$producto%'
                    GROUP BY controlador.razon_social UNION ALL
                    SELECT DISTINCT controlador.razon_social AS 'Agente', 
                    0 AS 'GANADOS1',
                    0 AS 'PERDIDAS1',
                    0 AS 'PENDIENTES1',
                    0 AS 'GANADOS2',
                    0 AS 'PERDIDAS2', 
                    COUNT(a_origen.razon_social) AS 'PENDIENTES2',
                    0 AS 'CBM_GE_AG',
                    0 AS 'CBM_PE_AG',
                    0 AS 'CBM_PDE_AG',
                    0 AS 'CBM_GE_AV',
                    0 AS 'CBM_PE_AV',
                    SUM(coti.cbm)+SUM(coti.cbm_a)+SUM(coti.cbm_m) AS 'CBM_PDE_AV',
                    0 AS 'LIBRAS_GE_AG',
                    0 AS 'LIBRAS_PE_AG',
                    0 AS 'LIBRAS_PDE_AG',
                    0 AS 'LIBRAS_GE_AV',
                    0 AS 'LIBRAS_PE_AV',
                    SUM(coti.libras)+SUM(coti.libras_a)+SUM(coti.libras_m) AS 'LIBRAS_PDE_AV'
                    FROM av_cotizaciones AS coti
                    JOIN av_agentes AS controlador ON coti.agente_id_c=controlador.agente_id
                    JOIN av_agentes AS a_origen ON coti.agente_id_o=a_origen.agente_id
                    JOIN av_agentes AS a_destino ON coti.agente_id_d=a_destino.agente_id
                    JOIN av_tipooperacion AS operacion ON coti.toper_id=operacion.toper_id
                    JOIN av_productos AS producto ON coti.producto_id=producto.producto_id
                    WHERE controlador.razon_social NOT IN ('Aviomar S.A.S') 
                    AND a_destino.razon_social IN ('Aviomar S.A.S') 
                    AND coti.estado_id IN (4,5,10,11,12) 
                    AND operacion.toper_id=1 
                    AND MONTH(fecha) LIKE '%$mes%' 
                    AND producto.producto LIKE '%$producto%'
                    GROUP BY controlador.razon_social) AS EXPO
                    GROUP BY Agente
                    ORDER BY Agente");
                break;
            case 2:
                $rec = DB::select("SELECT Agente AS 'Agente', 
                    CONVERT(SUM(GANADOS1), UNSIGNED INTEGER) AS GANADAS_AG, 
                    CONVERT(SUM(PERDIDAS1), UNSIGNED INTEGER) AS PERDIDAS_AG, 
                    CONVERT(SUM(PENDIENTES1), UNSIGNED INTEGER) AS PENDIENTES_AG, 
                    CONVERT(SUM(GANADOS1)+ SUM(PERDIDAS1)+ SUM(PENDIENTES1), UNSIGNED INTEGER) AS TOTAL_AG, 
                    CONVERT(SUM(GANADOS2), UNSIGNED INTEGER) AS GANADAS_AV, 
                    CONVERT(SUM(PERDIDAS2), UNSIGNED INTEGER) AS PERDIDAS_AV, 
                    CONVERT(SUM(PENDIENTES2), UNSIGNED INTEGER) AS PENDIENTES_AV, 
                    CONVERT(SUM(GANADOS2)+ SUM(PERDIDAS2)+ SUM(PENDIENTES2), UNSIGNED INTEGER) AS TOTAL_AV, 
                    CONVERT(SUM(CBM_GE_AG), UNSIGNED INTEGER) AS CBM_GE_AG, 
                    CONVERT(SUM(CBM_PE_AG), UNSIGNED INTEGER) AS CBM_PE_AG, 
                    CONVERT(SUM(CBM_PDE_AG), UNSIGNED INTEGER) AS CBM_PDE_AG, 
                    CONVERT(SUM(CBM_GE_AV), UNSIGNED INTEGER) AS CBM_GE_AV, 
                    CONVERT(SUM(CBM_PE_AV), UNSIGNED INTEGER) AS CBM_PE_AV, 
                    CONVERT(SUM(CBM_PDE_AV), UNSIGNED INTEGER) AS CBM_PDE_AV, 
                    CONVERT(SUM(LIBRAS_GE_AG), UNSIGNED INTEGER) AS LIBRAS_GE_AG, 
                    CONVERT(SUM(LIBRAS_PE_AG), UNSIGNED INTEGER) AS LIBRAS_PE_AG, 
                    CONVERT(SUM(LIBRAS_PDE_AG), UNSIGNED INTEGER) AS LIBRAS_PDE_AG, 
                    CONVERT(SUM(LIBRAS_GE_AV), UNSIGNED INTEGER) AS LIBRAS_GE_AV, 
                    CONVERT(SUM(LIBRAS_PE_AV), UNSIGNED INTEGER) AS LIBRAS_PE_AV, 
                    CONVERT(SUM(LIBRAS_PDE_AV), UNSIGNED INTEGER) AS LIBRAS_PDE_AV 
                    FROM (
                    SELECT DISTINCT a_origen.razon_social AS 'Agente', 
                    COUNT(a_origen.razon_social) AS 'GANADOS1', 
                    0 AS 'PERDIDAS1', 
                    0 AS 'PENDIENTES1',
                    0 AS 'GANADOS2',
                    0 AS 'PERDIDAS2',
                    0 AS 'PENDIENTES2',
                    SUM(coti.cbm)+SUM(coti.cbm_a)+SUM(coti.cbm_m) AS 'CBM_GE_AG',
                    0 AS 'CBM_PE_AG',
                    0 AS 'CBM_PDE_AG',
                    0 AS 'CBM_GE_AV',
                    0 AS 'CBM_PE_AV',
                    0 AS 'CBM_PDE_AV',
                    SUM(coti.libras)+SUM(coti.libras_a)+SUM(coti.libras_m) AS 'LIBRAS_GE_AG',
                    0 AS 'LIBRAS_PE_AG',
                    0 AS 'LIBRAS_PDE_AG',
                    0 AS 'LIBRAS_GE_AV',
                    0 AS 'LIBRAS_PE_AV',
                    0 AS 'LIBRAS_PDE_AV'
                    FROM av_cotizaciones AS coti
                    JOIN av_agentes AS controlador ON coti.agente_id_c=controlador.agente_id
                    JOIN av_agentes AS a_origen ON coti.agente_id_o=a_origen.agente_id
                    JOIN av_agentes AS a_destino ON coti.agente_id_d=a_destino.agente_id
                    JOIN av_tipooperacion AS operacion ON coti.toper_id=operacion.toper_id
                    JOIN av_productos AS producto ON coti.producto_id=producto.producto_id
                    WHERE controlador.razon_social IN ('Aviomar S.A.S') 
                    AND a_origen.razon_social NOT IN ('Aviomar S.A.S') 
                    AND coti.estado_id IN (3) 
                    AND operacion.toper_id=2 
                    AND MONTH(fecha) LIKE '%$mes%'
                    AND producto.producto LIKE '%$producto%' 
                    GROUP BY a_origen.razon_social UNION ALL
                    SELECT DISTINCT a_origen.razon_social AS 'Agente',
                    0 AS 'GANADOS1', 
                    COUNT(a_origen.razon_social) AS 'PERDIDAS1', 
                    0 AS 'PENDIENTES1',
                    0 AS 'GANADOS2',
                    0 AS 'PERDIDAS2',
                    0 AS 'PENDIENTES2',
                    0 AS 'CBM_GE_AG',
                    SUM(coti.cbm)+SUM(coti.cbm_a)+SUM(coti.cbm_m) AS 'CBM_PE_AG',
                    0 AS 'CBM_PDE_AG',
                    0 AS 'CBM_GE_AV',
                    0 AS 'CBM_PE_AV',
                    0 AS 'CBM_PDE_AV',
                    0 AS 'LIBRAS_GE_AG',
                    SUM(coti.libras)+SUM(coti.libras_a)+SUM(coti.libras_m) AS 'LIBRAS_PE_AG',
                    0 AS 'LIBRAS_PDE_AG',
                    0 AS 'LIBRAS_GE_AV',
                    0 AS 'LIBRAS_PE_AV',
                    0 AS 'LIBRAS_PDE_AV'                        
                    FROM av_cotizaciones AS coti
                    JOIN av_agentes AS controlador ON coti.agente_id_c=controlador.agente_id
                    JOIN av_agentes AS a_origen ON coti.agente_id_o=a_origen.agente_id
                    JOIN av_agentes AS a_destino ON coti.agente_id_d=a_destino.agente_id
                    JOIN av_tipooperacion AS operacion ON coti.toper_id=operacion.toper_id
                    JOIN av_productos AS producto ON coti.producto_id=producto.producto_id
                    WHERE controlador.razon_social IN ('Aviomar S.A.S') 
                    AND a_origen.razon_social NOT IN ('Aviomar S.A.S') 
                    AND coti.estado_id IN (2,8,15,16,18,19) 
                    AND operacion.toper_id=2 
                    AND MONTH(fecha) LIKE '%$mes%'
                    AND producto.producto LIKE '%$producto%' 
                    GROUP BY a_origen.razon_social UNION ALL
                    SELECT DISTINCT a_origen.razon_social AS 'Agente',
                    0 AS 'GANADOS1',
                    0 AS 'PERDIDAS1', 
                    COUNT(a_origen.razon_social) AS 'PENDIENTES1',
                    0 AS 'GANADOS2',
                    0 AS 'PERDIDAS2',
                    0 AS 'PENDIENTES2',
                    0 AS 'CBM_GE_AG',
                    0 AS 'CBM_PE_AG',
                    SUM(coti.cbm)+SUM(coti.cbm_a)+SUM(coti.cbm_m) AS 'CBM_PDE_AG',
                    0 AS 'CBM_GE_AV',
                    0 AS 'CBM_PE_AV',
                    0 AS 'CBM_PDE_AV',
                    0 AS 'LIBRAS_GE_AG',
                    0 AS 'LIBRAS_PE_AG',
                    SUM(coti.libras)+SUM(coti.libras_a)+SUM(coti.libras_m) AS 'LIBRAS_PDE_AG',
                    0 AS 'LIBRAS_GE_AV',
                    0 AS 'LIBRAS_PE_AV',
                    0 AS 'LIBRAS_PDE_AV'
                    FROM av_cotizaciones AS coti
                    JOIN av_agentes AS controlador ON coti.agente_id_c=controlador.agente_id
                    JOIN av_agentes AS a_origen ON coti.agente_id_o=a_origen.agente_id
                    JOIN av_agentes AS a_destino ON coti.agente_id_d=a_destino.agente_id
                    JOIN av_tipooperacion AS operacion ON coti.toper_id=operacion.toper_id
                    JOIN av_productos AS producto ON coti.producto_id=producto.producto_id
                    WHERE controlador.razon_social IN ('Aviomar S.A.S') 
                    AND a_origen.razon_social NOT IN ('Aviomar S.A.S') 
                    AND coti.estado_id IN (4,5,10,11,12) 
                    AND operacion.toper_id=2 
                    AND MONTH(fecha) LIKE '%$mes%'
                    AND producto.producto LIKE '%$producto%' 
                    GROUP BY a_origen.razon_social UNION ALL
                    SELECT DISTINCT controlador.razon_social AS 'Agente', 
                    0 AS 'GANADOS1',
                    0 AS 'PERDIDAS1',
                    0 AS 'PENDIENTES1', 
                    COUNT(a_destino.razon_social) AS 'GANADOS2', 
                    0 AS 'PERDIDAS2', 
                    0 AS 'PENDIENTES2',
                    0 AS 'CBM_GE_AG',
                    0 AS 'CBM_PE_AG',
                    0 AS 'CBM_PDE_AG',
                    SUM(coti.cbm)+SUM(coti.cbm_a)+SUM(coti.cbm_m) AS 'CBM_GE_AV',
                    0 AS 'CBM_PE_AV',
                    0 AS 'CBM_PDE_AV',
                    0 AS 'LIBRAS_GE_AG',
                    0 AS 'LIBRAS_PE_AG',
                    0 AS 'LIBRAS_PDE_AG',
                    SUM(coti.libras)+SUM(coti.libras_a)+SUM(coti.libras_m) AS 'LIBRAS_GE_AV',
                    0 AS 'LIBRAS_PE_AV',
                    0 AS 'LIBRAS_PDE_AV'
                    FROM av_cotizaciones AS coti
                    JOIN av_agentes AS controlador ON coti.agente_id_c=controlador.agente_id
                    JOIN av_agentes AS a_origen ON coti.agente_id_o=a_origen.agente_id
                    JOIN av_agentes AS a_destino ON coti.agente_id_d=a_destino.agente_id
                    JOIN av_tipooperacion AS operacion ON coti.toper_id=operacion.toper_id
                    JOIN av_productos AS producto ON coti.producto_id=producto.producto_id
                    WHERE controlador.razon_social NOT IN ('Aviomar S.A.S') 
                    AND a_destino.razon_social IN ('Aviomar S.A.S') 
                    AND coti.estado_id IN (3) 
                    AND operacion.toper_id=2 
                    AND MONTH(fecha) LIKE '%$mes%' 
                    AND producto.producto LIKE '%$producto%'
                    GROUP BY controlador.razon_social UNION ALL
                    SELECT DISTINCT controlador.razon_social AS 'Agente', 
                    0 AS 'GANADOS1',
                    0 AS 'PERDIDAS1',
                    0 AS 'PENDIENTES1',
                    0 AS 'GANADOS2', 
                    COUNT(a_destino.razon_social) AS 'PERDIDAS2', 
                    0 AS 'PENDIENTES2',
                    0 AS 'CBM_GE_AG',
                    0 AS 'CBM_PE_AG',
                    0 AS 'CBM_PDE_AG',
                    0 AS 'CBM_GE_AV',
                    SUM(coti.cbm)+SUM(coti.cbm_a)+SUM(coti.cbm_m) AS 'CBM_PE_AV',
                    0 AS 'CBM_PDE_AV',
                    0 AS 'LIBRAS_GE_AG',
                    0 AS 'LIBRAS_PE_AG',
                    0 AS 'LIBRAS_PDE_AG',
                    0 AS 'LIBRAS_GE_AV',
                    SUM(coti.libras)+SUM(coti.libras_a)+SUM(coti.libras_m) AS 'LIBRAS_PE_AV',
                    0 AS 'LIBRAS_PDE_AV'
                    FROM av_cotizaciones AS coti
                    JOIN av_agentes AS controlador ON coti.agente_id_c=controlador.agente_id
                    JOIN av_agentes AS a_origen ON coti.agente_id_o=a_origen.agente_id
                    JOIN av_agentes AS a_destino ON coti.agente_id_d=a_destino.agente_id
                    JOIN av_tipooperacion AS operacion ON coti.toper_id=operacion.toper_id
                    JOIN av_productos AS producto ON coti.producto_id=producto.producto_id
                    WHERE controlador.razon_social NOT IN ('Aviomar S.A.S') 
                    AND a_destino.razon_social IN ('Aviomar S.A.S') 
                    AND coti.estado_id IN (2,8,15,16,18,19) 
                    AND operacion.toper_id=2 
                    AND MONTH(fecha) LIKE '%$mes%' 
                    AND producto.producto LIKE '%$producto%'
                    GROUP BY controlador.razon_social UNION ALL
                    SELECT DISTINCT controlador.razon_social AS 'Agente', 
                    0 AS 'GANADOS1',
                    0 AS 'PERDIDAS1',
                    0 AS 'PENDIENTES1',
                    0 AS 'GANADOS2',
                    0 AS 'PERDIDAS2', 
                    COUNT(a_origen.razon_social) AS 'PENDIENTES2',
                    0 AS 'CBM_GE_AG',
                    0 AS 'CBM_PE_AG',
                    0 AS 'CBM_PDE_AG',
                    0 AS 'CBM_GE_AV',
                    0 AS 'CBM_PE_AV',
                    SUM(coti.cbm)+SUM(coti.cbm_a)+SUM(coti.cbm_m) AS 'CBM_PDE_AV',
                    0 AS 'LIBRAS_GE_AG',
                    0 AS 'LIBRAS_PE_AG',
                    0 AS 'LIBRAS_PDE_AG',
                    0 AS 'LIBRAS_GE_AV',
                    0 AS 'LIBRAS_PE_AV',
                    SUM(coti.libras)+SUM(coti.libras_a)+SUM(coti.libras_m) AS 'LIBRAS_PDE_AV'                                                                                   
                    FROM av_cotizaciones AS coti
                    JOIN av_agentes AS controlador ON coti.agente_id_c=controlador.agente_id
                    JOIN av_agentes AS a_origen ON coti.agente_id_o=a_origen.agente_id
                    JOIN av_agentes AS a_destino ON coti.agente_id_d=a_destino.agente_id
                    JOIN av_tipooperacion AS operacion ON coti.toper_id=operacion.toper_id
                    JOIN av_productos AS producto ON coti.producto_id=producto.producto_id
                    WHERE controlador.razon_social NOT IN ('Aviomar S.A.S') 
                    AND a_destino.razon_social IN ('Aviomar S.A.S') 
                    AND coti.estado_id IN (4,5,10,11,12) 
                    AND operacion.toper_id=2 
                    AND MONTH(fecha) LIKE '%$mes%'
                    AND producto.producto LIKE '%$producto%' 
                    GROUP BY controlador.razon_social) AS EXPO
                    GROUP BY Agente
                    ORDER BY Agente");
                break;
            default:
                $rec = DB::select("SELECT Agente AS 'Agente', 
                CONVERT(SUM(GANADOS1), UNSIGNED INTEGER) AS GANADAS_AG, 
                CONVERT(SUM(PERDIDAS1), UNSIGNED INTEGER) AS PERDIDAS_AG, 
                CONVERT(SUM(PENDIENTES1), UNSIGNED INTEGER) AS PENDIENTES_AG, 
                CONVERT(SUM(GANADOS1)+ SUM(PERDIDAS1)+ SUM(PENDIENTES1), UNSIGNED INTEGER) AS TOTAL_AG, 
                CONVERT(SUM(GANADOS2), UNSIGNED INTEGER) AS GANADAS_AV, 
                CONVERT(SUM(PERDIDAS2), UNSIGNED INTEGER) AS PERDIDAS_AV, 
                CONVERT(SUM(PENDIENTES2), UNSIGNED INTEGER) AS PENDIENTES_AV, 
                CONVERT(SUM(GANADOS2)+ SUM(PERDIDAS2)+ SUM(PENDIENTES2), UNSIGNED INTEGER) AS TOTAL_AV, 
                CONVERT(SUM(CBM_GE_AG), UNSIGNED INTEGER) AS CBM_GE_AG, 
                CONVERT(SUM(CBM_PE_AG), UNSIGNED INTEGER) AS CBM_PE_AG, 
                CONVERT(SUM(CBM_PDE_AG), UNSIGNED INTEGER) AS CBM_PDE_AG, 
                CONVERT(SUM(CBM_GE_AV), UNSIGNED INTEGER) AS CBM_GE_AV, 
                CONVERT(SUM(CBM_PE_AV), UNSIGNED INTEGER) AS CBM_PE_AV, 
                CONVERT(SUM(CBM_PDE_AV), UNSIGNED INTEGER) AS CBM_PDE_AV, 
                CONVERT(SUM(LIBRAS_GE_AG), UNSIGNED INTEGER) AS LIBRAS_GE_AG, 
                CONVERT(SUM(LIBRAS_PE_AG), UNSIGNED INTEGER) AS LIBRAS_PE_AG, 
                CONVERT(SUM(LIBRAS_PDE_AG), UNSIGNED INTEGER) AS LIBRAS_PDE_AG, 
                CONVERT(SUM(LIBRAS_GE_AV), UNSIGNED INTEGER) AS LIBRAS_GE_AV, 
                CONVERT(SUM(LIBRAS_PE_AV), UNSIGNED INTEGER) AS LIBRAS_PE_AV, 
                CONVERT(SUM(LIBRAS_PDE_AV), UNSIGNED INTEGER) AS LIBRAS_PDE_AV 
                FROM (
                SELECT DISTINCT a_destino.razon_social AS 'Agente', 
                COUNT(a_destino.razon_social) AS 'GANADOS1', 
                0 AS 'PERDIDAS1', 
                0 AS 'PENDIENTES1',
                0 AS 'GANADOS2',
                0 AS 'PERDIDAS2',
                0 AS 'PENDIENTES2',
                SUM(coti.cbm)+SUM(coti.cbm_a)+SUM(coti.cbm_m) AS 'CBM_GE_AG',
                0 AS 'CBM_PE_AG',
                0 AS 'CBM_PDE_AG',
                0 AS 'CBM_GE_AV',
                0 AS 'CBM_PE_AV',
                0 AS 'CBM_PDE_AV',
                SUM(coti.libras)+SUM(coti.libras_a)+SUM(coti.libras_m) AS 'LIBRAS_GE_AG',
                0 AS 'LIBRAS_PE_AG',
                0 AS 'LIBRAS_PDE_AG',
                0 AS 'LIBRAS_GE_AV',
                0 AS 'LIBRAS_PE_AV',
                0 AS 'LIBRAS_PDE_AV'
                FROM av_cotizaciones AS coti
                JOIN av_agentes AS controlador ON coti.agente_id_c=controlador.agente_id
                JOIN av_agentes AS a_origen ON coti.agente_id_o=a_origen.agente_id
                JOIN av_agentes AS a_destino ON coti.agente_id_d=a_destino.agente_id
                JOIN av_tipooperacion AS operacion ON coti.toper_id=operacion.toper_id
                JOIN av_productos AS producto ON coti.producto_id=producto.producto_id
                WHERE controlador.razon_social IN ('Aviomar S.A.S') 
                AND a_destino.razon_social NOT IN ('Aviomar S.A.S') 
                AND coti.estado_id IN (3) 
                AND operacion.toper_id=1 
                AND MONTH(fecha) LIKE '%$mes%'
                AND producto.producto LIKE '%$producto%' 
                GROUP BY a_destino.razon_social UNION ALL
                SELECT DISTINCT a_destino.razon_social AS 'Agente',
                0 AS 'GANADOS1', 
                COUNT(a_destino.razon_social) AS 'PERDIDAS1', 
                0 AS 'PENDIENTES1',
                0 AS 'GANADOS2',
                0 AS 'PERDIDAS2',
                0 AS 'PENDIENTES2',
                0 AS 'CBM_GE_AG',
                SUM(coti.cbm)+SUM(coti.cbm_a)+SUM(coti.cbm_m) AS 'CBM_PE_AG',
                0 AS 'CBM_PDE_AG',
                0 AS 'CBM_GE_AV',
                0 AS 'CBM_PE_AV',
                0 AS 'CBM_PDE_AV',
                0 AS 'LIBRAS_GE_AG',
                SUM(coti.libras)+SUM(coti.libras_a)+SUM(coti.libras_m) AS 'LIBRAS_PE_AG',
                0 AS 'LIBRAS_PDE_AG',
                0 AS 'LIBRAS_GE_AV',
                0 AS 'LIBRAS_PE_AV',
                0 AS 'LIBRAS_PDE_AV'
                FROM av_cotizaciones AS coti
                JOIN av_agentes AS controlador ON coti.agente_id_c=controlador.agente_id
                JOIN av_agentes AS a_origen ON coti.agente_id_o=a_origen.agente_id
                JOIN av_agentes AS a_destino ON coti.agente_id_d=a_destino.agente_id
                JOIN av_tipooperacion AS operacion ON coti.toper_id=operacion.toper_id
                JOIN av_productos AS producto ON coti.producto_id=producto.producto_id
                WHERE controlador.razon_social IN ('Aviomar S.A.S') 
                AND a_destino.razon_social NOT IN ('Aviomar S.A.S') 
                AND coti.estado_id IN (2,8,15,16,18,19) 
                AND operacion.toper_id=1 
                AND MONTH(fecha) LIKE '%$mes%'
                AND producto.producto LIKE '%$producto%' 
                GROUP BY a_destino.razon_social UNION ALL
                SELECT DISTINCT a_destino.razon_social AS 'Agente',
                0 AS 'GANADOS1',
                0 AS 'PERDIDAS1', 
                COUNT(a_destino.razon_social) AS 'PENDIENTES1',
                0 AS 'GANADOS2',
                0 AS 'PERDIDAS2',
                0 AS 'PENDIENTES2',
                0 AS 'CBM_GE_AG',
                0 AS 'CBM_PE_AG',
                SUM(coti.cbm)+SUM(coti.cbm_a)+SUM(coti.cbm_m) AS 'CBM_PDE_AG',
                0 AS 'CBM_GE_AV',
                0 AS 'CBM_PE_AV',
                0 AS 'CBM_PDE_AV',
                0 AS 'LIBRAS_GE_AG',
                0 AS 'LIBRAS_PE_AG',
                SUM(coti.libras)+SUM(coti.libras_a)+SUM(coti.libras_m) AS 'LIBRAS_PDE_AG',
                0 AS 'LIBRAS_GE_AV',
                0 AS 'LIBRAS_PE_AV',
                0 AS 'LIBRAS_PDE_AV'
                FROM av_cotizaciones AS coti
                JOIN av_agentes AS controlador ON coti.agente_id_c=controlador.agente_id
                JOIN av_agentes AS a_origen ON coti.agente_id_o=a_origen.agente_id
                JOIN av_agentes AS a_destino ON coti.agente_id_d=a_destino.agente_id
                JOIN av_tipooperacion AS operacion ON coti.toper_id=operacion.toper_id
                JOIN av_productos AS producto ON coti.producto_id=producto.producto_id
                WHERE controlador.razon_social IN ('Aviomar S.A.S') 
                AND a_destino.razon_social NOT IN ('Aviomar S.A.S') 
                AND coti.estado_id IN (4,5,10,11,12) 
                AND operacion.toper_id=1 
                AND MONTH(fecha) LIKE '%$mes%'
                AND producto.producto LIKE '%$producto%' 
                GROUP BY a_destino.razon_social UNION ALL
                SELECT DISTINCT controlador.razon_social AS 'Agente', 
                0 AS 'GANADOS1',
                0 AS 'PERDIDAS1',
                0 AS 'PENDIENTES1', 
                COUNT(a_origen.razon_social) AS 'GANADOS2', 
                0 AS 'PERDIDAS2', 
                0 AS 'PENDIENTES2',
                0 AS 'CBM_GE_AG',
                0 AS 'CBM_PE_AG',
                0 AS 'CBM_PDE_AG',
                SUM(coti.cbm)+SUM(coti.cbm_a)+SUM(coti.cbm_m) AS 'CBM_GE_AV',
                0 AS 'CBM_PE_AV',
                0 AS 'CBM_PDE_AV',
                0 AS 'LIBRAS_GE_AG',
                0 AS 'LIBRAS_PE_AG',
                0 AS 'LIBRAS_PDE_AG',
                SUM(coti.libras)+SUM(coti.libras_a)+SUM(coti.libras_m) AS 'LIBRAS_GE_AV',
                0 AS 'LIBRAS_PE_AV',
                0 AS 'LIBRAS_PDE_AV'
                FROM av_cotizaciones AS coti
                JOIN av_agentes AS controlador ON coti.agente_id_c=controlador.agente_id
                JOIN av_agentes AS a_origen ON coti.agente_id_o=a_origen.agente_id
                JOIN av_agentes AS a_destino ON coti.agente_id_d=a_destino.agente_id
                JOIN av_tipooperacion AS operacion ON coti.toper_id=operacion.toper_id
                JOIN av_productos AS producto ON coti.producto_id=producto.producto_id
                WHERE controlador.razon_social NOT IN ('Aviomar S.A.S') 
                AND a_origen.razon_social IN ('Aviomar S.A.S') 
                AND coti.estado_id IN (3) 
                AND operacion.toper_id=1 
                AND MONTH(fecha) LIKE '%$mes%'
                AND producto.producto LIKE '%$producto%' 
                GROUP BY controlador.razon_social UNION ALL
                SELECT DISTINCT controlador.razon_social AS 'Agente', 
                0 AS 'GANADOS1',
                0 AS 'PERDIDAS1',
                0 AS 'PENDIENTES1',
                0 AS 'GANADOS2', 
                COUNT(a_origen.razon_social) AS 'PERDIDAS2', 
                0 AS 'PENDIENTES2',
                0 AS 'CBM_GE_AG',
                0 AS 'CBM_PE_AG',
                0 AS 'CBM_PDE_AG',
                0 AS 'CBM_GE_AV',
                SUM(coti.cbm)+SUM(coti.cbm_a)+SUM(coti.cbm_m) AS 'CBM_PE_AV',
                0 AS 'CBM_PDE_AV',
                0 AS 'LIBRAS_GE_AG',
                0 AS 'LIBRAS_PE_AG',
                0 AS 'LIBRAS_PDE_AG',
                0 AS 'LIBRAS_GE_AV',
                SUM(coti.libras)+SUM(coti.libras_a)+SUM(coti.libras_m) AS 'LIBRAS_PE_AV',
                0 AS 'LIBRAS_PDE_AV'
                FROM av_cotizaciones AS coti
                JOIN av_agentes AS controlador ON coti.agente_id_c=controlador.agente_id
                JOIN av_agentes AS a_origen ON coti.agente_id_o=a_origen.agente_id
                JOIN av_agentes AS a_destino ON coti.agente_id_d=a_destino.agente_id
                JOIN av_tipooperacion AS operacion ON coti.toper_id=operacion.toper_id
                JOIN av_productos AS producto ON coti.producto_id=producto.producto_id
                WHERE controlador.razon_social NOT IN ('Aviomar S.A.S') 
                AND a_origen.razon_social IN ('Aviomar S.A.S') 
                AND coti.estado_id IN (2,8,15,16,18,19) 
                AND operacion.toper_id=1 
                AND MONTH(fecha) LIKE '%$mes%'
                AND producto.producto LIKE '%$producto%' 
                GROUP BY controlador.razon_social UNION ALL
                SELECT DISTINCT controlador.razon_social AS 'Agente', 
                0 AS 'GANADOS1',
                0 AS 'PERDIDAS1',
                0 AS 'PENDIENTES1',
                0 AS 'GANADOS2',
                0 AS 'PERDIDAS2', 
                COUNT(a_origen.razon_social) AS 'PENDIENTES2',
                0 AS 'CBM_GE_AG',
                0 AS 'CBM_PE_AG',
                0 AS 'CBM_PDE_AG',
                0 AS 'CBM_GE_AV',
                0 AS 'CBM_PE_AV',
                SUM(coti.cbm)+SUM(coti.cbm_a)+SUM(coti.cbm_m) AS 'CBM_PDE_AV',
                0 AS 'LIBRAS_GE_AG',
                0 AS 'LIBRAS_PE_AG',
                0 AS 'LIBRAS_PDE_AG',
                0 AS 'LIBRAS_GE_AV',
                0 AS 'LIBRAS_PE_AV',
                SUM(coti.libras)+SUM(coti.libras_a)+SUM(coti.libras_m) AS 'LIBRAS_PDE_AV'
                FROM av_cotizaciones AS coti
                JOIN av_agentes AS controlador ON coti.agente_id_c=controlador.agente_id
                JOIN av_agentes AS a_origen ON coti.agente_id_o=a_origen.agente_id
                JOIN av_agentes AS a_destino ON coti.agente_id_d=a_destino.agente_id
                JOIN av_tipooperacion AS operacion ON coti.toper_id=operacion.toper_id
                JOIN av_productos AS producto ON coti.producto_id=producto.producto_id
                WHERE controlador.razon_social NOT IN ('Aviomar S.A.S') 
                AND a_destino.razon_social IN ('Aviomar S.A.S') 
                AND coti.estado_id IN (4,5,10,11,12) 
                AND operacion.toper_id=1 
                AND MONTH(fecha) LIKE '%$mes%'
                AND producto.producto LIKE '%$producto%' 
                GROUP BY controlador.razon_social
                UNION ALL
                SELECT DISTINCT a_origen.razon_social AS 'Agente', 
                COUNT(a_origen.razon_social) AS 'GANADOS1', 
                0 AS 'PERDIDAS1', 
                0 AS 'PENDIENTES1',
                0 AS 'GANADOS2',
                0 AS 'PERDIDAS2',
                0 AS 'PENDIENTES2',
                SUM(coti.cbm)+SUM(coti.cbm_a)+SUM(coti.cbm_m) AS 'CBM_GE_AG',
                0 AS 'CBM_PE_AG',
                0 AS 'CBM_PDE_AG',
                0 AS 'CBM_GE_AV',
                0 AS 'CBM_PE_AV',
                0 AS 'CBM_PDE_AV',
                SUM(coti.libras)+SUM(coti.libras_a)+SUM(coti.libras_m) AS 'LIBRAS_GE_AG',
                0 AS 'LIBRAS_PE_AG',
                0 AS 'LIBRAS_PDE_AG',
                0 AS 'LIBRAS_GE_AV',
                0 AS 'LIBRAS_PE_AV',
                0 AS 'LIBRAS_PDE_AV'
                FROM av_cotizaciones AS coti
                JOIN av_agentes AS controlador ON coti.agente_id_c=controlador.agente_id
                JOIN av_agentes AS a_origen ON coti.agente_id_o=a_origen.agente_id
                JOIN av_agentes AS a_destino ON coti.agente_id_d=a_destino.agente_id
                JOIN av_tipooperacion AS operacion ON coti.toper_id=operacion.toper_id
                JOIN av_productos AS producto ON coti.producto_id=producto.producto_id
                WHERE controlador.razon_social IN ('Aviomar S.A.S') 
                AND a_origen.razon_social NOT IN ('Aviomar S.A.S') 
                AND coti.estado_id IN (3) 
                AND operacion.toper_id=2 
                AND MONTH(fecha) LIKE '%$mes%'
                AND producto.producto LIKE '%$producto%' 
                GROUP BY a_origen.razon_social UNION ALL
                SELECT DISTINCT a_origen.razon_social AS 'Agente',
                0 AS 'GANADOS1', 
                COUNT(a_origen.razon_social) AS 'PERDIDAS1', 
                0 AS 'PENDIENTES1',
                0 AS 'GANADOS2',
                0 AS 'PERDIDAS2',
                0 AS 'PENDIENTES2',
                0 AS 'CBM_GE_AG',
                SUM(coti.cbm)+SUM(coti.cbm_a)+SUM(coti.cbm_m) AS 'CBM_PE_AG',
                0 AS 'CBM_PDE_AG',
                0 AS 'CBM_GE_AV',
                0 AS 'CBM_PE_AV',
                0 AS 'CBM_PDE_AV',
                0 AS 'LIBRAS_GE_AG',
                SUM(coti.libras)+SUM(coti.libras_a)+SUM(coti.libras_m) AS 'LIBRAS_PE_AG',
                0 AS 'LIBRAS_PDE_AG',
                0 AS 'LIBRAS_GE_AV',
                0 AS 'LIBRAS_PE_AV',
                0 AS 'LIBRAS_PDE_AV'                        
                FROM av_cotizaciones AS coti
                JOIN av_agentes AS controlador ON coti.agente_id_c=controlador.agente_id
                JOIN av_agentes AS a_origen ON coti.agente_id_o=a_origen.agente_id
                JOIN av_agentes AS a_destino ON coti.agente_id_d=a_destino.agente_id
                JOIN av_tipooperacion AS operacion ON coti.toper_id=operacion.toper_id
                JOIN av_productos AS producto ON coti.producto_id=producto.producto_id
                WHERE controlador.razon_social IN ('Aviomar S.A.S') 
                AND a_origen.razon_social NOT IN ('Aviomar S.A.S') 
                AND coti.estado_id IN (2,8,15,16,18,19) 
                AND operacion.toper_id=2 
                AND MONTH(fecha) LIKE '%$mes%'
                AND producto.producto LIKE '%$producto%' 
                GROUP BY a_origen.razon_social UNION ALL
                SELECT DISTINCT a_origen.razon_social AS 'Agente',
                0 AS 'GANADOS1',
                0 AS 'PERDIDAS1', 
                COUNT(a_origen.razon_social) AS 'PENDIENTES1',
                0 AS 'GANADOS2',
                0 AS 'PERDIDAS2',
                0 AS 'PENDIENTES2',
                0 AS 'CBM_GE_AG',
                0 AS 'CBM_PE_AG',
                SUM(coti.cbm)+SUM(coti.cbm_a)+SUM(coti.cbm_m) AS 'CBM_PDE_AG',
                0 AS 'CBM_GE_AV',
                0 AS 'CBM_PE_AV',
                0 AS 'CBM_PDE_AV',
                0 AS 'LIBRAS_GE_AG',
                0 AS 'LIBRAS_PE_AG',
                SUM(coti.libras)+SUM(coti.libras_a)+SUM(coti.libras_m) AS 'LIBRAS_PDE_AG',
                0 AS 'LIBRAS_GE_AV',
                0 AS 'LIBRAS_PE_AV',
                0 AS 'LIBRAS_PDE_AV'
                FROM av_cotizaciones AS coti
                JOIN av_agentes AS controlador ON coti.agente_id_c=controlador.agente_id
                JOIN av_agentes AS a_origen ON coti.agente_id_o=a_origen.agente_id
                JOIN av_agentes AS a_destino ON coti.agente_id_d=a_destino.agente_id
                JOIN av_tipooperacion AS operacion ON coti.toper_id=operacion.toper_id
                JOIN av_productos AS producto ON coti.producto_id=producto.producto_id
                WHERE controlador.razon_social IN ('Aviomar S.A.S') 
                AND a_origen.razon_social NOT IN ('Aviomar S.A.S') 
                AND coti.estado_id IN (4,5,10,11,12) 
                AND operacion.toper_id=2 
                AND MONTH(fecha) LIKE '%$mes%'
                AND producto.producto LIKE '%$producto%' 
                GROUP BY a_origen.razon_social UNION ALL
                SELECT DISTINCT controlador.razon_social AS 'Agente', 
                0 AS 'GANADOS1',
                0 AS 'PERDIDAS1',
                0 AS 'PENDIENTES1', 
                COUNT(a_destino.razon_social) AS 'GANADOS2', 
                0 AS 'PERDIDAS2', 
                0 AS 'PENDIENTES2',
                0 AS 'CBM_GE_AG',
                0 AS 'CBM_PE_AG',
                0 AS 'CBM_PDE_AG',
                SUM(coti.cbm)+SUM(coti.cbm_a)+SUM(coti.cbm_m) AS 'CBM_GE_AV',
                0 AS 'CBM_PE_AV',
                0 AS 'CBM_PDE_AV',
                0 AS 'LIBRAS_GE_AG',
                0 AS 'LIBRAS_PE_AG',
                0 AS 'LIBRAS_PDE_AG',
                SUM(coti.libras)+SUM(coti.libras_a)+SUM(coti.libras_m) AS 'LIBRAS_GE_AV',
                0 AS 'LIBRAS_PE_AV',
                0 AS 'LIBRAS_PDE_AV'
                FROM av_cotizaciones AS coti
                JOIN av_agentes AS controlador ON coti.agente_id_c=controlador.agente_id
                JOIN av_agentes AS a_origen ON coti.agente_id_o=a_origen.agente_id
                JOIN av_agentes AS a_destino ON coti.agente_id_d=a_destino.agente_id
                JOIN av_tipooperacion AS operacion ON coti.toper_id=operacion.toper_id
                JOIN av_productos AS producto ON coti.producto_id=producto.producto_id
                WHERE controlador.razon_social NOT IN ('Aviomar S.A.S') 
                AND a_destino.razon_social IN ('Aviomar S.A.S') 
                AND coti.estado_id IN (3) 
                AND operacion.toper_id=2 
                AND MONTH(fecha) LIKE '%$mes%'
                AND producto.producto LIKE '%$producto%' 
                GROUP BY controlador.razon_social UNION ALL
                SELECT DISTINCT controlador.razon_social AS 'Agente', 
                0 AS 'GANADOS1',
                0 AS 'PERDIDAS1',
                0 AS 'PENDIENTES1',
                0 AS 'GANADOS2', 
                COUNT(a_destino.razon_social) AS 'PERDIDAS2', 
                0 AS 'PENDIENTES2',
                0 AS 'CBM_GE_AG',
                0 AS 'CBM_PE_AG',
                0 AS 'CBM_PDE_AG',
                0 AS 'CBM_GE_AV',
                SUM(coti.cbm)+SUM(coti.cbm_a)+SUM(coti.cbm_m) AS 'CBM_PE_AV',
                0 AS 'CBM_PDE_AV',
                0 AS 'LIBRAS_GE_AG',
                0 AS 'LIBRAS_PE_AG',
                0 AS 'LIBRAS_PDE_AG',
                0 AS 'LIBRAS_GE_AV',
                SUM(coti.libras)+SUM(coti.libras_a)+SUM(coti.libras_m) AS 'LIBRAS_PE_AV',
                0 AS 'LIBRAS_PDE_AV'
                FROM av_cotizaciones AS coti
                JOIN av_agentes AS controlador ON coti.agente_id_c=controlador.agente_id
                JOIN av_agentes AS a_origen ON coti.agente_id_o=a_origen.agente_id
                JOIN av_agentes AS a_destino ON coti.agente_id_d=a_destino.agente_id
                JOIN av_tipooperacion AS operacion ON coti.toper_id=operacion.toper_id
                JOIN av_productos AS producto ON coti.producto_id=producto.producto_id
                WHERE controlador.razon_social NOT IN ('Aviomar S.A.S') 
                AND a_destino.razon_social IN ('Aviomar S.A.S') 
                AND coti.estado_id IN (2,8,15,16,18,19) 
                AND operacion.toper_id=2 
                AND MONTH(fecha) LIKE '%$mes%'
                AND producto.producto LIKE '%$producto%' 
                GROUP BY controlador.razon_social UNION ALL
                SELECT DISTINCT controlador.razon_social AS 'Agente', 
                0 AS 'GANADOS1',
                0 AS 'PERDIDAS1',
                0 AS 'PENDIENTES1',
                0 AS 'GANADOS2',
                0 AS 'PERDIDAS2', 
                COUNT(a_origen.razon_social) AS 'PENDIENTES2',
                0 AS 'CBM_GE_AG',
                0 AS 'CBM_PE_AG',
                0 AS 'CBM_PDE_AG',
                0 AS 'CBM_GE_AV',
                0 AS 'CBM_PE_AV',
                SUM(coti.cbm)+SUM(coti.cbm_a)+SUM(coti.cbm_m) AS 'CBM_PDE_AV',
                0 AS 'LIBRAS_GE_AG',
                0 AS 'LIBRAS_PE_AG',
                0 AS 'LIBRAS_PDE_AG',
                0 AS 'LIBRAS_GE_AV',
                0 AS 'LIBRAS_PE_AV',
                SUM(coti.libras)+SUM(coti.libras_a)+SUM(coti.libras_m) AS 'LIBRAS_PDE_AV'                                                                                   
                FROM av_cotizaciones AS coti
                JOIN av_agentes AS controlador ON coti.agente_id_c=controlador.agente_id
                JOIN av_agentes AS a_origen ON coti.agente_id_o=a_origen.agente_id
                JOIN av_agentes AS a_destino ON coti.agente_id_d=a_destino.agente_id
                JOIN av_tipooperacion AS operacion ON coti.toper_id=operacion.toper_id
                JOIN av_productos AS producto ON coti.producto_id=producto.producto_id
                WHERE controlador.razon_social NOT IN ('Aviomar S.A.S') 
                AND a_destino.razon_social IN ('Aviomar S.A.S') 
                AND coti.estado_id IN (4,5,10,11,12) 
                AND operacion.toper_id=2 
                AND MONTH(fecha) LIKE '%$mes%'
                AND producto.producto LIKE '%$producto%' 
                GROUP BY controlador.razon_social
                ) AS EXPO
                GROUP BY Agente
                ORDER BY Agente");
                break;
        }
        $response = ['data' => $rec];
    } catch (\Exception $exception) {
        return response()->json(['message' => 'Error al traer registros'], 500);
    }
    return response()->json($response);
});


Route::get('/act_est', function (Request $request, $id) {
    $datos = $request->all();
    $cot = Cotizacion::findOrFail($id)->get();
    foreach ($cot as $cot1) {
        if ($cot1->cot_id == $id) {
            //dd($cot1->cot_id . ' ' . $datos['estado_id']);
            Cotizacion::findOrFail($id)->update($datos);
            if ($cot1->consecutivo_mn != null) {
                switch ($datos['estado_id']) {
                    case '3':
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
});
