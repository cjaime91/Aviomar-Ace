<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\pages\AgenteController;
use App\Http\Controllers\pages\CotizacionController;
use App\Http\Controllers\pages\LogsController;
use App\Http\Controllers\pages\Notas_Controller;
use App\Http\Controllers\ReciprocidadController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [InicioController::class, 'index']);
Route::get('/admin', [InicioController::class, 'index_admin']);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('Dashboard');
Route::get('/reciprocidad', [ReciprocidadController::class, 'index'])->name('Reciprocidad');
Route::get('/google_chart', [DashboardController::class, 'index'])->name('gcharts');
Route::get('/dashboard/estados_x_mes', [CotizacionController::class, 'estados_x_mes'])->name('estados_x_mes');
/*RUTAS DEL AGENTE*/
Route::get('pages/agentes', [AgenteController::class, 'index'])->name('agentes');
Route::get('pages/agentes2', [AgenteController::class, 'index2'])->name('agentes2');
Route::get('pages/agentes/crear', [AgenteController::class, 'crear'])->name('crear_agente');
Route::post('pages/agentes', [AgenteController::class, 'guardar'])->name('guardar_agente');
Route::get('pages/agentes/{id}/editar', [AgenteController::class, 'editar'])->name('editar_agente');
Route::delete('pages/agentes/{id}', [AgenteController::class, 'eliminar'])->name('eliminar_agente');
Route::put('pages/agentes/{id}', [AgenteController::class, 'actualizar'])->name('actualizar_agente');
Route::get('pages/agentes/getPaises', [AgenteController::class, 'getpais'])->name('getpais');
Route::get('pages/agentes/getCiudades', [AgenteController::class, 'getCiudades'])->name('getCiudades');
/*RUTAS DEL COTIZACION*/
Route::get('pages/cotizaciones_mn', [CotizacionController::class, 'indexmn'])->name('cotizaciones_mn');
Route::get('pages/cotizaciones_expo', [CotizacionController::class, 'indexexpo'])->name('cotizaciones_expo');
Route::get('pages/cotizaciones_impo', [CotizacionController::class, 'indeximpo'])->name('cotizaciones_impo');
Route::get('pages/cotizaciones/crear', [CotizacionController::class, 'crear'])->name('crear_cotizacion');
Route::post('pages/cotizaciones', [CotizacionController::class, 'guardar'])->name('guardar_cotizacion');
Route::get('pages/cotizaciones/{id}/editar', [CotizacionController::class, 'editar'])->name('editar_cotizacion');
Route::get('pages/cotizaciones/{id}/mostrar', [CotizacionController::class, 'mostrar'])->name('mostrar_cotizacion');
Route::put('pages/cotizaciones/{id}', [CotizacionController::class, 'actualizar'])->name('actualizar_cotizacion');
Route::put('pages/cotizaciones/a/{id}', [CotizacionController::class, 'actualizar_est'])->name('actualizar_estado_cot');
//Route::put('pages/cotizaciones/na/{id}', [CotizacionController::class, 'actualizar_est_na'])->name('actualizar_estado_cot_na');
Route::delete('pages/cotizaciones/{id}', [CotizacionController::class, 'eliminar'])->name('eliminar_cotizacion');

//Route::get('pages/cotizaciones/prueba', [CotizacionController::class, 'prueba'])->name('prueba');
/*Route::get('pages/cotizaciones/getCuenta_mn', [CotizacionController::class, 'getCuenta_mn'])->name('getCuenta_mn');
Route::get('pages/cotizaciones/getCuenta_impo', [CotizacionController::class, 'getCuenta_impo'])->name('getCuenta_impo');
Route::get('pages/cotizaciones/getCuenta_expo', [CotizacionController::class, 'getCuenta_expo'])->name('getCuenta_expo');*/

/*RUTAS NOTAS COTIZACION*/
Route::post('pages/nota', [Notas_Controller::class, 'guardar'])->name('guardar_nota');
/*LOGS COTIZACION*/
Route::post('pages/log', [LogsController::class, 'guardar'])->name('guardar_log');
/*RUTAS USUARIO */
Route::get('pages/usuario/getRol_usuario', [UsuarioController::class, 'getRol_usuario'])->name('getRol_usuario');
/*REPORTES*/
Route::get('pages/reports/reporte_menaje', [ReportesController::class, 'index'])->name('reporte_menaje');
Route::get('pages/reports/exportar_reporte/{ct}/{mes}/{anio}', [ReportesController::class, 'exportar_me'])->name('exportar_reporte');
Route::get('pages/reports/exportar_reporte_rec/{agente}/{operacion}/{mes}/{producto}/{anio}', [ReportesController::class, 'exportar_reciprocidad'])->name('exportar_reporte_rec');

Route::get('importExportView', [ReportesController::class, 'importExportView']);
Route::get('export', [ReportesController::class, 'export'])->name('export');
Route::post('import', [ReportesController::class, 'import'])->name('import');

