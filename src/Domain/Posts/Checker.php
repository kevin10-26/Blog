<?php declare(strict_types=1);

namespace Blog\Domain\Posts;

use Blog\Repository\DbControl;
use Blog\Domain\Posts\PostsFinder;

class Checker extends DbControl
{
	public function checkTitle($data)
	{
		$db = new DbControl();

		$args = array(0 =>
			array(
				'field' => 'title',
				'value' => $data
			)
		);
		
		$res = $db->query('SELECT title FROM posts WHERE title = :title', $args);		
		if (isset($res[0]) && $data === $res[0]['title']) {
			return false;
		} else {
			return $data;
		}
	}

	public function checkDomain($data)
	{
		$db = new DbControl();

		$args = array(0 =>
			array(
				'field' => 'domain',
				'value' => 'domain'
			)
		);

		$res = $db->query('SHOW COLUMNS FROM posts WHERE Field = :domain', $args);
		$domains = $this->parseColumn($res);
		
		if (in_array($data, $domains))	{
			return $data;
		} else {
			return false;
		}
	}

	public function checkCategory($data, $domain)
	{
		$db = new DbControl();

		$args = array(0 =>
			array(
				'field' => 'category',
				'value' => 'category'
			)
		);

		$res = $db->query('SHOW COLUMNS FROM posts WHERE Field = :category', $args);
		$categories = $this->parseColumn($res);
		
		if (in_array($data, $categories)) {

			if (!empty($domain)) {
				$postsFinder = new PostsFinder();
				$postsOfDomain = $postsFinder->getAllOfDomain($domain);
				$categoriesUsed = array_unique(array_column($postsOfDomain, 'category'));
				if (!in_array($data, $categoriesUsed)) {
					return 'ok';
				} else {
					return $data;
				}
			} else {
				return $data;
			}
		} else {
			return false;
		}
	}

	private function parseColumn($res)
	{
		preg_match("/^enum\(\'(.*)\'\)$/", $res[0]['Type'], $data);
	
		$data = explode("','", $data[1]);

		return $data;

	}
}
