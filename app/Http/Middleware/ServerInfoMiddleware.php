<?php

namespace App\Http\Middleware;

use App\Traits\ApiTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class ServerInfoMiddleware
{
	use ApiTrait;
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */
	public function handle(Request $request, Closure $next): Response
	{
		$api_frontpage = $this->getEcoUrl('Info')['data'];

		View::share([
			'server_info' => $api_frontpage
		]);
		return $next($request);
	}
}
