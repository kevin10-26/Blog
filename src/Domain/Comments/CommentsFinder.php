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

	/**
	* First, get all comments
	* Then, assign the author info (username, profile pic) to each comment, whether it's an answer or not
	* Finally, separate comments and answers
	*/

	public function getByPost($postId)
	{
		$db = new DbControl();

		$args = array(
			0 => array(
				'field' => 'postId',
				'value' => $postId
			)
		);

		$allComments = $db->query('SELECT * FROM posts_comments WHERE post_id = :postId ORDER BY id DESC', $args);

		return $this->assignAuthorInfo($allComments);
	}

	private function assignAuthorInfo(&$comments)
	{
		$db = new DbControl();

		// die(var_dump(count($comments)));

		for ($i = 0; $i < count($comments); $i++)
		{
			$args = array(
				0 => array(
					'field' => 'id',
					'value' => $comments[$i]['author_id']
				)
			);

			$author = $db->query('SELECT id, username, profile_picture FROM users WHERE id = :id', $args)[0];

			// die(var_dump($author));
			$comments[$i]['author_name'] = $author['username'];
			$comments[$i]['author_pp'] = $author['profile_picture'];
		}

		return $comments;
	}

	/**
	 * array_values() : to reset $comments[] indexing from 0
	*/

	/**
	 * Struct :
	 * array(
	 * 	0 => array(
	 * 		'comment' => info,
	 * 		'answers' => array(
	 * 			0 => info
	 * 			1 => info
	 * 		)
	 * 	)
	 * )
	 * */

	private function joinAnswersToComment($comments)
	{
		$answers = [];

		$data = [];

		for ($i = 0; $i < count($comments); $i++)
		{
			if ($comments[$i]['is_answer'])
			{
				$answers[] = $comments[$i];
				$toUnset[] = $comments[$i]['id'];
			}
		}

		// die(var_dump($comments, $toUnset));

		for ($a = 0; $a < count($toUnset); $a++)
		{
			for ($b = 0; $b < count($comments); $b++)
			{
				if (isset($comments[$b]['id']) && $comments[$b]['id'] === $toUnset[$a])
				{
					unset($comments[$b]);
				}
			}
		}


		$comments = array_values($comments);

		for ($j = 0; $j < count($comments); $j++)
		{
			for ($k = 0; $k < count($answers); $k++)
			{
				if ($answers[$k]['id'] === $comments[$j]['comment_referer_id'])
				{
				}
			}
		}

		return array(
			'comments' => $comments,
			'answers' => $answers
		);
	}
}