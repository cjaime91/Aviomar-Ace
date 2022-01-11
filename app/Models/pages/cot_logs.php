<?php

namespace App\Models\pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cot_logs extends Model
{
    use HasFactory;
    protected $table = "av_cot_logs";
    protected $fillable = ['cot_id', 'fecha_a', 'tipo', 'usuario_id'];
    protected $guarded = ['id'];
}
