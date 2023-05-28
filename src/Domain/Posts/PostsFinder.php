<?php declare(strict_types=1);

namespace Blog\Domain\Posts;

use Blog\Repository\DbControl;

class PostsFinder extends DbControl {

	public function getAll()
	{
		$db = new DbControl();

		return $db->query('SELECT *, DATE_FORMAT(dt_upload, \'%a %d %b (%H:%i)\') AS \'dt_upload\' FROM posts ORDER BY id DESC');		
	}

	public function getLatest()
	{
		$db = new DbControl();

		return $db->query('SELECT *, DATE_FORMAT(dt_upload, \'%a %d %b (%H:%i)\') AS \'dt_upload\' FROM posts ORDER BY id DESC LIMIT 0, 3');
	}

	public function getMostPopular()
	{
		$db = new DbControl();

		$posts = $db->query('SELECT *, DATE_FORMAT(dt_upload, \'%a %d %b (%H:%i)\') AS \'dt_upload\' FROM posts ORDER BY views DESC');

		return [
			'bestPost' => $posts[0],
			'popularPosts' => [$posts[1], $posts[2]]
		];
	}
}