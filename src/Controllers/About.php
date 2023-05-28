<?php declare(strict_types=1);

namespace Blog\Controllers;

use Http\Request;
use Http\Response;
use Blog\Template\FrontendRenderer;
use Blog\Utilities\Sidebar;

class About
{
	private $request;
	private $response;
	private $renderer;

	public function __construct(
		Response $response,
		Request $request,
		FrontendRenderer $renderer
	) {
		$this->request = $request;
		$this->response = $response;
		$this->renderer = $renderer;
	}

	public function show()
	{
		$sidebar = new Sidebar();
		$data = [
			'name' => $this->request->getParameter('name', 'stranger'),
			'sidebar' => $sidebar->getData(),
			'tabs' => array(
				0 => array(
					'name' => 'Qui suis-je ?',
					'param' => 'discover'
				),
				1 => array(
					'name' => 'Diplômes',
					'param' => 'degrees'
				),
				2 => array(
					'name' => 'Parcours',
					'param' => 'steps'
				),
				3 => array(
					'name' => 'Centres d\'intérêts',
					'param' => 'interests'
				),
			),
			'title' => 'À propos'
		];

		$html = $this->renderer->render('About', $data);
		$this->response->setContent($html);
	}
}