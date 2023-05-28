<?php declare(strict_types=1);

namespace Blog\Controllers;

use Http\Request;
use Http\Response;
use Blog\Template\FrontendRenderer;
use Blog\Domain\Index\IndexModel;
use Blog\Utilities\Sidebar;

class Index
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
		$indexModel = new IndexModel();
		$sidebar = new Sidebar();
		$data = [
			'isIndex' => true,
			'name' => $this->request->getParameter('name', 'stranger'),
			'header' => array(
				'background' => './public/img/misc/index/bg_index.jpg',
				'headerCards' => [
					['Blog', 'blog', 'fa-solid fa-newspaper'],
					['Espace membre', 'membership', 'fa-solid fa-users'],
					['Annonces', 'announces', 'fa-sharp fa-solid fa-bullhorn'],
					['Contact', 'contact', 'fa-solid fa-headset']
				],
			),
			'main' => array(
				'posts' => $indexModel->getPosts(),
				'announce' => $indexModel->getLastAnnounce()[0]
			),
			'sidebar' => $sidebar->getData(),
			'title' => 'Page d\'accueil'
		];

		// die(var_dump($data['main']['announce']['id']));
		$html = $this->renderer->render('Index', $data);
		$this->response->setContent($html);
	}
}