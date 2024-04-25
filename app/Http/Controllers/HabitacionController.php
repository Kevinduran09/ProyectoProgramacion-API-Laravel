<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Info(
 *             title="Título que mostraremos en swagger", 
 *             version="1.0",
 *             description="Descripcion"
 * )
 *
 * @OA\Server(url="http://127.0.0.1:8000/")
 */
class HabitacionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/habitacion",
     *     summary="Retorna lista de todas las habitaciones",
     *     tags={"Users"},
     *     @OA\Response(response=200, description="Lista de todos las habitaciones en el sistema"),
     * )
     */
    public function index()
    {
        $habitaciones = Habitacion::with('tipoHabitacion')->get();

        if ($habitaciones->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron registros de habitaciones en el sistema',
                'status' => 404
            ], 200);
        }

        return response()->json($habitaciones, 200);
    }


    /**
     * @OA\Post(
     *     path="/habitacion",
     *     summary="Crear una nueva habitación",
     *     tags={"Habitaciones"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/HabitacionRequest")
     *     ),
     *     @OA\Response(response=201, description="Habitación creada exitosamente"),
     *     @OA\Response(response=400, description="Error al validar los datos")
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'disponibilidad' => 'required',
            'precioNoche' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'tipo_habitacion_id' => 'required|exists:tipoHabitacion,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al validar los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $habitacion = Habitacion::create([
            'disponibilidad' => $request->disponibilidad,
            'precioNoche' => $request->precioNoche,
            'tipo_habitacion_id' => $request->tipo_habitacion_id
        ]);

        $data = ($habitacion) ? ['habitacion' => $habitacion->load('tipoHabitacion'), 'status' => 201] : ['message' => 'Error al crear el registro de habitacion', 'status' => 500];

        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $habitacion = Habitacion::find($id);

        if (!$habitacion) {
            return response()->json([
                'message' => 'Error, No se encontró la habitación que se está buscando',
                'status' => 400
            ], 400);
        }

        return response()->json([
            'message' => "Se encontró la habitación con la id: {$id}",
            'habitacion' => $habitacion->load('tipoHabitacion'),
            'status' => 200
        ], 200);
    }

    /**
     * Partially update the specified resource in storage.
     */
    public function partialUpdate(Request $request, $id)
    {
        $habitacion = Habitacion::find($id);

        if (!$habitacion) {
            return response()->json([
                'message' => 'Error, No se encontró la habitación que se está buscando',
                'status' => 400
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'disponibilidad' => '',
            'precioNoche' => 'numeric|regex:/^\d+(\.\d{1,2})?$/',
            'tipo_habitacion_id' => 'exists:tipoHabitacion,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al validar los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $habitacion->update($request->only(['disponibilidad', 'precioNoche', 'tipo_habitacion_id']));

        return response()->json([
            'message' => 'Se actualizó parcialmente el registro de la habitación',
            'habitacion' => $habitacion->load('tipoHabitacion'),
            'status' => 200
        ], 200);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $habitacion = Habitacion::find($id);

        if (!$habitacion) {
            return response()->json([
                'message' => 'Error, No se encontró la habitación que se está buscando',
                'status' => 400
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'disponibilidad' => 'required',
            'precioNoche' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'tipo_habitacion_id' => 'required|exists:tipoHabitacion,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al validar los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $habitacion->disponibilidad = $request->disponibilidad;
        $habitacion->precioNoche = $request->precioNoche;
        $habitacion->tipo_habitacion_id = $request->tipo_habitacion_id;

        $habitacion->save();

        return response()->json([
            'message' => 'Se actualizó el registro de la habitación',
            'habitacion' => $habitacion->load('tipoHabitacion'),
            'status' => 200
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $habitacion = Habitacion::find($id);

        if (!$habitacion) {
            return response()->json([
                'message' => 'Error, No se encontró la habitación que se está buscando',
                'status' => 400
            ], 400);
        }

        $habitacion->delete();

        return response()->json([
            'message' => "Se eliminó la habitación con la id: $id",
            'status' => 200
        ], 200);
    }
}
