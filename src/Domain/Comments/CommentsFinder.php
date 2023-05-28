<?php declare(strict_types=1);

namespace Blog\Domain\Comments;

use Blog\Repository\DbControl;

class CommentsFinder extends DbControl {

	public function get($limit = null)
	{
		$db = new DbControl();

		if (!is_null($limit)) {
			return $db->query('SELECT * FROM posts_comments INNER JOIN users ON posts_comments.author_id = users.id ORDER BY users.id DESC LIMIT 0, '. $limit);
		} else {
			return $db->query('SELECT * FROM posts_comments ORDER BY id DESC');
		}		
	}
}