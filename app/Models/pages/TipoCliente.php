<?php

namespace App\Models\pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCliente extends Model
{
    use HasFactory;
    protected $table ="av_tipocliente";
    protected $fillable =['tipocliente'];
    protected $primaryKey ='tcliente_id';
}
