<?php

namespace App\Controllers;

/**
 * 
 */
class Controller
{
	private $container;

	protected $request;

	protected $response;
	
	public function __construct(\GuzzleHttp\Psr7\Request $request, \GuzzleHttp\Psr7\Response $response, \DI\Container $container)
	{

		$this->request = $request;
		$this->response = $response;
		$this->container = $container;
	}

	public function render($template, $data)
	{
		$response = $this->response;
		$twig = $this->container->get('Kappa\View');
		$rendered = $twig->render($template, $data);
		$response = $response->withHeader('Content-type', 'text/html');
		$response = $response->withBody(\GuzzleHttp\Psr7\stream_for($rendered));
		
		return $response;
	}
}