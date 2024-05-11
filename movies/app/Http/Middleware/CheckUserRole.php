<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @OA\Parameter(
     *     name="email",
     *     in="header",
     *     description="Email of the user making the request",
     *     required=true,
     *     @OA\Schema(type="string")
     * )
     * @OA\Response(
     *     response=401,
     *     description="Unauthorized role",
     *     @OA\JsonContent(
     *         @OA\Property(property="error", type="string", example="Unauthorized Role")
     *     )
     * )
     */
    public function handle(Request $request, Closure $next)
    {
        $email = $request->header('email');

        $user = DB::table('users')
            ->where('email', $email)
            ->first();

        if ($user && $user->role === 'admin') {
            return $next($request);
        }

        return response()->json(['error' => 'Unauthorized Role'], 401);
    }
}
