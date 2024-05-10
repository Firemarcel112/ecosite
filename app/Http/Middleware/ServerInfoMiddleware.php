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

		$timeSinceStart = $api_frontpage['TimeSinceStart'] ?? 0;
		$timeLeft = $api_frontpage['TimeLeft'] ?? 0;

		$daysSinceStart = floor($timeSinceStart / (60 * 60 * 24));

		$currentTime = abs($timeSinceStart) % (60 * 60 * 24);
		$currentHours = floor($currentTime / (60 * 60));
		$currentMinutes = floor(($currentTime % (60 * 60)) / 60);
		$currentSeconds = $currentTime % 60;

		$server_time = $this->makeDateString($daysSinceStart, $currentHours, $currentMinutes, $currentSeconds);

		View::share([
			'server_info' => $api_frontpage,
			'server_time' => $server_time,
		]);
		return $next($request);
	}

	private function makeDateString($tage, $stunden, $minuten, $sekunden): string
	{
		return  "Tag " . ($tage) . " , " . sprintf("%02d", $stunden) . ":" . sprintf("%02d", $minuten) . ":" . sprintf("%02d", $sekunden);
	}
}
