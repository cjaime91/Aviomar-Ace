<?php

namespace App\Models\pages;


use Illuminate\Database\Eloquent\Model;

class Agente extends Model
{
    protected $table = "av_agentes";
    protected $fillable = ['codigo', 'razon_social', 'email', 'direccion', 'telefono','celular', 'cod_pais','ciudad_id',  'estado_id'];
    protected $primaryKey = 'agente_id';    
    protected $guarded = ['agente_id']; 

    public function getFullNameAttribute()
    {
        return "{$this->razon_social} | {$this->codigo}";
    }
}
