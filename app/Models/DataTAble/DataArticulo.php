<?php

namespace App\Models\DataTAble;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataArticulo extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'descripcion',
        'stock',
    ];

}
