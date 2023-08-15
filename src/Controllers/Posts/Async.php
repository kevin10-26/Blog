<?php declare(strict_types=1);

namespace Blog\Controllers\Posts;

use Http\Request;
use Blog\Domain\Comments\CommentsFinder;
use Blog\Repository\WSManager;

class Async
{
	private $request;

	public function __construct(
		Request $request
	) {
		$this->request = $request;
	}

	public function getRelated()
	{
		$commentsFinder = new CommentsFinder();

		$WSM = new WSManager($this->request);

		die(var_dump($WSM->init()));

		echo json_encode($commentsFinder->getByPost($this->request->getParameter('postId', '4')));
		exit;
	}
}