<?php

namespace App\Models\pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notas extends Model
{
    use HasFactory;
    protected $table = "av_notascot";
    protected $fillable = ['cot_id', 'fecha','comentario', 'usuario_com_id'];
    protected $primaryKey = 'nota_id';
}
