<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithCharts;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Files\LocalTemporaryFile;
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Layout;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;

class ReporteMExport implements WithEvents, WithCharts
{
    public $ct;
    public $mes;
    public $anio;

    public function __construct(array $array)
    {
        $this->ct = $array[0];
        $this->mes = $array[1];
        $this->anio = $array[2];
    }
    public function charts()
    {
        $label = [
            new DataSeriesValues('String', 'Hoja1!$D$7', null, 1),
            new DataSeriesValues('String', 'Hoja1!$E$7', null, 1)
        ];
        $categories = [new DataSeriesValues('String', 'Hoja1!$C$8:$C$27', null, 4)];
        $values = [
            new DataSeriesValues('Number', 'Hoja1!$D$8:$D$27', null, 4),
            new DataSeriesValues('Number', 'Hoja1!$E$8:$E$27', null, 4),
        ];

        $series = new DataSeries(
            DataSeries::TYPE_BARCHART,
            DataSeries::GROUPING_CLUSTERED,
            range(0, \count($values) - 1),
            $label,
            $categories,
            $values,
            DataSeries::DIRECTION_HORIZONTAL,
            false,
            false
        );

        $layout = new Layout();
        $layout->setShowVal(true);

        $plot   = new PlotArea($layout, [$series]);

        $legend = new Legend(Legend::POSITION_BOTTOM);
        $chart  = new Chart(
            null,
            null,
            $legend,
            $plot
        );

        $chart->setTopLeftPosition('G7');
        $chart->setBottomRightPosition('N28');

        return $chart;
    }

    public function registerEvents(): array
    {

        return [
            BeforeWriting::class => function (BeforeWriting $event) {
                $templateFile = new LocalTemporaryFile(storage_path('app/templates/Plantilla Reporte Menaje.xlsx'));   //Ruta para Windows
                //$templateFile = new LocalTemporaryFile(storage_path('app\templates\Plantilla Reporte Menaje.xlsx')); //Ruta para Centos 7
                $event->writer->reopen($templateFile, Excel::XLSX);
                $sheet = $event->writer->getSheetByIndex(0);

                $this->populateSheet($sheet);

                $event->writer->getSheetByIndex(0)->export($event->getConcernable()); // call the export on the first sheet

                return $event->getWriter()->getSheetByIndex(0);
            },
            AfterSheet::class => function (AfterSheet $event) {

                $label2 = [
                    new DataSeriesValues('String', 'Hoja1!$D$32', null, 1, [],),
                    new DataSeriesValues('String', 'Hoja1!$E$32', null, 1),
                ];
                $categories2 = [new DataSeriesValues('String', 'Hoja1!$C$33:$C$47', null, 4)];
                $values2 = [
                    new DataSeriesValues('Number', 'Hoja1!$D$33:$D$47', null, 4),
                    new DataSeriesValues('Number', 'Hoja1!$E$33:$E$47', null, 4),
                ];

                $series2 = new DataSeries(
                    DataSeries::TYPE_BARCHART,
                    DataSeries::GROUPING_CLUSTERED,
                    range(0, \count($values2) - 1),
                    $label2,
                    $categories2,
                    $values2,
                    null,
                    false,
                    false
                );

                $layout2 = new Layout();
                $layout2->setShowVal(true);

                $plot2   = new PlotArea($layout2, [$series2]);

                $legend2 = new Legend(Legend::POSITION_BOTTOM);
                $chart2  = new Chart(
                    null,
                    null,
                    $legend2,
                    $plot2
                );

                $chart2->setTopLeftPosition('G32');
                $chart2->setBottomRightPosition('N48');

                /*TARIFAS APROBADAS*/

                $label3 = [
                    new DataSeriesValues('String', 'Hoja1!$D$54', null, 1),
                    new DataSeriesValues('String', 'Hoja1!$E$54', null, 1)
                ];
                $categories3 = [new DataSeriesValues('String', 'Hoja1!$C$55:$C$59', null, 4)];
                $values3 = [
                    new DataSeriesValues('Number', 'Hoja1!$D$55:$D$59', null, 4),
                    new DataSeriesValues('Number', 'Hoja1!$E$55:$E$59', null, 4),
                ];

                $series3 = new DataSeries(
                    DataSeries::TYPE_BARCHART,
                    DataSeries::GROUPING_CLUSTERED,
                    range(0, \count($values3) - 1),
                    $label3,
                    $categories3,
                    $values3,
                    null,
                    false,
                    false
                );

                $layout3 = new Layout();
                $layout3->setShowVal(true);

                $plot3   = new PlotArea($layout3, [$series3]);

                $legend3 = new Legend(Legend::POSITION_BOTTOM);
                $chart3  = new Chart(
                    null,
                    null,
                    $legend3,
                    $plot3
                );

                $chart3->setTopLeftPosition('G52');
                $chart3->setBottomRightPosition('N62');

                /*TARIFAS APROBADAS*/

                $label4 = [
                    new DataSeriesValues('String', 'Hoja1!$D$71', null, 1),
                    new DataSeriesValues('String', 'Hoja1!$E$71', null, 1)
                ];
                $categories4 = [new DataSeriesValues('String', 'Hoja1!$C$72:$C$79', null, 4)];
                $values4 = [
                    new DataSeriesValues('Number', 'Hoja1!$D$72:$D$79', null, 4),
                    new DataSeriesValues('Number', 'Hoja1!$E$72:$E$79', null, 4),
                ];

                $series4 = new DataSeries(
                    DataSeries::TYPE_BARCHART,
                    DataSeries::GROUPING_CLUSTERED,
                    range(0, \count($values4) - 1),
                    $label4,
                    $categories4,
                    $values4,
                    DataSeries::DIRECTION_HORIZONTAL,
                    false,
                    DataSeries::STYLE_MARKER
                );

                $layout4 = new Layout();
                $layout4->setShowVal(true);

                $plot4   = new PlotArea($layout4, [$series4]);

                $legend4 = new Legend(Legend::POSITION_BOTTOM);
                $chart4  = new Chart(
                    null,
                    null,
                    $legend4,
                    $plot4
                );

                $chart4->setTopLeftPosition('G67');
                $chart4->setBottomRightPosition('N85');

                $event->sheet->getDelegate()->addChart($chart2);
                $event->sheet->getDelegate()->addChart($chart3);
                $event->sheet->getDelegate()->addChart($chart4);
            }
        ];
    }

