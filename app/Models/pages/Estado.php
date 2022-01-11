<?php

namespace App\Models\pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;
    protected $table = "av_estados";
    protected $fillable = ['estado','mod','color'];
    protected $primaryKey ='estado_id';
}
