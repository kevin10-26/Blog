<?php declare(strict_types=1);

namespace Blog\Controllers;

use Http\Request;
use Http\Response;
use Blog\Template\FrontendRenderer;
use Blog\Utilities\Sidebar;
use Blog\Domain\Announces\AnnouncesFinder;

class Announces
{
	public function __construct(Request $request, Response $response, FrontendRenderer $renderer)
	{
		$this->request = $request;
		$this->response = $response;
		$this->renderer = $renderer;
	}

	public function show()
	{
		$sidebar = new Sidebar();
		$announces = new AnnouncesFinder();
		$data = [
			'title' => 'Liste des annonces',
			'sidebar' => $sidebar->getData(),
			'announcesList' => $announces->get()
		];

		$html = $this->renderer->render('AnnouncesList', $data);
		$this->response->setContent($html);

	}

	public function viewAnnounce()
	{
		$sidebar = new Sidebar();
		$announces = new AnnouncesFinder();

		die(var_dump($this->request->getBodyParameters()));

		$data = [
			'title' => 'Annonce : ',
			'sidebar' => $sidebar->getData(),
		//	'announce' => $announces->getById($this->request->getParameter('view'))
		];

		$html = $this->renderer->render('AnnouncesList', $data);
		$this->response->setContent($html);
	}
}