    private function populateSheet($sheet)
    {

        // Populate the static cells
        $sheet->setCellValue('C7', 'Agente');
        $sheet->setCellValue('D7', 'Solicitadas');
        $sheet->setCellValue('E7', 'Aprobadas');

        // Create the collection based on received ids
        if ($this->ct == '0' && $this->mes == '0') {
            $agentes = DB::select("SELECT razon_social, CONVERT(SUM(Sol), UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap), UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT razon_social, 0 AS Sol, COUNT(*) AS Ap
            FROM av_cotizaciones AS c
            JOIN av_agentes AS Controlador ON c.agente_id_c=Controlador.agente_id
            JOIN av_paises AS p ON Controlador.cod_pais= p.cod
            WHERE c.estado_id=3 AND YEAR(fecha) = '$this->anio' AND NOT pais='Colombia'
            GROUP BY razon_social UNION ALL
            SELECT razon_social, COUNT(*) AS Sol,0 AS Ap
            FROM av_cotizaciones AS c
            JOIN av_agentes AS Controlador ON c.agente_id_c=Controlador.agente_id
            JOIN av_paises AS p ON Controlador.cod_pais= p.cod
            WHERE NOT pais='Colombia' AND YEAR(fecha) = '$this->anio'
            GROUP BY razon_social) rs
            GROUP BY razon_social
            ORDER BY Aprobadas DESC
            LIMIT 20");
        } else if ($this->ct == '0') {
            $agentes = DB::select("SELECT razon_social, CONVERT(SUM(Sol), UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap), UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT razon_social, 0 AS Sol, COUNT(*) AS Ap
            FROM av_cotizaciones AS c
            JOIN av_agentes AS Controlador ON c.agente_id_c=Controlador.agente_id
            JOIN av_paises AS p ON Controlador.cod_pais= p.cod
            WHERE c.estado_id=3 AND YEAR(fecha) = '$this->anio' AND MONTH(fecha) = '$this->mes' AND NOT pais='Colombia'
            GROUP BY razon_social UNION ALL
            SELECT razon_social, COUNT(*) AS Sol,0 AS Ap
            FROM av_cotizaciones AS c
            JOIN av_agentes AS Controlador ON c.agente_id_c=Controlador.agente_id
            JOIN av_paises AS p ON Controlador.cod_pais= p.cod
            WHERE NOT pais='Colombia' AND YEAR(fecha) = '$this->anio' AND MONTH(fecha) = '$this->mes'
            GROUP BY razon_social) rs
            GROUP BY razon_social
            ORDER BY Aprobadas DESC
            LIMIT 20");
        } else if ($this->mes == '0') {
            $agentes = DB::select("SELECT razon_social, CONVERT(SUM(Sol), UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap), UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT razon_social, 0 AS Sol, COUNT(*) AS Ap
            FROM av_cotizaciones AS c
            JOIN av_agentes AS Controlador ON c.agente_id_c=Controlador.agente_id
            JOIN av_paises AS p ON Controlador.cod_pais= p.cod
            WHERE c.estado_id=3 AND YEAR(fecha) = '$this->anio' AND NOT pais='Colombia' AND $this->ct IS NOT NULL
            GROUP BY razon_social UNION ALL
            SELECT razon_social, COUNT(*) AS Sol,0 AS Ap
            FROM av_cotizaciones AS c
            JOIN av_agentes AS Controlador ON c.agente_id_c=Controlador.agente_id
            JOIN av_paises AS p ON Controlador.cod_pais= p.cod
            WHERE NOT pais='Colombia' AND YEAR(fecha) = '$this->anio' AND $this->ct IS NOT NULL
            GROUP BY razon_social) rs
            GROUP BY razon_social
            ORDER BY Aprobadas DESC
            LIMIT 20");
        } else {
            $agentes = DB::select("SELECT razon_social, CONVERT(SUM(Sol), UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap), UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT razon_social, 0 AS Sol, COUNT(*) AS Ap
            FROM av_cotizaciones AS c
            JOIN av_agentes AS Controlador ON c.agente_id_c=Controlador.agente_id
            JOIN av_paises AS p ON Controlador.cod_pais= p.cod
            WHERE c.estado_id=3 AND YEAR(fecha) = '$this->anio' AND MONTH(fecha) = '$this->mes' AND NOT pais='Colombia' AND $this->ct IS NOT NULL
            GROUP BY razon_social UNION ALL
            SELECT razon_social, COUNT(*) AS Sol,0 AS Ap
            FROM av_cotizaciones AS c
            JOIN av_agentes AS Controlador ON c.agente_id_c=Controlador.agente_id
            JOIN av_paises AS p ON Controlador.cod_pais= p.cod
            WHERE NOT pais='Colombia' AND YEAR(fecha) = '$this->anio' AND MONTH(fecha) = '$this->mes' AND $this->ct IS NOT NULL
            GROUP BY razon_social) rs
            GROUP BY razon_social
            ORDER BY Aprobadas DESC
            LIMIT 20");
        }

        // Party starts at row 3
        $iteration = 8;

        foreach ($agentes as $agente) {

            // Create cell definitions
            $C = "C" . ($iteration);
            $D = "D" . ($iteration);
            $E = "E" . ($iteration);

            // Populate dynamic content
            $sheet->setCellValue($C, $agente->razon_social);
            $sheet->setCellValue($D, $agente->Solicitadas);
            $sheet->setCellValue($E, $agente->Aprobadas);

            $iteration++;
        }


        // Populate the static cells
        $sheet->setCellValue('C32', 'Agente');
        $sheet->setCellValue('D32', 'Solicitadas');
        $sheet->setCellValue('E32', 'Aprobadas');

        // Create the collection based on received ids
        if ($this->ct == '0' && $this->mes == '0') {
            $paises = DB::select("SELECT pais, CONVERT(SUM(Sol), UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap), UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT pais, 0 AS Sol, COUNT(*) AS Ap
            FROM av_cotizaciones AS c
            JOIN av_paises AS p ON c.cod_pais_or= p.cod
            WHERE estado_id=3 AND YEAR(fecha) = '$this->anio' AND NOT pais='Colombia'
            GROUP BY pais UNION ALL
            SELECT pais, COUNT(*) AS Sol,0 AS Ap
            FROM av_cotizaciones AS c
            JOIN av_paises AS p ON c.cod_pais_or= p.cod
            WHERE NOT pais='Colombia' AND YEAR(fecha) = '$this->anio'
            GROUP BY pais) ps
            GROUP BY pais
            ORDER BY Aprobadas DESC
            LIMIT 15");
        } else if ($this->ct == '0') {
            $paises = DB::select("SELECT pais, CONVERT(SUM(Sol), UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap), UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT pais, 0 AS Sol, COUNT(*) AS Ap
            FROM av_cotizaciones AS c
            JOIN av_paises AS p ON c.cod_pais_or= p.cod
            WHERE estado_id=3 AND MONTH(fecha) = '$this->mes' AND YEAR(fecha) = '$this->anio' AND NOT pais='Colombia'
            GROUP BY pais UNION ALL
            SELECT pais, COUNT(*) AS Sol,0 AS Ap
            FROM av_cotizaciones AS c
            JOIN av_paises AS p ON c.cod_pais_or= p.cod
            WHERE MONTH(fecha) = '$this->mes' AND NOT pais='Colombia' AND YEAR(fecha) = '$this->anio'
            GROUP BY pais) ps
            GROUP BY pais
            ORDER BY Aprobadas DESC
            LIMIT 15");
        } else if ($this->mes == '0') {
            $paises = DB::select("SELECT pais, CONVERT(SUM(Sol), UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap), UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT pais, 0 AS Sol, COUNT(*) AS Ap
            FROM av_cotizaciones AS c
            JOIN av_paises AS p ON c.cod_pais_or= p.cod
            WHERE estado_id=3 AND YEAR(fecha) = '$this->anio' AND NOT pais='Colombia' AND $this->ct IS NOT NULL
            GROUP BY pais UNION ALL
            SELECT pais, COUNT(*) AS Sol,0 AS Ap
            FROM av_cotizaciones AS c
            JOIN av_paises AS p ON c.cod_pais_or= p.cod
            WHERE NOT pais='Colombia' AND YEAR(fecha) = '$this->anio' AND $this->ct IS NOT NULL
            GROUP BY pais) ps
            GROUP BY pais
            ORDER BY Aprobadas DESC
            LIMIT 15");
        } else {
            $paises = DB::select("SELECT pais, CONVERT(SUM(Sol), UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap), UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT pais, 0 AS Sol, COUNT(*) AS Ap
            FROM av_cotizaciones AS c
            JOIN av_paises AS p ON c.cod_pais_or= p.cod
            WHERE estado_id=3 AND MONTH(fecha) = '$this->mes' AND YEAR(fecha) = '$this->anio' AND NOT pais='Colombia' AND $this->ct IS NOT NULL
            GROUP BY pais UNION ALL
            SELECT pais, COUNT(*) AS Sol,0 AS Ap
            FROM av_cotizaciones AS c
            JOIN av_paises AS p ON c.cod_pais_or= p.cod
            WHERE MONTH(fecha) = '$this->mes' AND NOT pais='Colombia' AND YEAR(fecha) = '$this->anio' AND $this->ct IS NOT NULL
            GROUP BY pais) ps
            GROUP BY pais
            ORDER BY Aprobadas DESC
            LIMIT 15");
        }

        // Party starts at row 3
        $iteration2 = 33;

        foreach ($paises as $pais) {

            // Create cell definitions
            $C = "C" . ($iteration2);
            $D = "D" . ($iteration2);
            $E = "E" . ($iteration2);

            // Populate dynamic content
            $sheet->setCellValue($C, $pais->pais);
            $sheet->setCellValue($D, $pais->Solicitadas);
            $sheet->setCellValue($E, $pais->Aprobadas);

            $iteration2++;
        }

        // Populate the static cells
        $sheet->setCellValue('C54', 'Operación');
        $sheet->setCellValue('D54', 'Solicitadas');
        $sheet->setCellValue('E54', 'Aprobadas');

        // Create the collection based on received ids
        if ($this->ct == '0' && $this->mes == '0') {
            $operacion = DB::select("SELECT tipooperacion, CONVERT(SUM(Sl),UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap),UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT tipooperacion, COUNT(*) AS Sl, 0 AS Ap
            FROM av_cotizaciones
            LEFT JOIN av_tipooperacion AS t ON av_cotizaciones.toper_id = t.toper_id
            WHERE YEAR(fecha) = '$this->anio'
            AND tipooperacion IS NOT NULL
            GROUP BY tipooperacion
            UNION ALL
            SELECT tipooperacion, 0 AS Sl, COUNT(*) AS Ap
            FROM av_cotizaciones
            LEFT JOIN av_tipooperacion AS t ON av_cotizaciones.toper_id = t.toper_id
            WHERE YEAR(fecha) = '$this->anio'
            AND estado_id = 3
            AND tipooperacion IS NOT NULL
            GROUP BY tipooperacion) tipo_operacion
            GROUP BY tipooperacion");
        } else if ($this->ct == '0') {
            $operacion = DB::select("SELECT tipooperacion, CONVERT(SUM(Sl),UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap),UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT tipooperacion, COUNT(*) AS Sl, 0 AS Ap
            FROM av_cotizaciones
            LEFT JOIN av_tipooperacion AS t ON av_cotizaciones.toper_id = t.toper_id
            WHERE YEAR(fecha) = '$this->anio'
            AND MONTH(fecha) = '$this->mes'
            AND tipooperacion IS NOT NULL
            GROUP BY tipooperacion
            UNION ALL
            SELECT tipooperacion, 0 AS Sl, COUNT(*) AS Ap
            FROM av_cotizaciones
            LEFT JOIN av_tipooperacion AS t ON av_cotizaciones.toper_id = t.toper_id
            WHERE YEAR(fecha) = '$this->anio'
            AND MONTH(fecha) = '$this->mes'
            AND estado_id = 3
            AND tipooperacion IS NOT NULL
            GROUP BY tipooperacion) tipo_operacion
            GROUP BY tipooperacion");
        } else if ($this->mes == '0') {
            $operacion = DB::select("SELECT tipooperacion, CONVERT(SUM(Sl),UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap),UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT tipooperacion, COUNT(*) AS Sl, 0 AS Ap
            FROM av_cotizaciones
            LEFT JOIN av_tipooperacion AS t ON av_cotizaciones.toper_id = t.toper_id
            WHERE YEAR(fecha) = '$this->anio'
            AND $this->ct IS NOT NULL
            AND tipooperacion IS NOT NULL
            GROUP BY tipooperacion
            UNION ALL
            SELECT tipooperacion, 0 AS Sl, COUNT(*) AS Ap
            FROM av_cotizaciones
            LEFT JOIN av_tipooperacion AS t ON av_cotizaciones.toper_id = t.toper_id
            WHERE YEAR(fecha) = '$this->anio'
            AND $this->ct IS NOT NULL
            AND tipooperacion IS NOT NULL
            AND estado_id = 3
            GROUP BY tipooperacion) tipo_operacion
            GROUP BY tipooperacion");
        } else {
            $operacion = DB::select("SELECT tipooperacion, CONVERT(SUM(Sl),UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap),UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT tipooperacion, COUNT(*) AS Sl, 0 AS Ap
            FROM av_cotizaciones
            LEFT JOIN av_tipooperacion AS t ON av_cotizaciones.toper_id = t.toper_id
            WHERE YEAR(fecha) = '$this->anio'
            AND MONTH(fecha) = '$this->mes'
            AND $this->ct IS NOT NULL
            AND tipooperacion IS NOT NULL
            GROUP BY tipooperacion
            UNION ALL
            SELECT tipooperacion, 0 AS Sl, COUNT(*) AS Ap
            FROM av_cotizaciones
            LEFT JOIN av_tipooperacion AS t ON av_cotizaciones.toper_id = t.toper_id
            WHERE YEAR(fecha) = '$this->anio'
            AND MONTH(fecha) = '$this->mes'
            AND $this->ct IS NOT NULL
            AND tipooperacion IS NOT NULL
            AND estado_id = 3
            GROUP BY tipooperacion) tipo_operacion
            GROUP BY tipooperacion");
        }

        // Party starts at row 3
        $iteration3 = 53;

        foreach ($operacion as $OP) {

            switch ($OP->tipooperacion) {
                case 'Exportación':
                    $sheet->setCellValue('C55', $OP->tipooperacion);
                    $sheet->setCellValue('D55', $OP->Solicitadas);
                    $sheet->setCellValue('E55', $OP->Aprobadas);
                    break;
                case 'Importación':
                    $sheet->setCellValue('C56', $OP->tipooperacion);
                    $sheet->setCellValue('D56', $OP->Solicitadas);
                    $sheet->setCellValue('E56', $OP->Aprobadas);
                    break;
                case 'Liberación de Guia':
                    $sheet->setCellValue('C57', $OP->tipooperacion);
                    $sheet->setCellValue('D57', $OP->Solicitadas);
                    $sheet->setCellValue('E57', $OP->Aprobadas);
                    break;
                case 'Nacional/Local':
                    $sheet->setCellValue('C58', $OP->tipooperacion);
                    $sheet->setCellValue('D58', $OP->Solicitadas);
                    $sheet->setCellValue('E58', $OP->Aprobadas);
                    break;
                case 'Traspaso':
                    $sheet->setCellValue('C59', $OP->tipooperacion);
                    $sheet->setCellValue('D59', $OP->Solicitadas);
                    $sheet->setCellValue('E59', $OP->Aprobadas);
                    break;
            }
            // Create cell definitions
            /*$C = "C" . ($iteration3);
            $D = "D" . ($iteration3);
            $E = "E" . ($iteration3);*/

            // Populate dynamic content
            /*$sheet->setCellValue($C, $OP->tipooperacion);
            $sheet->setCellValue($D, $OP->Solicitadas);
            $sheet->setCellValue($E, $OP->Aprobadas);*/

            $iteration3++;
        }

        // Populate the static cells
        $sheet->setCellValue('C71', 'Linea de Negocio');
        $sheet->setCellValue('D71', 'Solicitadas');
        $sheet->setCellValue('E71', 'Aprobadas');

        // Create the collection based on received ids
        if ($this->ct == '0' && $this->mes == '0') {
            $operacion = DB::select("SELECT producto, CONVERT(SUM(Sol), UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap), UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT producto, 0 AS Sol, COUNT(*) AS Ap
            FROM av_cotizaciones AS c
            JOIN av_productos AS p ON c.`producto_id`= p.`producto_id`
            WHERE estado_id=3 AND YEAR(fecha) = '$this->anio'
            AND producto IS NOT NULL
            GROUP BY producto UNION ALL
            SELECT producto, COUNT(*) AS Sol,0 AS Ap
            FROM av_cotizaciones AS c
            JOIN av_productos AS p ON c.`producto_id`= p.`producto_id`
            WHERE YEAR(fecha) = '$this->anio'
            AND producto IS NOT NULL
            GROUP BY producto) ps
            GROUP BY producto
            ORDER BY Aprobadas DESC");
        } else if ($this->ct == '0') {
            $operacion = DB::select("SELECT producto, CONVERT(SUM(Sol), UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap), UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT producto, 0 AS Sol, COUNT(*) AS Ap
            FROM av_cotizaciones AS c
            JOIN av_productos AS p ON c.`producto_id`= p.`producto_id`
            WHERE estado_id=3 AND YEAR(fecha) = '$this->anio'
            AND MONTH(fecha) = '$this->mes'
            AND producto IS NOT NULL
            GROUP BY producto UNION ALL
            SELECT producto, COUNT(*) AS Sol,0 AS Ap
            FROM av_cotizaciones AS c
            JOIN av_productos AS p ON c.`producto_id`= p.`producto_id`
            WHERE YEAR(fecha) = '$this->anio'
            AND MONTH(fecha) = '$this->mes'
            AND producto IS NOT NULL
            GROUP BY producto) ps
            GROUP BY producto
            ORDER BY Aprobadas DESC");
        } else if ($this->mes == '0') {
            $operacion = DB::select("SELECT producto, CONVERT(SUM(Sol), UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap), UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT producto, 0 AS Sol, COUNT(*) AS Ap
            FROM av_cotizaciones AS c
            JOIN av_productos AS p ON c.`producto_id`= p.`producto_id`
            WHERE estado_id=3 AND YEAR(fecha) = '$this->anio'
            AND $this->ct IS NOT NULL
            AND producto IS NOT NULL
            GROUP BY producto UNION ALL
            SELECT producto, COUNT(*) AS Sol,0 AS Ap
            FROM av_cotizaciones AS c
            JOIN av_productos AS p ON c.`producto_id`= p.`producto_id`
            WHERE YEAR(fecha) = '$this->anio'
            AND $this->ct IS NOT NULL
            AND producto IS NOT NULL
            GROUP BY producto) ps
            GROUP BY producto
            ORDER BY Aprobadas DESC");
        } else {
            $operacion = DB::select("SELECT producto, CONVERT(SUM(Sol), UNSIGNED INTEGER) AS Solicitadas, CONVERT(SUM(Ap), UNSIGNED INTEGER) AS Aprobadas
            FROM(
            SELECT producto, 0 AS Sol, COUNT(*) AS Ap
            FROM av_cotizaciones AS c
            JOIN av_productos AS p ON c.`producto_id`= p.`producto_id`
            WHERE estado_id=3 AND YEAR(fecha) = '$this->anio'
            AND MONTH(fecha) = '$this->mes'
            AND $this->ct IS NOT NULL
            AND producto IS NOT NULL
            GROUP BY producto UNION ALL
            SELECT producto, COUNT(*) AS Sol,0 AS Ap
            FROM av_cotizaciones AS c
            JOIN av_productos AS p ON c.`producto_id`= p.`producto_id`
            WHERE YEAR(fecha) = '$this->anio'
            AND producto IS NOT NULL
            AND MONTH(fecha) = '$this->mes'
            AND $this->ct IS NOT NULL
            GROUP BY producto) ps
            GROUP BY producto
            ORDER BY Aprobadas DESC");
        }

        // Party starts at row 3
        $iteration4 = 68;
        foreach ($operacion as $OP) {

            switch ($OP->producto) {
                case 'Bodegaje':
                    $sheet->setCellValue('C72', $OP->producto);
                    $sheet->setCellValue('D72', $OP->Solicitadas);
                    $sheet->setCellValue('E72', $OP->Aprobadas);
                    break;
                case 'Carga Diplomatica':
                    $sheet->setCellValue('C73', $OP->producto);
                    $sheet->setCellValue('D73', $OP->Solicitadas);
                    $sheet->setCellValue('E73', $OP->Aprobadas);
                    break;
                case 'Licitaciones':
                    $sheet->setCellValue('C74', $OP->producto);
                    $sheet->setCellValue('D74', $OP->Solicitadas);
                    $sheet->setCellValue('E74', $OP->Aprobadas);
                    break;
                case 'Mascota':
                    $sheet->setCellValue('C75', $OP->producto);
                    $sheet->setCellValue('D75', $OP->Solicitadas);
                    $sheet->setCellValue('E75', $OP->Aprobadas);
                    break;
                case 'Menaje':
                    $sheet->setCellValue('C76', $OP->producto);
                    $sheet->setCellValue('D76', $OP->Solicitadas);
                    $sheet->setCellValue('E76', $OP->Aprobadas);
                    break;
                case 'Nacionalizacion':
                    $sheet->setCellValue('C77', $OP->producto);
                    $sheet->setCellValue('D77', $OP->Solicitadas);
                    $sheet->setCellValue('E77', $OP->Aprobadas);
                    break;
                case 'Obra de Arte':
                    $sheet->setCellValue('C78', $OP->producto);
                    $sheet->setCellValue('D78', $OP->Solicitadas);
                    $sheet->setCellValue('E78', $OP->Aprobadas);
                    break;
                case 'Vehiculo':
                    $sheet->setCellValue('C79', $OP->producto);
                    $sheet->setCellValue('D79', $OP->Solicitadas);
                    $sheet->setCellValue('E79', $OP->Aprobadas);
                    break;
            }
            // Create cell definitions
            /*$C = "C" . ($iteration4);
            $D = "D" . ($iteration4);
            $E = "E" . ($iteration4);*/

            // Populate dynamic content
            /*$sheet->setCellValue($C, $OP->producto);
            $sheet->setCellValue($D, $OP->Solicitadas);
            $sheet->setCellValue($E, $OP->Aprobadas);*/

            $iteration4++;
        }
    }
}
