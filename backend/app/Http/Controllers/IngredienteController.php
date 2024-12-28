<?php

namespace App\Http\Controllers;

use App\Models\Ingrediente;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IngredienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ingrediente = Ingrediente::with("categoriaIngrediente")->get();
        if ($ingrediente->isEmpty()) {
            $data = ['Message' => 'No hay ingredientes', 'status' => 200];
            return response()->json([$data, 200]);
        }

        $data = ['ingredientes' => $ingrediente, 'status' => 200];
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:100',
            'descripcion' => 'required|max:500',
            'fecha_ingreso' => 'required|date|before:fecha_vencimiento',
            'fecha_vencimiento' => 'required|date|after:fecha_creacion',
            'id_categoria_ingrediente' => 'required|int'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de datos.',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        try {

            $ingrediente = Ingrediente::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'fecha_ingreso' => $request->fecha_ingreso,
                'fecha_vencimiento' => $request->fecha_vencimiento,
                'id_categoria_ingrediente' => $request->id_categoria_ingrediente
            ]);


            $data = [
                'ingrediente' => $ingrediente,
                'status' => 201
            ];
            return response()->json($data, 201);
        } catch (QueryException $error) {

            #23000
            if ($error->getCode() == 23000) {
                $data = [
                    'message' => 'Error al crear ingrediente. La categoria no existe',
                    'error' => $error->getCode(),
                    'status' => 400
                ];
                return response()->json($data, 400);
            }
            $ingrediente = NULL;
            if (!$ingrediente) {
                $data = [
                    'message' => 'Error al crear ingrediente',
                    'error' => $error->getCode(),
                    'status' => 500
                ];
                return response()->json($data, 500);
            }
        } catch (\Exception $error) {
            // Capturar otros tipos de excepciones
            return response()->json([
                'message' => 'Error inesperado',
                'error' => $error->getMessage(),
                'status' => 500
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id_ingrediente)
    {
        $ingrediente = Ingrediente::with('categoriaIngrediente')->find($id_ingrediente);

        if (!$ingrediente) {
            $data = ['message' => 'Ingrediente no encontrado', 'status' => 404];

            return response()->json($data, 404);
        }

        $data = ['ingrediente' => $ingrediente, 'status' => 200];
        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_ingrediente)
    {
        $ingrediente = Ingrediente::find($id_ingrediente);

        if (!$ingrediente) {
            $data = [
                'message' => 'Ingrediente no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:100',
            'descripcion' => 'string|max:500',
            'fecha_ingreso' => 'date',
            'fecha_vencimiento' => 'date|after:fecha_creacion',
            'id_categoria_ingrediente' => 'int'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de datos.',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        try {

            $ingrediente->fill($request->only(['nombre', 'descripcion', 'fecha_ingreso', 'fecha_vencimiento', 'id_categoria_ingrediente']));
            $ingrediente->save();

            $data = [
                'message' => 'ingrediente con codigo {id_ingrediente} actualizado',
                'ingrediente' => $ingrediente,
                'status' => 200
            ];
            return response()->json($data, 200);
        } catch (QueryException $error) {

            $ingrediente = NULL;
            if ($error->getCode() == 23000) {
                $data = [
                    'message' => 'Error al actualizar el ingrediente con codigo {id_ingrediente}. La categoria no existe',
                    'error' => $error->getCode(),
                    'status' => 400
                ];
                return response()->json($data, 400);
            }
            if ($error->getCode() == "HY000") {
                $data = [
                    'message' => "Error al actualizar pastel con codigo {$id_ingrediente}, la fecha de vencimiento debe ser mayor a la fecha de ingreso",
                    'error' => $error->getCode(),
                    'status' => 400
                ];
                return response()->json($data, 400);
            }
            if (!$ingrediente) {
                $data = [
                    'message' => "Error al actualizar ingrediente {$id_ingrediente}",
                    'status' => 500
                ];
                return response()->json($data, 500);
            }
        } catch (\Exception $error) {
            // Capturar otros errores inesperados
            return response()->json([
                'message' => "Error inesperado al actualizar pastel {$id_ingrediente}",
                'error' => $error->getMessage(),
                'status' => 500
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_ingrediente)
    {
        try {
            $ingrediente = Ingrediente::find($id_ingrediente);

            if (!$ingrediente) {
                $data = ['message' => 'Ingrediente no encontrado', 'status' => 404];
                return response()->json($data, 404);
            }

            $ingrediente->delete();

            $data = ['message' => 'Ingrediente eliminado', 'status' => 200];
            return response()->json($data, 200);
        } catch (QueryException $error) {
            if ($error->getCode() == 23000) {
                $data = ['message' => 'Este ingrediente no se pude eliminar porque hay pasteles que lo usan', 'status' => 400, 'error' => $error->getCode()];
                return response()->json($data, 400);
            }
            $data = ['message' => 'Error al eliminar el ingrediente', 'status' => 500, 'error' => $error->getCode()];
            return response()->json($data, 500);
        } catch (\Exception $e) {
            // Capturar cualquier excepción y devolver un mensaje de error
            $data = ['message' => 'Error al eliminar el ingrediente', 'status' => 500, 'error' => $e->getMessage()];
            return response()->json($data, 500);
        }
    }
}
