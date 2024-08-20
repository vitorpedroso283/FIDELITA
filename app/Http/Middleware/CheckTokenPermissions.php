<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Token;

class CheckTokenPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permission  (optional) Required permission
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission = null)
    {
        $tokenValue = $this->extractToken($request);

        if (!$tokenValue) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $token = $this->findToken($tokenValue);

        if (!$token) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if ($this->hasInvalidPermissions($token, $permission)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }

    /**
     * Extract the token from the Authorization header.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function extractToken(Request $request): ?string
    {
        $authHeader = $request->header('Authorization');

        if ($authHeader && preg_match('/^Bearer\s(\S+)$/', $authHeader, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Find the token in the database.
     *
     * @param  string  $tokenValue
     * @return \App\Models\Token|null
     */
    protected function findToken(string $tokenValue): ?Token
    {
        return Token::where('token', $tokenValue)->first();
    }

    /**
     * Check if the token has the required permissions.
     *
     * @param  \App\Models\Token  $token
     * @param  string|null  $permission
     * @return bool
     */
    protected function hasInvalidPermissions(Token $token, ?string $permission): bool
    {
        return $permission && !in_array($permission, $token->permissions);
    }
}
