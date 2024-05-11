<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Rol;
class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rols = Rol::all();
        if($rols->isEmpty()){
            return response()->json([
                'message'=>'No se encontro ningun registro para mostrar',
                'status'=>401
            ],200) ;
        }
        return response()->json($rols,200);    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'tipoRol'=> 'required|string',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>'Error al validar los datos',
                'errors'=>$validator->errors(),
                'status'=>400
            ],400) ;
        }

        $rol = Rol::create($request->all());

        return ($rol) ? response()->json($rol,200) : response()->json(['message'=>'No se pudo crear el registro','status'=> 500],500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
