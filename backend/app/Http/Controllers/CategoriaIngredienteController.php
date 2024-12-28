<?php

namespace App\Http\Controllers;

use App\Models\CategoriaIngrediente;
use Illuminate\Http\Request;

class CategoriaIngredienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $catIngrediente = CategoriaIngrediente::all();
        if ($catIngrediente->isEmpty()) {
            $data = ['Message' => 'No hay categorias que mostrar', 'status' => 200];
            return response()->json([$data, 200]);
        }

        $data = ['CategoriaIngrediente' => $catIngrediente, 'status' => 200];
        return response()->json($data, 200);
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id_categoriaIngrediente)
    {
        $catIngrediente = CategoriaIngrediente::with('ingredientes')->find($id_categoriaIngrediente);

        if (!$catIngrediente) {
            $data = ['message' => 'Pastel no encontrado', 'status' => 404];

            return response()->json($data, 404);
        }

        $data = ['categoriaIngrediente' => $catIngrediente, 'status' => 200];
        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoriaIngrediente $categoriaIngrediente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoriaIngrediente $categoriaIngrediente)
    {
        //
    }
}
