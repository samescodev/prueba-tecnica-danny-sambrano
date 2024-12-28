<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoriaIngrediente extends Model
{
    protected $table = 'categoria_ingrediente';
    protected $primaryKey = 'id_categoria_ingrediente'; // Nombre de la clave primaria
    protected $fillable =
    [
        'nombre',
        'descripcion'
    ];

    public $timestamps = false;
    public function ingredientes(): HasMany
    {
        return $this->hasMany(Ingrediente::class, 'id_categoria_ingrediente', 'id_categoria_ingrediente');
    }
}
