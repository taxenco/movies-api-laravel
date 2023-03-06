# Movie - API

This project is a movie API. It is built with Laravel ^8.75 and PHP ^7.3|^8.0.

## Installation
To install the project, follow these steps:

1. Clone the repository to your local machine.
2. Install dependencies with `composer install`.
3. Create a `.env` file by copying the `.env.example` file and updating the settings for your local environment.
4. Generate an application key with `php artisan key:generate`.
5. Migrate the database with `php artisan migrate`.
6. Seed the database with `php artisan db:seed`.
7. Serve the application with `php artisan serve`.

## Usage
To use the project, follow these steps:

1. Visit the application in your browser at [http://localhost:8000](http://localhost:8000).
2. [Other instructions for using the application]

## API Endpoints
The following API endpoints are available in the project:

- `GET /movies` - Retrieve all movies from the database.
- `GET /movies/{id}` - Retrieve a movie by ID.
- `GET /movies/year/{year}` - Retrieve movies released in a specific year.
- `GET /movies/genre/{genre}` - Retrieve movies with a specific genre.
- `POST /movies` - Create a new movie.
- `PUT /movies/{id}` - Update a movie by ID.
- `DELETE /movies/{id}` - Delete a movie by ID.

## Testing

To run the tests for the project, run the following command:

php artisan test


