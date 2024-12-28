<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PastelIngrediente extends Model
{
    protected $table = 'pastel_ingredientes';
    protected $fillable = ['id_pastel', 'id_ingrediente', 'cantidad_ingrediente', 'unidad_medida'];
}
