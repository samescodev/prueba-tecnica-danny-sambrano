<?php

namespace App\Http\Controllers;

use App\Models\Pastel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PastelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pastel = Pastel::all();
        if ($pastel->isEmpty()) {
            $data = ['Message' => 'No hay pasteles', 'status' => 200];
            return response()->json([$data, 200]);
        }

        $data = ['pastel' => $pastel, 'status' => 200];
        return response()->json($data, 200);
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:100',
            'descripcion' => 'required|max:500',
            'preparado_por' => 'required',
            'fecha_creacion' => 'required|date|before:fecha_vencimiento',
            'fecha_vencimiento' => 'required|date|after:fecha_creacion'
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

            $pastel = Pastel::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'preparado_por' => $request->preparado_por,
                'fecha_creacion' => $request->fecha_creacion,
                'fecha_vencimiento' => $request->fecha_vencimiento
            ]);

            $data = [
                'pastel' => $pastel,
                'status' => 201
            ];
            return response()->json($data, 201);
        } catch (QueryException $error) {

            $pastel = NULL;

            if (!$pastel) {
                $data = [
                    'message' => 'Error al crear un pastel',
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
    public function show($id_pastel)
    {
        $pastel = Pastel::with('ingredientes')->find($id_pastel);

        if (!$pastel) {
            $data = ['message' => 'Pastel no encontrado', 'status' => 404];

            return response()->json($data, 404);
        }

        $data = ['pastel' => $pastel, 'status' => 200];
        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_pastel)
    {
        $pastel = Pastel::find($id_pastel);

        if (!$pastel) {
            $data = [
                'message' => 'Pastel no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:100',
            'descripcion' => 'string|max:500',
            'preparado_por' => 'string|max:300',
            'fecha_creacion' => 'date',
            'fecha_vencimiento' => 'date|after:fecha_creacion'
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

            $pastel->fill($request->only(['nombre', 'descripcion', 'preparado_por', 'fecha_creacion', 'fecha_vencimiento']));
            $pastel->save();

            $data = [
                'message' => 'Pastel actualizado',
                'pastel' => $pastel,
                'status' => 200
            ];
            return response()->json($data, 200);
        } catch (QueryException $error) {

            $pastel = NULL;
            if ($error->getCode() == "HY000") {
                $data = [
                    'message' => "Error al actualizar pastel con codigo {$id_pastel}, la fecha de vencimiento debe ser mayor a la fecha de creación",
                    'error' => $error->getCode(),
                    'status' => 400
                ];
                return response()->json($data, 400);
            }
            if (!$pastel) {
                $data = [
                    'message' => "Error al actualizar pastel {$id_pastel}",
                    'error' => $error->getMessage(),
                    'status' => 500
                ];
                return response()->json($data, 500);
            }
        } catch (\Exception $error) {
            // Capturar otros errores inesperados
            return response()->json([
                'message' => "Error inesperado al actualizar pastel {$id_pastel}",
                'error' => $error->getMessage(),
                'status' => 500
            ], 500);
        }
    }




    public function agregarIngredientes(Request $request, $id_pastel)
    {
        $validator = Validator::make($request->all(), [
            'ingredientes' => 'required|array', // Esperamos un array de ingredientes
            'ingredientes.*.id_ingrediente' => 'required|exists:ingrediente,id_ingrediente', // Cada ID debe existir en la tabla ingrediente
            'ingredientes.*.cantidad_ingrediente' => 'required|numeric|min:0', // Validar la cantidad
            'ingredientes.*.unidad_medida' => 'required|string|in:gramos,litros,unidades,piezas,mililitros,tazas', // Validar la unidad de medida
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de datos.',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        };

        $pastel = Pastel::find($id_pastel);

        if (!$pastel) {
            $data = [
                'message' => 'Pastel no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $ingredientesData = [];
        foreach ($request->ingredientes as $ingrediente) {
            $ingredientesData[$ingrediente['id_ingrediente']] = [
                'cantidad_ingrediente' => $ingrediente['cantidad_ingrediente'],
                'unidad_medida' => $ingrediente['unidad_medida'],
            ];
        }

        $pastel->ingredientes()->sync($ingredientesData);

        return response()->json([
            'message' => 'Ingredientes agregados correctamente.',
            'pastel' => $pastel->load('ingredientes'), // Incluye los ingredientes actualizados
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_pastel)
    {
        $pastel = Pastel::find($id_pastel);

        if (!$pastel) {
            $data = ['message' => 'Pastel no encontrado', 'status' => 404];

            return response()->json($data, 404);
        }
        $pastel->delete();

        $data = ['message' => 'Pastel eliminado', 'status' => 200];
        return response()->json($data, 200);
    }
}
