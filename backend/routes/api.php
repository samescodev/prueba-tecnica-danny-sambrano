<?php

use App\Http\Controllers\CategoriaIngredienteController;
use App\Http\Controllers\IngredienteController;
use App\Http\Controllers\PastelController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ReporteController;

Route::prefix('reportes')->group(function () {
    Route::get('/pasteles/recientes', [ReportController::class, 'pastelesRecientes']);
    Route::get('/cantidad-pasteles', [ReportController::class, 'cantidadPasteles']);
    Route::get('/cantidad-ingredientes', [ReportController::class, 'cantidadIngredientes']);
    Route::get('/cantidad-categorias', [ReportController::class, 'cantidadCategorias']);
    Route::get('/pasteles-sin-ingredientes', [ReportController::class, 'pastelesSinIngredientes']);
    Route::get('/ingredientes-mas-usados', [ReportController::class, 'ingredientesMasUsados']);
    Route::get('/ingredientes-menos-usados', [ReportController::class, 'ingredientesMenosUsados']);
});


Route::prefix('pastel')->group(function () {
    Route::resource('/', PastelController::class)->parameters(['' => 'id_pastel']);;
    Route::patch('{id}/ingredientes', [PastelController::class, 'agregarIngredientes']);
});
Route::resource('/ingrediente', IngredienteController::class);
Route::resource('/categoria-ingrediente', CategoriaIngredienteController::class);
