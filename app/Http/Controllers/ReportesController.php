<?php

namespace App\Http\Controllers;

use App\Exports\ReporteMExport;
use App\Exports\ReporteReciprocidad;
use App\Models\pages\Agente;
use App\Models\pages\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (Auth::check()) {
            $ag = Agente::leftjoin("av_ciudades", "av_agentes.ciudad_id", "=", "av_ciudades.ciudad_id")
                ->leftjoin("av_paises", "av_agentes.cod_pais", "=", "av_paises.cod")
                ->orderBy('razon_social')->get();
            $productos = Productos::orderBy('producto')->get();
            $Agentes = DB::select("SELECT razon_social, CONVERT(SUM(Sol), UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap), UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT razon_social, 0 AS Sol, COUNT(*) AS Ap
            FROM av_cotizaciones AS c
            JOIN av_agentes AS Controlador ON c.agente_id_c=Controlador.agente_id
            JOIN av_paises AS p ON Controlador.cod_pais= p.cod
            WHERE c.estado_id=3 AND YEAR(fecha) = '2021' AND NOT pais='Colombia'
            GROUP BY razon_social UNION ALL
            SELECT razon_social, COUNT(*) AS Sol,0 AS Ap
            FROM av_cotizaciones AS c
            JOIN av_agentes AS Controlador ON c.agente_id_c=Controlador.agente_id
            JOIN av_paises AS p ON Controlador.cod_pais= p.cod
            WHERE NOT pais='Colombia' AND YEAR(fecha) = '2021'
            GROUP BY razon_social) rs
            GROUP BY razon_social
            ORDER BY Aprobadas DESC
            LIMIT 20");
            $Paises = DB::select("SELECT pais, CONVERT(SUM(Sol), UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap), UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT pais, 0 AS Sol, COUNT(*) AS Ap
            FROM av_cotizaciones AS c
            JOIN av_paises AS p ON c.cod_pais_or= p.cod
            WHERE estado_id=3 AND YEAR(fecha) = '2021' AND NOT pais='Colombia'
            GROUP BY pais UNION ALL
            SELECT pais, COUNT(*) AS Sol,0 AS Ap
            FROM av_cotizaciones AS c
            JOIN av_paises AS p ON c.cod_pais_or= p.cod
            WHERE NOT pais='Colombia' AND YEAR(fecha) = '2021'
            GROUP BY pais) ps
            GROUP BY pais
            ORDER BY Aprobadas DESC
            LIMIT 15");
            return view('pages.reports.reporte_menaje', compact('Agentes', 'Paises', 'ag', 'productos'));
        } else {
            return view('auth.login');
        }
    }

    public function exportar_me($ct, $mes, $anio)
    {
        $filenameExport = "Reporte Menaje.xlsx";

        return Excel::download(new ReporteMExport([$ct, $mes, $anio]), $filenameExport);
    }

    public function exportar_reciprocidad($agente, $operacion, $mes, $producto, $anio)
    {
        $filenameExport = "Reporte Reciprocidad.xlsx";

        return Excel::download(new ReporteReciprocidad([$agente, $operacion, $mes, $producto, $anio]), $filenameExport);
    }
}
