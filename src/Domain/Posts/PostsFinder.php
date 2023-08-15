<?php declare(strict_types=1);

namespace Blog\Domain\Posts;

use Blog\Repository\DbControl;

class PostsFinder extends DbControl {

	public function getAll()
	{
		$db = new DbControl();

		return $db->query('SELECT *, DATE_FORMAT(dt_upload, \'%a. %d %b (%H:%i)\') AS \'dt_upload\', DATE_FORMAT(dt_update, \'%a %d %b (%H:%i)\') AS \'dt_update\' FROM posts ORDER BY id DESC');		
	}

	public function getPostById($id)
	{
		$db = new DbControl();

		$args = array(0 => 
			array(
				'field' => 'id',
				'value' => $id,
			)
		);

		return $db->query('SELECT *, DATE_FORMAT(dt_upload, \'%a. %d %b (%H:%i)\') AS \'dt_upload\', DATE_FORMAT(dt_update, \'%a. %d %b (%H:%i)\') AS \'dt_update\' FROM posts WHERE id = :id', $args)[0];
	}

	public function getLatest()
	{
		$db = new DbControl();

		return $db->query('SELECT *, DATE_FORMAT(dt_upload, \'%a. %d %b (%H:%i)\') AS \'dt_upload\' FROM posts ORDER BY id DESC LIMIT 0, 3');
	}

	public function getMostPopular()
	{
		$db = new DbControl();

		$posts = $db->query('SELECT *, DATE_FORMAT(dt_upload, \'%a. %d %b (%H:%i)\') AS \'dt_upload\' FROM posts ORDER BY views DESC');

		return [
			'bestPost' => $posts[0],
			'popularPosts' => [$posts[1], $posts[2]]
		];
	}

	public function getDomains()
	{
		$db = new DbControl();
		
		$args = array(0 => 
			array(
				'field' => 'field',
				'value' => 'domain',
			)
		);

		$data = $db->query('SHOW COLUMNS FROM posts WHERE Field = :field', $args);

		preg_match("/^enum\(\'(.*)\'\)$/", $data[0]['Type'], $domains);
		$domains = explode("','", $domains[1]);

		return $domains;
	}

	public function getAllOfDomain($domain)
	{
		$db = new DbControl();

		$args = array(
			0 => array(
				'field' => 'domain',
				'value' => $domain
			)
		);

		return $db->query('SELECT *, DATE_FORMAT(dt_upload, \'%a. %d %b (%H:%i)\') AS \'dt_upload\' FROM posts WHERE domain = :domain ORDER BY id DESC', $args);
	}

	public function otherOfDomain($domain, $id)
	{
		$db = new DbControl();

		$args = array(
			0 => array(
				'field' => 'domain',
				'value' => $domain
			),
			1 => array(
				'field' => 'id',
				'value' => $id
			)
		);

		return $db->query('SELECT *, DATE_FORMAT(dt_upload, \'%a. %d %b (%H:%i)\') AS \'dt_upload\' FROM posts WHERE domain = :domain AND id <> :id ORDER BY id DESC', $args);
	}
}