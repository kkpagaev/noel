<?php

namespace Kappa\Providers;

use Kappa\Test;
use Di\get;


class TwigProvider extends Provider
{
	public function register()
	{
		$this->bind('Kappa\View', function () {
			$loader = new \Twig\Loader\FilesystemLoader(DIR . '/app/Views');
			$twig = new \Twig\Environment($loader, [ 
				'cache' => false,
				'debug'=>true
			    // 'cache' => DIR . '/cache',
			]);
			return $twig;
		});
	}
}