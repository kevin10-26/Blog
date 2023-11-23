<?php declare(strict_types=1);

namespace Blog\Controllers\Backoffice;

use Http\Request;
use Http\Response;
use Blog\Template\FrontendRenderer;
use Blog\Utilities\Sidebar;
use Blog\Utilities\Backoffice\HomeModel;

class Home
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

	public function show() {
		$sidebar = new Sidebar();
		$homeModel = new HomeModel();

		$data = [
			'Title' => 'Accueil de l\'espace d\'administration',
			'sidebar' => $sidebar->getData(),
			'data' => $homeModel->get() 
		];

		$html = $this->renderer->render('BackofficeHome', $data);
		$this->response->setContent($html);
	}
	
}
