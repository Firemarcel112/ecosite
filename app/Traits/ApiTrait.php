<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

trait ApiTrait
{
	public function getEcoUrl($url, $parameters = [])
	{
		if(config('app.debug'))
		{
			Cache::clear();
		}
		return Cache::remember($url, 60, function() use($url, $parameters)
		{
			$url = env('ECO_API_URL') . $url;
			$access = env('ECO_API_TOKEN');

			$get_parameter = [
				'authtoken' => $access,
				'authtokentype' => 'slg',
			];
			$get_parameter += $parameters;
			$response = null;
			try
			{
				$response = Http::get($url, [$get_parameter]);
			} catch(\Exception $e)
			{

			}

			if($response?->getStatusCode() == 200)
			{
				return $this->getReturnArray($response->json());
			}
			else
			{
				return $this->getReturnArray([], false, $response?->getStatusCode() ?? 500, [$response?->toPsrResponse()?->getReasonPhrase() ?? 'Internal Server Error']);
			}
		});
	}

	public function getReturnArray($data, $success = true, $status_code = 200, $message = [])
	{
		return [
			'success' => $success,
			'statusCode' => $status_code,
			'message' => $message,
			'data' => $data,
			'datum' => now()->format('d.m.Y H:i:s'),
		];
	}
}
