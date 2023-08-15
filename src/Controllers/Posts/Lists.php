<?php declare(strict_types=1);

namespace Blog\Controllers\Posts;

use Http\Request;
use Http\Response;
use Blog\Template\FrontendRenderer;
use Blog\Utilities\Sidebar;
use Blog\Domain\Posts\PostsFinder;

class Lists
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
		$postsFinder = new PostsFinder();

		$data = [
			'title' => 'Liste des publications',
			'domainName' => 'all',
			'session' => (isset($_SESSION['user_session'])) ? true : false,
			'sidebar' => $sidebar->getData(),
			'domains' => $postsFinder->getDomains(),
			'posts' => $postsFinder->getAll(),
		];

		$html = $this->renderer->render('PostsList', $data);
		$this->response->setContent($html);
	}

	public function findByDomain()
	{
		$sidebar = new Sidebar();
		$postsFinder = new PostsFinder();

		$domain = $this->request->getParameter('d', 'all');

		$domainName = ($domain === 'all') ? 'Tous les domaines' : $domain;

		$data = [
			'title' => 'Résultats dans le domaine "' . $domainName . '"',
			'domainName' => $domain,
			'session' => (isset($_SESSION['user_session'])) ? true : false,
			'sidebar' => $sidebar->getData(),
			'domains' => $postsFinder->getDomains(),
			'posts' => ($domain === 'all') ? $postsFinder->getAll() : $postsFinder->getAllOfDomain($this->request->getParameter('d', 'all')),
		];

		$html = $this->renderer->render('PostsList', $data);
		$this->response->setContent($html);
	}

	private function getCurrentDomain()
	{
		return $this->request->getParameter('d', 'all');
	}
}