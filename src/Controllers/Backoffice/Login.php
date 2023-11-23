<?php declare(strict_types=1);

namespace Blog\Controllers\Backoffice;

use Http\Request;
use Http\Response;
use Blog\Template\FrontendRenderer;
use Blog\Utilities\Sidebar;
use Blog\Controllers\Backoffice\Home;
use Blog\Utilities\Backoffice\AuthModel;

class Login
{
	public function __construct(
		Request $request,
		Response $response,
		FrontendRenderer $renderer
	) {
		$this->request = $request;
		$this->response = $response;
		$this->renderer = $renderer;
	}

	public function signin()
	{
		$authCheck = new AuthModel();
		$id = $this->request->getParameter('email');
		$passwd = $this->request->getParameter('password');

		if ($authCheck->check($id, $passwd))
		{
			$_SESSION['admin_sess'] = $authCheck->activate();
			header('Location: ./home/');
		}
	}
}
