<?php declare(strict_types=1);

namespace Blog\Domain\Reports;

use Blog\Repository\DbControl;
use Blog\Domain\Comments\CommentsFinder;

class ReportsFinder extends DbControl
{
	public function getAll()
	{
		$db = new DbControl();

		$reports = $db->query('SELECT * FROM reports ORDER BY id DESC');
			
		foreach ($reports as $k => $v)
		{
			$reports[$k]['path'] = $this->addPath($reports[$k]['content_type'], $reports[$k]['content_id']);
		}

		return $reports;
	}

	public function getReportsByContent($contentId, $contentType)
	{
		$db = new DbControl();

		$args = array(0 =>
			array(
				"field" => "content_id",
				"value" => $contentId
			),
			1 => array(
				"field" => "content_type",
				"value" => $contentType
			)
		);

		$reports = $db->query('SELECT * FROM reports WHERE content_type = :content_type AND content_id = :content_id ORDER BY id DESC', $args);		

		return $reports;
	}

	private function addPath($cType, $cId)
	{
		switch ($cType)
		{
		case 'post':
			$res = '/blog/post/' . $cId;
			break;

		case 'comment':
			$finder = new CommentsFinder();
			$postId = $finder->getCommentById($cId);
			$res = '/blog/post/' . $postId['post_id'] . '#comment-' . $cId;
			break;

		case 'user':
			$res = '/users/' . $cId;
			break;

		case 'announce':
			$res = '/announces/' . $cId;
			break;

		default:
			$res = '';
			break;
		}

		return $res;
	}
}
