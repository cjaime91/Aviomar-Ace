<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Files\LocalTemporaryFile;
use Maatwebsite\Excel\Excel;

class ReporteReciprocidad implements WithEvents
{
    public $agente;
    public $operacion;
    public $mes;
    public $producto;
    public $anio;

    public function __construct(array $array)
    {
        $this->agente = $array[0];
        $this->operacion = $array[1];
        $this->mes = $array[2];
        $this->producto = $array[3];
        $this->anio = $array[4];
    }



    public function registerEvents(): array
    {

        return [
            BeforeWriting::class => function (BeforeWriting $event) {
                //$templateFile = new LocalTemporaryFile(storage_path('app\templates\Plantilla Reporte Reciprocidad.xlsx'));   //Ruta para Windows
                $templateFile = new LocalTemporaryFile(storage_path('app/templates/Plantilla Reporte Reciprocidad.xlsx')); //Ruta para Centos 7
                $event->writer->reopen($templateFile, Excel::XLSX);
                $sheet = $event->writer->getSheetByIndex(0);

                $this->populateSheet($sheet);

                $event->writer->getSheetByIndex(0)->export($event->getConcernable()); // call the export on the first sheet

                return $event->getWriter()->getSheetByIndex(0);
            }
        ];
    }

    private function populateSheet($sheet)
    {

        // Populate the static cells
        if ($this->agente == '0') {
            $ag = "";
        } else {
            $ag = $this->agente;
        }
        switch ($this->operacion) {
            case '1':
                $ope = $this->operacion;
                $sheet->setCellValue('G5', 'Exportación');
                break;
            case '2':
                $ope = $this->operacion;
                $sheet->setCellValue('G5', 'Importación');
                break;
            default:
                $ope = 0;
                $sheet->setCellValue('G5', 'Todos');
                break;
        }
        if ($this->operacion == '0') {
            $ope = 0;
        } else {
            $ope = $this->operacion;
        }
        if ($this->mes == '0') {
            $m = "";
            $sheet->setCellValue('R5', 'Todos');
        } else {
            $m = $this->mes;
            switch ($this->mes) {
                case 1:
                    $sheet->setCellValue('R5', 'Enero');
                    break;
                case 2:
                    $sheet->setCellValue('R5', 'Febrero');
                    break;
                case 3:
                    $sheet->setCellValue('R5', 'Marzo');
                    break;
                case 4:
                    $sheet->setCellValue('R5', 'Abril');
                    break;
                case 5:
                    $sheet->setCellValue('R5', 'Mayo');
                    break;
                case 6:
                    $sheet->setCellValue('R5', 'Junio');
                    break;
                case 7:
                    $sheet->setCellValue('R5', 'Julio');
                    break;
                case 8:
                    $sheet->setCellValue('R5', 'Agosto');
                    break;
                case 9:
                    $sheet->setCellValue('R5', 'Septiembre');
                    break;
                case 10:
                    $sheet->setCellValue('R5', 'Octubre');
                    break;
                case 11:
                    $sheet->setCellValue('R5', 'Noviembre');
                    break;
                case 12:
                    $sheet->setCellValue('R5', 'Diciembre');
                    break;
            }
        }
        if ($this->producto == '0') {
            $pr = "";
            $sheet->setCellValue('M5', 'Todos');
        } else {
            $pr = $this->producto;
            $sheet->setCellValue('M5', $pr);
        }
        //$sheet->setCellValue('C1', $ag);
        //$sheet->setCellValue('G5', $ope);
        //$sheet->setCellValue('M5', $pr);

        // Create the collection based on received ids
        switch ($ope) {
            case '1':
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
                AND MONTH(fecha) LIKE '%$m%' 
                AND YEAR(fecha) LIKE '%$this->anio%' 
                AND producto.producto LIKE '%$pr%'
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
                AND MONTH(fecha) LIKE '%$m%' 
                AND YEAR(fecha) LIKE '%$this->anio%' 
                AND producto.producto LIKE '%$pr%'
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
                AND MONTH(fecha) LIKE '%$m%' 
                AND YEAR(fecha) LIKE '%$this->anio%' 
                AND producto.producto LIKE '%$pr%'
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
                AND MONTH(fecha) LIKE '%$m%' 
                AND YEAR(fecha) LIKE '%$this->anio%' 
                AND producto.producto LIKE '%$pr%'
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
                AND MONTH(fecha) LIKE '%$m%' 
                AND YEAR(fecha) LIKE '%$this->anio%' 
                AND producto.producto LIKE '%$pr%'
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
                AND MONTH(fecha) LIKE '%$m%' 
                AND YEAR(fecha) LIKE '%$this->anio%' 
                AND producto.producto LIKE '%$pr%'
                GROUP BY controlador.razon_social) AS EXPO
                GROUP BY Agente
                ORDER BY Agente");
                break;
            case '2':
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
                AND MONTH(fecha) LIKE '%$m%' 
                AND YEAR(fecha) LIKE '%$this->anio%' 
                AND producto.producto LIKE '%$pr%'
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
                AND MONTH(fecha) LIKE '%$m%' 
                AND YEAR(fecha) LIKE '%$this->anio%' 
                AND producto.producto LIKE '%$pr%'
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
                AND MONTH(fecha) LIKE '%$m%' 
                AND YEAR(fecha) LIKE '%$this->anio%' 
                AND producto.producto LIKE '%$pr%'
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
                AND MONTH(fecha) LIKE '%$m%' 
                AND YEAR(fecha) LIKE '%$this->anio%' 
                AND producto.producto LIKE '%$pr%'
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
                AND MONTH(fecha) LIKE '%$m%' 
                AND YEAR(fecha) LIKE '%$this->anio%' 
                AND producto.producto LIKE '%$pr%'
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
                AND MONTH(fecha) LIKE '%$m%' 
                AND YEAR(fecha) LIKE '%$this->anio%' 
                AND producto.producto LIKE '%$pr%'
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
                AND MONTH(fecha) LIKE '%$m%' 
                AND YEAR(fecha) LIKE '%$this->anio%' 
                AND producto.producto LIKE '%$pr%'
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
                AND MONTH(fecha) LIKE '%$m%' 
                AND YEAR(fecha) LIKE '%$this->anio%' 
                AND producto.producto LIKE '%$pr%'
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
                AND MONTH(fecha) LIKE '%$m%' 
                AND YEAR(fecha) LIKE '%$this->anio%' 
                AND producto.producto LIKE '%$pr%'
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
                AND MONTH(fecha) LIKE '%$m%' 
                AND YEAR(fecha) LIKE '%$this->anio%' 
                AND producto.producto LIKE '%$pr%'
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
                AND MONTH(fecha) LIKE '%$m%' 
                AND YEAR(fecha) LIKE '%$this->anio%' 
                AND producto.producto LIKE '%$pr%'
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
                AND MONTH(fecha) LIKE '%$m%' 
                AND YEAR(fecha) LIKE '%$this->anio%' 
                AND producto.producto LIKE '%$pr%'
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
                AND MONTH(fecha) LIKE '%$m%' 
                AND YEAR(fecha) LIKE '%$this->anio%' 
                AND producto.producto LIKE '%$pr%'
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
                AND MONTH(fecha) LIKE '%$m%' 
                AND YEAR(fecha) LIKE '%$this->anio%' 
                AND producto.producto LIKE '%$pr%'
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
                AND MONTH(fecha) LIKE '%$m%' 
                AND YEAR(fecha) LIKE '%$this->anio%' 
                AND producto.producto LIKE '%$pr%'
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
                AND MONTH(fecha) LIKE '%$m%' 
                AND YEAR(fecha) LIKE '%$this->anio%' 
                AND producto.producto LIKE '%$pr%'
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
                AND MONTH(fecha) LIKE '%$m%' 
                AND YEAR(fecha) LIKE '%$this->anio%' 
                AND producto.producto LIKE '%$pr%'
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
                AND MONTH(fecha) LIKE '%$m%' 
                AND YEAR(fecha) LIKE '%$this->anio%' 
                AND producto.producto LIKE '%$pr%'
                GROUP BY controlador.razon_social
                ) AS EXPO
                GROUP BY Agente
                ORDER BY Agente");
                break;
        }

        // Party starts at row 3
        $iteration = 11;

        foreach ($rec as $r) {

            // Create cell definitions
            $B = "B" . ($iteration);
            $C = "C" . ($iteration);
            $D = "D" . ($iteration);
            $E = "E" . ($iteration);
            $F = "F" . ($iteration);
            $G = "G" . ($iteration);
            $H = "H" . ($iteration);
            $I = "I" . ($iteration);
            $J = "J" . ($iteration);
            $K = "K" . ($iteration);
            $L = "L" . ($iteration);
            $M = "M" . ($iteration);
            $N = "N" . ($iteration);
            $O = "O" . ($iteration);
            $P = "P" . ($iteration);
            $Q = "Q" . ($iteration);
            $R = "R" . ($iteration);
            $S = "S" . ($iteration);
            $T = "T" . ($iteration);

            // Populate dynamic content
            $sheet->setCellValue($B, $r->Agente);
            $sheet->setCellValue($C, $r->GANADAS_AV);
            $sheet->setCellValue($D, $r->CBM_GE_AV);
            $sheet->setCellValue($E, $r->LIBRAS_GE_AV);
            $sheet->setCellValue($F, $r->PERDIDAS_AV);
            $sheet->setCellValue($G, $r->CBM_PE_AV);
            $sheet->setCellValue($H, $r->LIBRAS_PE_AV);
            $sheet->setCellValue($I, $r->PENDIENTES_AV);
            $sheet->setCellValue($J, $r->CBM_PDE_AV);
            $sheet->setCellValue($K, $r->LIBRAS_PDE_AV);
            $sheet->setCellValue($L, $r->GANADAS_AG);
            $sheet->setCellValue($M, $r->CBM_GE_AG);
            $sheet->setCellValue($N, $r->LIBRAS_GE_AG);
            $sheet->setCellValue($O, $r->PERDIDAS_AG);
            $sheet->setCellValue($P, $r->CBM_PE_AG);
            $sheet->setCellValue($Q, $r->LIBRAS_PE_AG);
            $sheet->setCellValue($R, $r->PENDIENTES_AG);
            $sheet->setCellValue($S, $r->CBM_PDE_AG);
            $sheet->setCellValue($T, $r->LIBRAS_PDE_AG);

            $sheet->setCellValue('B8', $iteration - 10);
            $iteration++;
        }
    }
}
