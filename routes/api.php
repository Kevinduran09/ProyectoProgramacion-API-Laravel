<?php
use App\Http\Middleware\VerifyToken;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\ReservacionController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TipoHabitacionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// endopoints de api usuarios0
Route::get('/users',[UsuarioController::class,'index'])->middleware(VerifyToken::class);
Route::get('/users/{id}',[UsuarioController::class,'show']);
Route::post('/users',[UsuarioController::class,'store']);
Route::put('/users/{id}',[UsuarioController::class,'update']);
Route::patch('/users/{id}',[UsuarioController::class, 'partialUpdate']);
Route::delete('/users/{id}',[UsuarioController::class,'destroy']);

// endpoints de la api habitaciones
Route::get('/habitacion', [HabitacionController::class, 'index']);
Route::get('/habitacion/{id}', [HabitacionController::class, 'show']);
Route::post('/habitacion', [HabitacionController::class, 'store']);
Route::put('/habitacion/{id}', [HabitacionController::class, 'update']);
Route::patch('/habitacion/{id}', [HabitacionController::class, 'partialUpdate']);
Route::delete('/habitacion/{id}', [HabitacionController::class, 'destroy']);


// endpoints de la api tipo habitaciones
Route::get('/tipoHabitacion', [TipoHabitacionController::class, 'index']);
Route::get('/tipoHabitacion/{id}', [TipoHabitacionController::class, 'show']);
Route::post('/tipoHabitacion', [TipoHabitacionController::class, 'store']);
Route::put('/tipoHabitacion/{id}', [TipoHabitacionController::class, 'update']);
Route::patch('/tipoHabitacion/{id}', [TipoHabitacionController::class, 'partialUpdate']);
Route::delete('/tipoHabitacion/{id}', [TipoHabitacionController::class, 'destroy']);

// endpoints para el acceso al reservaciones, protegido por un middleware
Route::middleware([VerifyToken::class])->group(function () {
    Route::get('/reservacion', [ReservacionController::class, 'index']);
    Route::get('/reservacion/{id}', [ReservacionController::class, 'show']);
    Route::post('/reservacion', [ReservacionController::class, 'store']);
    Route::put('/reservacion/{id}', [ReservacionController::class, 'update']);
    Route::patch('/reservacion/{id}', [ReservacionController::class, 'partialUpdate']);
    Route::delete('/reservacion/{id}', [ReservacionController::class, 'destroy']);
});


Route::group(['prefix'=> 'auth'], function ($routes) {
    Route::post('/login',[AuthController::class,'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/me', [AuthController::class,'me'])->middleware(VerifyToken::class);    
});

Route::resource('/rol', RolController::class);