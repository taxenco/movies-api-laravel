<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Movie;

class MovieTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test that the movie attributes are mass assignable
     *
     * @return void
     */
    public function testMovieAttributesAreMassAssignable()
    {
        // Arrange
        $movieData = [
            'title' => 'Test Movie',
            'release_year' => 2022,
            'genres' => 'Action, Adventure',
            'description' => 'A test movie for unit testing'
        ];

        // Act
        $movie = new Movie;
        $movie->fill($movieData);

        // Assert
        $this->assertEquals($movieData, $movie->toArray());
    }
    /**
     * Test that the "all movies" endpoint returns a valid JSON response.
     *
     * @return void
     */
    public function testAllMoviesEndpoint()
    {
        // Seed the database with some test movies
        Movie::factory()->count(5)->create();

        // Send a GET request to the "/movies" endpoint
        $response = $this->get('/movies');

        // Assert that the response has a 200 status code and is a valid JSON response
        $response->assertOk();
        $response->assertJsonStructure([
            '*' => [
                'id',
                'title',
                'release_year',
                'genres',
                'description',
                'created_at',
                'updated_at',
                'Meaning of the id number'
            ]
        ]);
    }

    /**
     * Test that the movies by id endpoint returns a valid JSON response.
     *
     * @return void
     */
    public function testMoviesByIdEndpoint()
    {
        // Create a movie in the database
        $movie = Movie::factory()->create();

        // Send a GET request to the /movies/{id} endpoint
        $response = $this->get('/movies/' . $movie->id);

        // Check that the response status code is 200 OK
        $response->assertStatus(200);

        // Check that the response JSON contains the expected data
        $response->assertJson([
            'id' => $movie->id,
            'title' => $movie->title,
            'release_year' => $movie->release_year,
            'genres' => $movie->genres,
            'description' => $movie->description
        ]);
    }

    /**
     * Test that the "movies by year" endpoint returns a valid JSON response.
     *
     * @return void
     */
    public function testMoviesByYearEndpoint()
    {
        // Seed the database with some test movies
        Movie::factory()->count(5)->create([
            'release_year' => 2021,
        ]);

        // Send a GET request to the "/movies/year/{year}" endpoint with the year of the test movies
        $response = $this->get('/movies/year/2021');

        // Assert that the response has a 200 status code and is a valid JSON response
        $response->assertOk();
        $response->assertJsonStructure([
            '*' => [
                'id',
                'title',
                'release_year',
                'genres',
                'description',
                'created_at',
                'updated_at',
            ]
        ]);
    }

    /**
     * Test that the "movies by genre" endpoint returns a valid JSON response.
     *
     * @return void
     */
    public function testMoviesByGenreEndpoint()
    {
        // Create some movies with the genre "action"
        $actionMovies = Movie::factory()->count(3)->create([
            'genres' => 'Action'
        ]);

        // Create some movies with the genre "comedy"
        $comedyMovies = Movie::factory()->count(2)->create([
            'genres' => 'Comedy'
        ]);

        // Send a GET request to the /movies/genre/Action endpoint
        $response = $this->get('/movies/genre/Action');

        // Check that the response status code is 200 OK
        $response->assertStatus(200);

        // Check that the response JSON contains the expected data
        $response->assertJsonCount(3)
            ->assertJson($actionMovies->toArray())
            ->assertJsonMissing($comedyMovies->toArray());
    }

    /**
     * Test that a single movie with the specified ID is deleted from the database and returns a valid JSON response.
     *
     * @return void
     */
    public function testMoviesDeleteEndpoint()
    {
        // Create a movie in the database
        $movie = Movie::factory()->create();

        // Send a DELETE request to the /movies/{id} endpoint
        $response = $this->delete('/movies/' . $movie->id);

        // Check that the response status code is 200 OK
        $response->assertStatus(200);

        // Check that the movie has been deleted from the database
        $this->assertDatabaseMissing('movies', ['id' => $movie->id]);
    }

    /**
     * Test that a movie is saved in the database.
     *
     * @return void
     */
    public function testMovieSaveEndpoint()
    {
        // Define the data to be sent in the request
        $data = [
            'title' => 'Test Movie',
            'release_year' => 2022,
            'genres' => 'Action, Adventure',
            'description' => 'A test movie for unit testing'
        ];

        // Send a POST request to the /movies endpoint with the movie data
        $response = $this->post('/movies', $data);

        // Check that the response status code is 200 OK
        $response->assertStatus(200);

        // Check that the movie has been saved to the database
        $this->assertDatabaseHas('movies', ['title' => $data['title']]);
    }

    /**
     * Test that the movie is updated in the database with new information.
     *
     * @return void
     */
    public function testMoviesUpdateEndpoint()
    {
        // Create a new movie to update
        $movie = Movie::factory()->create();

        // Define the new data to update the movie
        $newData = [
            'title' => 'New Title',
            'release_year' => 2023,
            'genres' => 'Comedy, Drama',
            'description' => 'A new description'
        ];

        // Send a PUT request to the moviesUpdate endpoint with the updated data
        $response = $this->put('/movies/' . $movie->id, $newData);

        // Check that the response status code is 200 OK
        $response->assertStatus(200);

        // Check that the movie has been updated in the database
        $this->assertDatabaseHas('movies', [
            'id' => $movie->id,
            'title' => $newData['title'],
            'release_year' => $newData['release_year'],
            'genres' => $newData['genres'],
            'description' => $newData['description']
        ]);
    }

}
