<?php

namespace Kappa;

use GuzzleHttp\Psr7\Response;

class App
{
	private $container;

	private $providers;

	private $config;

	private function retrieveProviders($providers)
	{
		foreach ($providers as $provider) {
			$provider = new $provider($this->container);

			$provider->register();
			$this->providers[] = $provider;
		}
	}

	private function defineContainer()
	{
		$this->container = new \DI\Container();
		$this->retrieveProviders($this->config['providers']);
	}

	public function run()
	{
		$router = $this->container->get('Kappa\Router');
		
		$response = $router->dispatch();
		$this->sendResponse($response);
	}

	public function __construct()
	{
		$this->config = require DIR . '/app/AppConfig.php';
		$this->boot();
	}

	private function boot()
	{
		$this->defineContainer();
	}

	private function formatResponse($response)
	{
		if ($response instanceof Response) {
			return $response;
		}
		$instance = $this->container->get('GuzzleHttp\Psr7\Response');
		$instance = $instance->withHeader('Content-type', 'application/json');
		$instance = $instance->withBody(\GuzzleHttp\Psr7\stream_for(json_encode($response)));
		return $instance;
	}
	private function sendResponse($response)
	{
		$response = $this->formatResponse($response);
		$this->sendHeaders($response->getHeaders());
		echo $response->getBody();
	}

	private function sendHeaders($headers)
	{
		foreach ($headers as $key => $value) {
			header($key . ': ' . $value[0]);
		}
	}
}