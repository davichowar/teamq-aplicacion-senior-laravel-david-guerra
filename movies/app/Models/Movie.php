<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'genre', 'description', 'director', 'year', 'image_path'];

    /**
     * @OA\Schema(
     *     schema="Movie",
     *     title="Movie",
     *     description="Movie model",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         description="The movie ID"
     *     ),
     *     @OA\Property(
     *         property="title",
     *         type="string",
     *         description="The title of the movie"
     *     ),
     *     @OA\Property(
     *         property="genre",
     *         type="string",
     *         description="The genre of the movie"
     *     ),
     *     @OA\Property(
     *         property="description",
     *         type="string",
     *         description="The description of the movie"
     *     ),
     *     @OA\Property(
     *         property="director",
     *         type="string",
     *         description="The director of the movie"
     *     ),
     *     @OA\Property(
     *         property="year",
     *         type="integer",
     *         description="The release year of the movie"
     *     ),
     *     @OA\Property(
     *         property="image_path",
     *         type="string",
     *         description="The path to the image associated with the movie"
     *     )
     * )
     *
     * @OA\Schema(
     *     schema="NewMovie",
     *     title="NewMovie",
     *     description="New movie model for creation",
     *     @OA\Property(
     *         property="title",
     *         type="string",
     *         description="The title of the movie"
     *     ),
     *     @OA\Property(
     *         property="genre",
     *         type="string",
     *         description="The genre of the movie"
     *     ),
     *     @OA\Property(
     *         property="description",
     *         type="string",
     *         description="The description of the movie"
     *     ),
     *     @OA\Property(
     *         property="director",
     *         type="string",
     *         description="The director of the movie"
     *     ),
     *     @OA\Property(
     *         property="year",
     *         type="integer",
     *         description="The release year of the movie"
     *     ),
     *     @OA\Property(
     *         property="image_path",
     *         type="string",
     *         description="The path to the image associated with the movie"
     *     )
     * )
     *
     * @OA\Schema(
     *     schema="PartialMovie",
     *     title="PartialMovie",
     *     description="Partial movie model for partial updates",
     *     @OA\Property(
     *         property="title",
     *         type="string",
     *         description="The title of the movie"
     *     ),
     *     @OA\Property(
     *         property="genre",
     *         type="string",
     *         description="The genre of the movie"
     *     ),
     *     @OA\Property(
     *         property="description",
     *         type="string",
     *         description="The description of the movie"
     *     ),
     *     @OA\Property(
     *         property="director",
     *         type="string",
     *         description="The director of the movie"
     *     ),
     *     @OA\Property(
     *         property="year",
     *         type="integer",
     *         description="The release year of the movie"
     *     ),
     *     @OA\Property(
     *         property="image_path",
     *         type="string",
     *         description="The path to the image associated with the movie"
     *     )
     * )
     */
}
