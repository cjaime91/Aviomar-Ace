<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    protected $table = "av_ciudades";
    protected $fillable =['ciudad','cod_pais'];
    protected $primarykey ='ciudad_id';

    public function getCiudades($cod_pais)
    {
        return $this->where('cod_pais', $cod_pais)->get();
    }
}
