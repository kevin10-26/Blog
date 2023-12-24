<?php declare(strict_types=1);

namespace Blog\Controllers\Posts;

use Http\Request;
use Http\Response;
use Blog\Template\FrontendRenderer;
use Blog\Utilities\Sidebar;
use Blog\Domain\Posts\PostsFinder;
use Blog\Domain\Posts\Uploader;

class Writer
{
	private $request;
	private $response;
	private $renderer;

	public function __construct(
		Request $request,
		Response $response,
		FrontendRenderer $renderer
	 ) {
		$this->request = $request;
		$this->response = $response;
		$this->renderer = $renderer;
	}

	public function newPost() {
		$sidebar = new Sidebar();
		$postsFinder = new PostsFinder();

		$data = [
			'title' => 'Rédaction',
			'sidebar' => $sidebar->getData(),
			'domains' => $postsFinder->getDomains(),
			'categories' => $postsFinder->getCategories()
		];

		$html = $this->renderer->render('Writer', $data);
		$this->response->setContent($html);	
	}

	public function edit()
	{
		$sidebar = new Sidebar();
		$postsFinder = new PostsFinder();

		$data = [
			'title' => 'Édition',
			'sidebar' => $sidebar->getData(),
			'domains' => $postsFinder->getDomains(),
			'categories' => $postsFinder->getCategories(),
			'post' => $postsFinder->getPostById($this->request->getParameter('id'))
		];	

		$html = $this->renderer->render('Writer', $data);
		$this->response->setContent($html);
	}

	public function submit()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$uploader = new Uploader();

			if ($uploader->submit($this->request->getParameters(), $this->request->getFiles())) {
				header('Location: ./backoffice/home/');
			} else {
				throw new \Exception('Erreur dans l\'enregistrement de la nouvelle publication');
			}
		} else {
			throw new \Exception('Erreur lors du traitement des données');
		}
	}

	public function updatePost()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$uploader = new Uploader();

			if ($uploader->edit($this->request->getParameters(), $this->request->getFiles())) {
				header('Location: ./backoffice/home/');
			} else {
				throw new \Exception('Erreur dans l\'enregistrement de la nouvelle publication');
			}
		} else {
			throw new \Exception('Erreur lors du traitement des données');
		}

	}
}
