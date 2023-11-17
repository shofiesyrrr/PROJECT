<?php

use App\Http\Controllers\EmployeesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// menampilkan index
Route::get('/employees', [EmployeesController::class, 'index']);

// store employee data
Route::get('/employees/{id}', [EmployeesController::class, 'show']);

//akses umum tanpa token
Route::get('/employees/search/{name}', [EmployeesController::class, 'search']);
Route::get('/employees/status/active', [EmployeesController::class, 'active']);
Route::get('/employees/status/inactive', [EmployeesController::class, 'inactive']);
Route::get('/employees/status/terminated', [EmployeesController::class, 'terminated']);

// akses khusus dengan token
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/employees', [EmployeesController::class, 'store']);
    Route::put('/employees/{id}', [EmployeesController::class, 'update']);
    Route::delete('/employees/{id}', [EmployeesController::class, 'destroy']);
});

// autentikasi sanctum
Route::post('/register', [AuthController::class, 'register'])->name('register'); // register new user

Route::post('/login', [AuthController::class, 'login'])->name('login'); // login user