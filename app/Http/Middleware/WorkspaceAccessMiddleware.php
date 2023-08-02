<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkspaceAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $workspace): Response
    {
        // $workspaceId = $request->route('workspace_id');
        dd($workspace);
        $user = auth()->user();

        if (!$user->workspaces->contains('id', $workspaceId)) {
            // User does not have access to the requested workspace
            abort(403, 'Unauthorized');
        }
        return $next($request);
    }
}
