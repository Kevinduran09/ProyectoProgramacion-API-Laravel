<?php

use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\UsuarioController;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// endopoints de api usuarios
Route::get('/users',[UsuarioController::class,'index']);
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