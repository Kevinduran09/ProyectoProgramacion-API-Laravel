<?php
use App\Http\Middleware\verfiryAdminRol;
use App\Http\Middleware\VerifyToken;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\ReservacionController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TipoHabitacionController;
use App\Http\Middleware\verifyIdentity;
use Illuminate\Support\Facades\Route;

Route::post("/users", [UsuarioController::class,'store']);

Route::get('/users', [UsuarioController::class, 'index'])->middleware(verfiryAdminRol::class);

// endopoint para acceso a usuarios, protegida solo para administradores
Route::middleware([VerifyToken::class,verifyIdentity::class])->group(function () {
    Route::get('/users/{id}', [UsuarioController::class, 'show']);
    Route::put('/users/{id}', [UsuarioController::class, 'update']);
    Route::patch('/users/{id}', [UsuarioController::class, 'partialUpdate']);
    Route::delete('/users/{id}', [UsuarioController::class, 'destroy']);
});
// endpoints para el acceso a habitaciones, protegida solo para administradores
Route::middleware([VerifyToken::class, verfiryAdminRol::class])->group(function () {

    //Todas las habitaciones si son publicas para un usuario cualquiera
    Route::get('/habitacion', [HabitacionController::class, 'index'])->withoutMiddleware(verfiryAdminRol::class);
    Route::get('/habitacion/{id}', [HabitacionController::class, 'show']);
    Route::post('/habitacion', [HabitacionController::class, 'store']);
    Route::put('/habitacion/{id}', [HabitacionController::class, 'update']);
    Route::patch('/habitacion/{id}', [HabitacionController::class, 'partialUpdate']);
    Route::delete('/habitacion/{id}', [HabitacionController::class, 'destroy']);
});
// endpoints para el acceso a tipo de habitaciones, protegida solo para administradores
Route::middleware(verfiryAdminRol::class)->group(function () {
    Route::get('/tipoHabitacion', [TipoHabitacionController::class, 'index'])->withoutMiddleware(verfiryAdminRol::class);
    Route::get('/tipoHabitacion/{id}', [TipoHabitacionController::class, 'show']);
    Route::post('/tipoHabitacion', [TipoHabitacionController::class, 'store']);
    Route::put('/tipoHabitacion/{id}', [TipoHabitacionController::class, 'update']);
    Route::patch('/tipoHabitacion/{id}', [TipoHabitacionController::class, 'partialUpdate']);
    Route::delete('/tipoHabitacion/{id}', [TipoHabitacionController::class, 'destroy']);
});

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
    Route::post('/register', [UsuarioController::class, 'store']);
    Route::get('/me', [AuthController::class,'me'])->middleware(VerifyToken::class);    
});

Route::resource('/rol', RolController::class)->middleware(verfiryAdminRol::class);