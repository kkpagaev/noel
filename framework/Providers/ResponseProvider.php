<?php

namespace Kappa\Providers;

use Kappa\Test;
use Di\get;
use GuzzleHttp\Psr7\Response;

class ResponseProvider extends Provider
{
	public function register()
	{
		
		$this->bind('GuzzleHttp\Psr7\Response', function () {
			
			$request = new Response();

			return $request;
		});
	}
}