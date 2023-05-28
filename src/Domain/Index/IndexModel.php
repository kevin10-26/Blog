<?php declare(strict_types=1);

namespace Blog\Domain\Index;

use Blog\Domain\Posts\PostsFinder;
use Blog\Domain\Announces\AnnouncesFinder;

/*
* Get posts for every place of the website (index, posts list, backoffice, etc.)
*/

class IndexModel
{
	public function getPosts()
	{
		$postsFinder = new PostsFinder();

		return array(
			'latest' => $postsFinder->getLatest(),
			'cover' => $postsFinder->getMostPopular()
		);
	}

	public function getLastAnnounce()
	{
		$announce = new AnnouncesFinder();

		return $announce->getLast();
	}
}