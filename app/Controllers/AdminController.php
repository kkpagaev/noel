<?php

namespace App\Controllers;

/**
 * 
 */
class AdminController extends Controller
{
	public function index($id)
	{

		// var_dump($this->render('hello.html', ['hello' => 'Hello, world!']));
		return $this->render('hello.html', ['hello' => 'Hello, world!']);
	}
}