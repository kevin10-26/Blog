<?php declare(strict_types=1);

namespace Blog\Controllers;

use Http\Request;

class Checks
{
	private $request;

	public function __construct(
		Request $request
	) {
		$this->request = $request;
	}

	public function checkUser()
	{
		// die(var_dump($this->request->getParameter('authorId'), $_SESSION['user_session']));
		if ($_SESSION['user_session'] == $this->request->getParameter('authorId')) {
			echo json_encode(array('res' => 'true'));
		} else {
			echo json_encode(array('res' => 'false'));
		}
	}
}