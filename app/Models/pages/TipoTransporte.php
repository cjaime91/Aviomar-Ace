<?php

namespace App\Models\pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoTransporte extends Model
{
    use HasFactory;
    protected $table ="av_tipotransporte";
    protected $fillable =['tipotransporte'];
    protected $primaryKey ='ttrans_id';
}
