<?php

namespace App\Http\Controllers;

use App\Models\CategoriaIngrediente;
use App\Models\Ingrediente;
use App\Models\Pastel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // Reporte 1: Listado de pasteles con ingredientes
    public function cantidadPasteles()
    {
        $pasteles = Pastel::count();
        return response()->json($pasteles);
    }

    public function cantidadIngredientes()
    {
        $ingredientes = Ingrediente::count();
        return response()->json($ingredientes);
    }

    public function cantidadCategorias()
    {
        $categorias = CategoriaIngrediente::count();
        return response()->json($categorias);
    }

    public function pastelesSinIngredientes()
    {
        $pasteles = Pastel::doesntHave('ingredientes')->count();
        return response()->json($pasteles);
    }

    public function ingredientesMasUsados()
    {
        $ingredientesMasUsados = DB::table('pastel_ingredientes')
            ->join('ingrediente', 'pastel_ingredientes.id_ingrediente', '=', 'ingrediente.id_ingrediente')
            ->select('ingrediente.nombre', DB::raw('COUNT(pastel_ingredientes.id_ingrediente) as cantidad'))
            ->groupBy('ingrediente.nombre')
            ->orderBy('cantidad', 'desc')
            ->take(3)
            ->get();
        $ingredientesMenosUsados = DB::table('pastel_ingredientes')
            ->join('ingrediente', 'pastel_ingredientes.id_ingrediente', '=', 'ingrediente.id_ingrediente')
            ->select('ingrediente.nombre', DB::raw('COUNT(pastel_ingredientes.id_ingrediente) as cantidad'))
            ->groupBy('ingrediente.nombre')
            ->orderBy('cantidad', 'asc')
            ->take(3)
            ->get();
        if ($ingredientesMasUsados->isEmpty() && $ingredientesMenosUsados->isEmpty()) {
            return response()->json(['message' => 'No hay ingredientes disponibles', 'status' => 200], 200);
        }


        $data = ['masUsados' => $ingredientesMasUsados, 'menosUsados' => $ingredientesMenosUsados, 'status' => 200];
        return response()->json($data, 200);
    }

    public function ingredientesMenosUsados()
    {
        $ingredientes = "000";
        return response()->json($ingredientes);
    }

    public function pastelesRecientes()
    {
        $pasteles = Pastel::OrderBy('actualizado_en', 'desc')->take(4)->get();
        return response()->json($pasteles);
    }
    public function ingredientesRecientes()
    {
        $ingredientes = Ingrediente::OrderBy('actualizado_en', 'desc')->take(4)->get();
        return response()->json($ingredientes);
    }
}
