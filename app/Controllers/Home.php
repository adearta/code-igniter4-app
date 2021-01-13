<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		return view('welcome_message');
		// echo "hello world";
		//memanggil file denga nama wellcome_message pada folder view
	}
	public function coba()
	{
		echo "hello dear";
	}
	//--------------------------------------------------------------------

}
