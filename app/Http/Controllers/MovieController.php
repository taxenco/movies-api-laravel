<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    /**
     * Retrieve all movies from the database and return them as a JSON response.
     *
     * @return JsonResponse
     */
    public function allMovies(): JsonResponse
    {

        // Retrieve all the movies from the database
        $movies = Movie::all();

        // Using map() method to iterate over a collection of movies and adding a new key-value pair to each movie object.
        $movies = $movies->map(function ($movie) {

            // Adding new key "Meaning of the id number" to the current $movie object.
            // The value of the new key is obtained by calling the fetchMovieDetails() method with the movie's ID as a parameter.
            $movie['Meaning of the id number'] = $this->fetchMovieDetails($movie->id);

            // Returning the modified $movie object.
            return $movie;
        });

        // Return the movies as a JSON response
        return response()->json($movies);
    }

    /**
     * Retrieve a movie by ID.
     *
     * @param int $id The ID of the movie to retrieve.
     *
     * @return JsonResponse The movie details as a JSON response.
     *
     */
    public function moviesById(int $id) : JsonResponse
    {
        // Find the movie with the given ID
        $movie = Movie::find($id);

        // If the movie is not found, return a 404 error
        if (!$movie) {
            return response()->json(['error' => 'Movie not found'], 404);
        }

        // The value of the new key is obtained by calling the fetchMovieDetails() method with the movie's ID as a parameter.
        $movie['Meaning of the id number'] = $this->fetchMovieDetails($id);

        // Return the movie as a JSON response
        return response()->json($movie);
    }

    /**
     *
     * Retrieve movies released in a specific year and return as JSON.
     *
     * @param int $year The release year of the movies to retrieve.
     *
     * @return JsonResponse The movies released in the given year as a JSON response.
     *
     */
    public function moviesByYear(int $year) : JsonResponse
    {
        // Retrieve movies that match the specified release year
        $movies = Movie::where('release_year', $year)->get();

        // Return the movies as a JSON response
        return response()->json($movies);
    }

    /**
     *
     * Retrieve movies from the database with a specified genre and return as JSON.
     *
     * @param string $genre
     *
     * @return JsonResponse
     *
     */
    public function moviesByGenre(string $genre) : JsonResponse
    {
        // Get movies by genre
        $movies = Movie::where('genres', 'LIKE', '%' . $genre . '%')->get();

        // Return the movies as a JSON response
        return response()->json($movies);
    }

    /**
     * Deletes the movie with the given ID from the database.
     *
     * @param int $id The ID of the movie to delete
     *
     * @return JsonResponse A JSON response indicating whether the delete operation was successful or not
     */
    public function moviesDelete(int $id) : JsonResponse
    {
        try {
            // Find the movie by its ID
            $movie = Movie::findOrFail($id);

            // Delete the movie
            $movie->delete();

            // Return success message
            return response()->json(['message' => 'Movie deleted successfully']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            // Return error message if movie is not found
            return response()->json(['error' => 'Movie not found'], 404);

        } catch (\Exception $e) {

            // Return error message if deletion fails for other reasons
            return response()->json(['error' => 'Could not delete movie'], 500);
        }
    }
    /**
     * Saves a new movie to the database.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function movieSave(Request $request) : JsonResponse
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'genres' => 'required|max:255',
            'release_year' => 'required|integer|min:1900|max:' . (date('Y')+1),
            'description' => 'nullable|max:1000',
        ]);

        try {
            // Create new movie object
            $movie = new Movie;
            $movie->title = $validatedData['title'];
            $movie->genres = $validatedData['genres'];
            $movie->release_year = $validatedData['release_year'];
            $movie->description = $validatedData['description'];

            // Save the movie to the database
            $movie->save();

            // Return success message
            return response()->json(['message' => 'Movie saved successfully']);
        } catch (\Exception $e) {
            // Return error message
            return response()->json(['error' => 'Could not save movie'], 500);
        }
    }

    /**
     * Update a movie by ID.
     *
     * @param Request $request
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function moviesUpdate(Request $request, int $id) : JsonResponse
    {
        try {
            // Update data
            $movie = Movie::findOrFail($id);

            $movie->fill($request->only([
                'title',
                'release_year',
                'genres',
                'description'
            ]));

            $movie->save();

            return response()->json(['message' => 'Movie updated successfully']);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            // Return error message if movie is not found
            return response()->json(['error' => 'Movie not found'], 404);

        } catch (\Exception $e) {

            // Return error message if update fails for other reasons
            return response()->json(['error' => 'Could not update movie'], 500);
        }
    }

    /**
     * Fetches movie details from third-party API.
     *
     * @return int API response.
     */
    private function fetchMovieDetails(int $number): array
    {
        $response = Http::get("http://numbersapi.com/{$number}");

        return [
            'number' => $number,
            'fact' => $response->body(),
        ];
    }
}
