<?php

namespace Kappa\Providers;

abstract class Provider
{
	private $container;

	abstract public function register();

	public function __construct($container)
	{
		$this->container = $container;
	}

	public function bind($class, $call)
	{
		$this->container->set($class, $call);
	}

}