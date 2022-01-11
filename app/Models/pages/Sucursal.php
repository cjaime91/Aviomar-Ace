<?php

namespace App\Models\pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;
    protected $table = "av_sucursal";
    protected $fillable =['sucursal'];
    protected $primaryKey ='sucursal_id';

}
