<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieImageController extends Controller
{
    /**
     * Store an image for a specific movie.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *     path="/api/movies/{id}/image",
     *     tags={"Movies"},
     *     summary="Store an image for a movie",
     *     operationId="storeImage",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the movie to associate the image with",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Image file (JPG, max 2MB)",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"image"},
     *                 @OA\Property(
     *                     property="image",
     *                     type="string",
     *                     format="binary"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Image saved successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Movie not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid.")
     *         )
     *     )
     * )
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg|max:2048', // Validación para imagen JPG y máximo 2MB
        ]);

        $movie = Movie::findOrFail($id);

        $path = $request->file('image')->store('movies_images');

        $movie->image_path = $path;
        $movie->save();

        return response()->json(['message' => 'Imagen de película guardada correctamente'], 200);
    }

    /**
     * Retrieve the image associated with a specific movie.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * @OA\Get(
     *     path="/api/movies/{id}/image",
     *     tags={"Movies"},
     *     summary="Get the image associated with a movie",
     *     operationId="showImage",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the movie",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Image found",
     *         @OA\MediaType(
     *             mediaType="image/jpeg"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Movie or image not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The movie does not have an associated image")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $movie = Movie::findOrFail($id);

        if (!$movie->image_path) {
            return response()->json(['message' => 'La película no tiene una imagen asociada'], 404);
        }

        $imagePath = storage_path('app/' . $movie->image_path);

        if (!file_exists($imagePath)) {
            return response()->json(['message' => 'La imagen de la película no se encontró en el servidor'], 404);
        }

        return response()->file($imagePath);
    }
}
