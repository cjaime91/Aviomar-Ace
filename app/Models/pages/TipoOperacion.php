<?php

namespace App\Models\pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoOperacion extends Model
{
    use HasFactory;
    protected $table ="av_tipooperacion";
    protected $fillable =['tipooperacion'];
    protected $primaryKey ='toper_id';
}
