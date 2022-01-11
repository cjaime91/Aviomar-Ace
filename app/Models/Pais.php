<?php

namespace App\models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    use HasFactory;
    protected $table = "av_paises";
    protected $fillable =['pais'];
    protected $guarded = ['cod'];

    public function getPaises()
    {
        return $this->get();
    }
}
