<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\CourController;
use App\Http\Controllers\DonneesRegroupeesController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\InscrireEtudiantController;
use App\Http\Controllers\PlaningsessionController;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\SessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::apiResource("/cours",CourController::class);
Route::apiResource("/Group_Données",DonneesRegroupeesController::class);
Route::apiResource("/Planning_session",SessionController::class);
Route::post('/planifier-session', [SessionController::class, 'planifierSession']);
Route::post('/importer', [InscrireEtudiantController::class, 'importStudents']);
Route::post('/importer-classe', [ExcelController::class, 'importClasse']);
Route::get('/export', [ExcelController::class, 'export']);
Route::post('/login', [authController::class, 'login']);
Route::post('/logout', [authController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/sessions/{id}/annuler', [SessionController::class, 'annuler']);
Route::post('professeur/login', [ProfesseurController::class, 'login']);
Route::get('/sessions/filter-by-date', [SessionController::class,'filterByDate']);
Route::get('/sessions/filter-by-classe', [SessionController::class,'filterByClasse']);
Route::get('/sessions/filter-by-month', 'SessionController@filterByMonth');
Route::get('/sessions/filter-by-professeur', 'SessionController@filterByProfesseur');


