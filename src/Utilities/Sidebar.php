<?php declare(strict_types=1);

namespace Blog\Utilities;

use Blog\Domain\Comments\CommentsFinder;
use Blog\Domain\Announces\AnnouncesFinder;
use Blog\Domain\Users\UsersUtil;

class Sidebar
{
	public function getData()
	{
		$comments = new CommentsFinder;
		$announces = new AnnouncesFinder;

		return [
			'comments' => $comments->get(5),
			'announces' => $announces->get(5)
		];
	}
}