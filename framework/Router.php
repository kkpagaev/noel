<?php

namespace Kappa;

use FastRoute\Dispatcher;
use Di\get;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

final class Router
{
	const HANDLER_DELIMITER = ':';

	private $dispatcher;

	private $request;

	private $response;

	public function __construct(Dispatcher $dispatcher, Request $request, Response $response, \DI\Container $container)
	{
		$this->dispatcher = $dispatcher;
		$this->request = $request;
		$this->response = $response;
		$this->container = $container;
	}

	public function dispatch()
	{
		$httpMethod = $this->request->getMethod();
		$uri = $this->request->getUri();
		$routeInfo = $this->dispatcher->dispatch($httpMethod, $uri->getPath());

	    switch ($routeInfo[0]) {
	        case Dispatcher::NOT_FOUND:
	            return $this->response->withStatus(404);
	            break;
	        case Dispatcher::METHOD_NOT_ALLOWED:
	            return $this->response->withStatus(405);
	            break;
	        case Dispatcher::FOUND: 
	            list($state, $handler, $vars) = $routeInfo;
	            list($class, $method) = explode(static::HANDLER_DELIMITER, $handler, 2);

	            $controller = $this->container->get('App\Controllers\\' . $class);
	            return $controller->{$method}(...array_values($vars));
	            break;
	    }
	}

	private function parseUri()
	{
		if (false !== $pos = strpos($uri, '?')) {
			    $uri = substr($uri, 0, $pos);
		}
		$uri = rawurldecode($uri);
	}
}