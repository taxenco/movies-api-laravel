<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Register a GET route that matches the "/movies" URI and maps to the "allMovies" method of the "MovieController" class.
Route::get('/movies', [MovieController::class, 'allMovies']);

// Register a GET route that matches the "/movies/{id}" URI and maps to the "moviesById" method of the "MovieController" class.
Route::get('/movies/{id}', [MovieController::class, 'moviesById']);

// Register a GET route that matches the "/movies/year/{year}" URI and maps to the "moviesByYear" method of the "MovieController" class.
Route::get('/movies/year/{year}', [MovieController::class, 'moviesByYear']);

// Register a GET route that matches the "/movies/genre/{genre}" URI and maps to the "moviesByGenre" method of the "MovieController" class.
Route::get('/movies/genre/{genre}', [MovieController::class, 'moviesByGenre']);

// Register a DELETE route that matches the "/movies/{id}" URI and maps to the "moviesDelete" method of the "MovieController" class.
Route::delete('/movies/{id}', [MovieController::class, 'moviesDelete']);

// Register a POST route that matches the "/movies" URI and maps to the "movieSave" method of the "MovieController" class.
Route::post('/movies', [MovieController::class, 'movieSave']);

// Register a PUT route that matches the "/movies/{id}" URI and maps to the "moviesUpdate" method of the "MovieController" class.
Route::put('/movies/{id}', [MovieController::class, 'moviesUpdate']);
