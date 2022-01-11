<?php

namespace App\Models\pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    use HasFactory;
    protected $table ="av_productos";
    protected $fillable =['productos'];
    protected $primaryKey ='producto_id';
}
