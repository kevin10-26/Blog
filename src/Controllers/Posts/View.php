<?php declare(strict_types=1);

namespace Blog\Controllers\Posts;

use Http\Request;
use Http\Response;
use Blog\Template\FrontendRenderer;
use Blog\Utilities\Sidebar;
use Blog\Domain\Posts\PostsFinder;
use Blog\Domain\Comments\CommentsFinder;
use \Exception;

class View extends Exception
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
		if (is_null($this->request->getParameter('id'))) {
			throw new Exception("Cette publication n'existe pas.", 1);
		}

		$sidebar = new Sidebar();
		$postsFinder = new PostsFinder();
		$commentsFinder = new CommentsFinder();

		$postId = $this->request->getParameter('id');

		$data = [
			'title' => 'Liste des publications',
			'domainName' => 'all',
			'session' => (isset($_SESSION['user_session'])) ? true : false,
			'sidebar' => $sidebar->getData(),
			'post' => $postsFinder->getPostById($postId),
			'ofDomain' => $postsFinder->otherOfDomain($postsFinder->getPostById($postId)['domain'], $postId)
		];

		//echo $data['post']['content'];

		$html = $this->renderer->render('PostView', $data);
		$this->response->setContent($html);
	}
}
