<?php

namespace Kappa\Providers;

use Kappa\Test;
use Di\get;
use GuzzleHttp\Psr7\Request;

class RequestProvider extends Provider
{
	public function register()
	{
		$this->bind('GuzzleHttp\Psr7\Request', function () {
			
			$request = new Request($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], getallheaders(), file_get_contents('php://input'));

			return $request;
		});
	}
}