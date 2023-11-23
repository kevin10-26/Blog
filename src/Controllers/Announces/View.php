<?php declare(strict_types=1);

namespace Blog\Controllers\Announces;

use Http\Request;
use Http\Response;
use Blog\Template\FrontendRenderer;
use Blog\Utilities\Sidebar;
use Blog\Domain\Announces\AnnouncesFinder;

class View
{
	public function __construct(Request $request, Response $response, FrontendRenderer $renderer)
	{
		$this->request = $request;
		$this->response = $response;
		$this->renderer = $renderer;
	}

	public function viewAnnounce($id)
	{
		$sidebar = new Sidebar();
		$announces = new AnnouncesFinder();

		$data = [
			'title' => 'Annonce : ',
			'sidebar' => $sidebar->getData(),
			'announce' => $announces->getById($id['view'])[0]
		];

		$html = $this->renderer->render('AnnounceView', $data);
		$this->response->setContent($html);
	}
}
