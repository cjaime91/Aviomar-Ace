<?php

namespace App\Models\pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;
    protected $table = "av_cotizaciones";
    protected $fillable = [
        'consecutivo_mn','consecutivo_expo','consecutivo_impo', 'usuario_ejecutivo_id' , 'fecha', 'agente_id_c', 'agente_id_o', 'valor_o', 'agente_id_d',
        'valor_d','cliente','empresa', 'facturar_a', 'sucursal_id','toper_id','tcliente_id', 'producto_id','num_ref','ttrans_id','cbm_a', 'libras_a','cbm_m', 'libras_m',
        'cbm','libras', 'ciudad_id_or', 'cod_pais_or', 'ciudad_id_ds','cod_pais_ds','usuario_realiza_id','estado_id'
    ];
    protected $primaryKey = 'cot_id';
}
