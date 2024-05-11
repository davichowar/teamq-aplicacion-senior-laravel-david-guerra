<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Login a user and generate an access token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Authentication"},
     *     summary="Login user and generate access token",
     *     operationId="login",
     *     @OA\RequestBody(
     *         required=true,
     *         description="User credentials",
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjJhNGY4NjIxZmViOWJmMzZjYzZmNGIzOTVkNmJhZTM5MTc1YjEyY2M2NjFkOTU1YTgzZjJmYWIyODZlOGU1OWI2NjY4ZTlkNTVlNGI1YmUwIn0.eyJhdWQiOiIxIiwianRpIjoiMmE0Zjg2MjFmZWI5YmYzNmNjNmY0YjM5NWQ2YmFlMzkxNzViMTJjYzY2MWQ5NTVhODNmMmZhYjI4NmU4ZTU5YjY2NjhlOWQ1NWU0YjViZTAiLCJpYXQiOjE2MzY4MDk2MzksIm5iZiI6MTYzNjgwOTYzOSwiZXhwIjoxNjY4MzQ1NjM5LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.i-9vo0ovHto92m1N5aFOzMMR2_BXU9nxGWpz9X3E8zIiH9Ol_1HXTFSrGW5o2j2R-GOj5PnVH-Km0I58M0G1cxIkWVjErVDiS9seR_kIopQox_P5p5Q9_1E9V9UXo_0D6REj3aH3jXC1SE9sX5dMf6tADgB1tiIjw2w_QkY2a_Gp")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('Token Name')->plainTextToken;

            return response()->json(['token' => $token], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
