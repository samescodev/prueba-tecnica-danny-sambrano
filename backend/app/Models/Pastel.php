<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pastel extends Model
{
    protected $table = 'pastel';
    protected $primaryKey = 'id_pastel'; // Nombre de la clave primaria
    protected $fillable =
    [
        'nombre',
        'descripcion',
        'preparado_por',
        'fecha_creacion',
        'fecha_vencimiento',
        'estado'
    ];

    public $timestamps = false;

    public function ingredientes(): BelongsToMany
    {
        return $this->belongsToMany(Ingrediente::class, 'pastel_ingredientes', 'id_pastel', 'id_ingrediente')
            ->withPivot('cantidad_ingrediente', 'unidad_medida');
    }
}
