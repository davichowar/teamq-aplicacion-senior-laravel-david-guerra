<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Movie;

class MovieController extends Controller
{
    /**
     * Retrieve all movies with optional filtering.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="/api/movies",
     *     tags={"Movies"},
     *     summary="Get all movies with optional filtering",
     *     operationId="showAll",
     *     @OA\Parameter(
     *         name="director",
     *         in="query",
     *         description="Filter movies by director",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="genre",
     *         in="query",
     *         description="Filter movies by genre",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="year_max",
     *         in="query",
     *         description="Filter movies with release year less than or equal to the specified value",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="year_min",
     *         in="query",
     *         description="Filter movies with release year greater than or equal to the specified value",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Movie")
     *         )
     *     )
     * )
     */
    public function showAll(Request $request)
    {
        $query = Movie::query();

        foreach ($request->all() as $key => $value) {
            switch ($key) {
                case 'director':
                    $query->where('director', $value);
                    break;
                case 'genre':
                    $query->where('genre', $value);
                    break;
                case 'year_max':
                    $query->where('year', '<=', $value);
                    break;
                case 'year_min':
                    $query->where('year', '>=', $value);
                    break;
            }
        }

        $movies = $query->paginate(10);

        return response()->json($movies);
    }

    /**
     * Retrieve a specific movie by its ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="/api/movies/{id}",
     *     tags={"Movies"},
     *     summary="Get a movie by ID",
     *     operationId="show",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the movie to retrieve",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Movie")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Movie not found"
     *     )
     * )
     */
    public function show($id)
    {
        $movie = Movie::findOrFail($id);
        return response()->json($movie);
    }

    /**
     * Search movies by title.
     *
     * @param  string  $string
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="/api/movies/search/{string}",
     *     tags={"Movies"},
     *     summary="Search movies by title",
     *     operationId="search",
     *     @OA\Parameter(
     *         name="string",
     *         in="path",
     *         description="Search string for movie titles",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Movie")
     *         )
     *     )
     * )
     */
    public function search($string)
    {
        $movies = Movie::where('title', 'LIKE', "%$string%")->get();
        return response()->json($movies);
    }

    /**
     * Store a newly created movie in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *     path="/api/movies",
     *     tags={"Movies"},
     *     summary="Store a new movie",
     *     operationId="store",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Movie data",
     *         @OA\JsonContent(ref="#/components/schemas/NewMovie")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Movie created successfully"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'description' => 'required|string',
            'director' => 'required|string|max:255',
            'year' => 'required|integer',
        ]);

        $movie = new Movie();
        $movie->title = $validatedData['title'];
        $movie->genre = $validatedData['genre'];
        $movie->description = $validatedData['description'];
        $movie->director = $validatedData['director'];
        $movie->year = $validatedData['year'];
        $movie->save();

        return response()->json(['message' => 'Película creada con éxito'], 201);
    }

    /**
     * Remove the specified movie from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Delete(
     *     path="/api/movies/{id}",
     *     tags={"Movies"},
     *     summary="Delete a movie by ID",
     *     operationId="destroy",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the movie to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Movie deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Movie not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Película no encontrada'], 404);
        }

        $movie->delete();

        return response()->json(['message' => 'Película eliminada con éxito'], 200);
    }

    /**
     * Update specified fields of the movie.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Patch(
     *     path="/api/movies/{id}",
     *     tags={"Movies"},
     *     summary="Update specified fields of a movie",
     *     operationId="updatePartial",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the movie to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Fields to update",
     *         @OA\JsonContent(ref="#/components/schemas/PartialMovie")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Movie updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Movie not found"
     *     )
     * )
     */
    public function updatePartial(Request $request, $id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Película no encontrada'], 404);
        }

        $validatedData = $request->validate([
            'title' => 'sometimes|string|max:255',
            'genre' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'director' => 'sometimes|string|max:255',
            'year' => 'sometimes|integer',
        ]);

        $movie->fill($validatedData);
        $movie->save();

        return response()->json($movie);
    }

    /**
     * Update the specified movie in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Put(
     *     path="/api/movies/{id}",
     *     tags={"Movies"},
     *     summary="Update a movie",
     *     operationId="updateTotal",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the movie to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Updated movie data",
     *         @OA\JsonContent(ref="#/components/schemas/NewMovie")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Movie updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Movie not found"
     *     )
     * )
     */
    public function updateTotal(Request $request, $id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Película no encontrada'], 404);
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'description' => 'required|string',
            'director' => 'required|string|max:255',
            'year' => 'required|integer',
        ]);

        $movie->update($validatedData);

        return response()->json($movie);
    }

}
