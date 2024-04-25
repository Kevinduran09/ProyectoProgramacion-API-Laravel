<?php

namespace App\Http\Controllers;

use App\Models\Reservacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservaciones = Reservacion::all();

        if($reservaciones->isEmpty()){
            return response()->json([
                'message'=> 'No se encontro registro de ninguna reservacion en el sistema',
                'status' => 400
            ], 400);
        }

        return response()->json([
            'reservaciones'=> $reservaciones,
            'status'=>200
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->only(['fechaIngreso','fechaSalida','estado','precioTotal','usuario_id']),[
            'fechaIngreso' =>'required',
            'fechaSalida' => 'required|after_or_equal:fechaIngreso',
            'estado'=>'required',
            'precioTotal'=> 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'usuario_id'=> 'required|exists:Usuario,id'
        ]);

        if($validator->fails()){
            return response()->json([
                'message'=>'Error al validar los datos',
                'erros'=> $validator->errors(),
                'status'=>400
            ], 400);
        }

        $reservacion = Reservacion::create([
            'fechaIngreso' => $request->fechaIngreso,
            'fechaSalida' => $request->fechaSalida,
            'estado' => $request->estado,
            'precioTotal' => $request->precioTotal,
            'usuario_id'=>$request->usuario_id
        ]);

        try {
            $reservacion->habitaciones()->attach($request->habitaciones);
        } catch (\Throwable $th) {
            $reservacion->delete;
            echo 'se elimino';
        }
        return response()->json([
            'message' => 'Reservación creada exitosamente.',
            'reservacion' => $reservacion->load('usuario')->load('habitaciones'),
            'status' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $reservacion = Reservacion::find($id);

        if(!$reservacion){
            return response()->json([
                'message'=>"No se encontro ninguna reserva con el id: $id"
            ], 200);
        }
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservacion $reservacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservacion $reservacion)
    {
        //
    }
}
