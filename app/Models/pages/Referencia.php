<?php

namespace App\Models\pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referencia extends Model
{
    use HasFactory;
    protected $table ="av_num_ref";
    protected $fillable =['toper_id','tcliente_id','producto_id','num_ref'];
    protected $guarded =['id'];
}
