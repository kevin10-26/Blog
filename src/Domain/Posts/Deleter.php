<?php declare(strict_types=1);

namespace Blog\Domain\Posts;

use Blog\Repository\DbControl;
use Blog\Domain\PostFinder;

class Deleter extends DbControl
{
	public function removePost($id)
	{
		$postsFinder = new PostsFinder();
		$post = $postsFinder->getPostById($id);

		// Delete Thumbnail and pictures first
		if (!empty($post['thumbnail'])) {
			if(file_exists('./img/blog/thumbnails/'.$post['thumbnail'])) {
				unlink('./img/blog/thumbnails/' . $post['thumbnail']);
			}
		}
		if (is_dir('./img/blog/pictures/' . $post['id'] . '/')) {
			$files = glob('./img/blog/pictures/'.$post['id'].'/*');
			foreach($files as $file)
			{
				if(is_file($file))
				{
					unlink($file);
				}
			}
		}

		// Now, remove the DB content
		$db = new DbControl();
		$wCond = array(
			0 => array(
				'field' => 'id',
				'value' => $id
			)
		);
		$db->delt('posts', $wCond);

		$wCondReports = array(
			0 => array(
				'field' => "content_id",
				'value' => $id
			)
		);
		$db->delt('reports', $wCondReports);

		return true;

	}
}
