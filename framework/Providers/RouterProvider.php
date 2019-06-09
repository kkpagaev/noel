<?php

namespace Kappa\Providers;

use Kappa\Test;
use Di\get;

class RouterProvider extends Provider
{
	public function register()
	{
		$this->bind('FastRoute\Dispatcher', function () {
			$dispatcher = \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $r) {
			    $r->get('/{id}', 'AdminController:index');
			    // {id} must be a number (\d+)
			    $r->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
			    // The /{title} suffix is optional
			    $r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
			});
			
			return $dispatcher;
		});
	}
}