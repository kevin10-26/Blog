<?php declare(strict_types=1);

namespace Blog\Controllers\Backoffice;

use Http\Request;
use Http\Response;
use Blog\Template\FrontendRenderer;
use Blog\Utilities\Sidebar;
use Blog\Controllers\Backoffice\Home;

class Auth
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

	public function route()
	{
		die(var_dump($this->request->getParameters()));
		if(isset($_SESSION['admin_sess']) && !empty($_SESSION['admin_sess'])) {
			$home = new Home($this->request, $this->response, $this->renderer);

			$home->show($_SESSION['admin_sess']);

		} elseif (true) {
			$this->signin();
		} else {
			$this->login();
		}
	}

	public function login()
	{
		$sidebar = new Sidebar();

		$data = [
			'Title' => 'Espace d\'administration',
			'sidebar' => $sidebar->getData()
		];

		$html = $this->renderer->render('BackofficeLogin', $data);
		$this->response->setContent($html);
	}
}
