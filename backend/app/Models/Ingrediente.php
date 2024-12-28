<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingrediente extends Model
{
    protected $table = 'ingrediente';
    protected $primaryKey = 'id_ingrediente'; // Nombre de la clave primaria
    protected $fillable =
    [
        'nombre',
        'descripcion',
        'fecha_ingreso',
        'fecha_vencimiento',
        'id_categoria_ingrediente'
    ];

    public $timestamps = false;

    public function pastel(): BelongsToMany
    {
        return $this->belongsToMany(Pastel::class, 'pastel_ingredientes', 'id_pastel', 'id_ingrediente')
            ->withPivot('cantidad_ingrediente', 'unidad_medida');;
    }
    public function categoriaIngrediente(): BelongsTo
    {
        return $this->belongsTo(CategoriaIngrediente::class, 'id_categoria_ingrediente', 'id_categoria_ingrediente');
    }
}
