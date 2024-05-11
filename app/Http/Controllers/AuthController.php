<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Usuario;
use Firebase\JWT\JWT;
use Carbon\Carbon;
use Firebase\JWT\Key;
use UnexpectedValueException;

class AuthController extends Controller
{


    public function login(Request $request)
    {
        $credentials = $request->only(['nomUsuario', 'contraseña']);

        $validator = Validator::make($credentials, [
            'nomUsuario' => 'required|string',
            'contraseña' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erro al validar los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }
        if (!$user = $this->validateUser($credentials)) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }

        return $this->createToken($user);
    }
    public function me(Request $request){
        $token = $request->bearerToken();
        if(!$token){
            return response()->json([
                'message'=>"token no encontrado",
                'status'=>404
            ],404);
        }
        return response()->json($this->decodeToken($token,true));
    }
    public static function decodeToken($token, $getId = false)
    {
        if (!$token) {
            return false;
        }

        try {
            $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));

            if (!is_object($decoded) && !isset($decoded->sub)) {
                throw new UnexpectedValueException('El token decodificado no es un objeto válido');
            }

            return $getId ? $decoded : true;
        } catch (\Throwable $e) {
            return false;
        }
    }
    public function validateUser(array $credentials)
    {
        if ($user = Usuario::where('nomUsuario', $credentials['nomUsuario'])->where('contraseña', hash('sha256', $credentials['contraseña']))->first()) {
            return $user->id;
        } else {
            return false;
        }
    }
    public function createToken($user)
    {
        $user = Usuario::find($user);

        $token = JWT::encode([
            'user' => $user->id,
            'username' => $user->nomUsuario,
            'rol'=> $user->rol()->tipoRol,
            'exp' => Carbon::now()->addMinutes(5)->timestamp
        ], env('JWT_SECRET'), 'HS256');

        return response()->json(compact('token'));
    }
}
