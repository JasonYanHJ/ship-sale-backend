<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // 检查用户是否有任一指定角色
        if (!$user->hasAnyRole($roles)) {
            return response()->json([
                'message' => '没有权限进行此操作',
                'required_roles' => $roles
            ], 403);
        }

        return $next($request);
    }
}
