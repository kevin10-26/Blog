<?php declare(strict_types=1);

namespace Blog\Domain\Announces;

use Blog\Repository\DbControl;

class AnnouncesFinder extends DbControl {

	public function get($limit = null)
	{
		$db = new DbControl();

		if (!is_null($limit)) {
			return $db->query('SELECT * FROM announces ORDER BY id DESC LIMIT 0, '. $limit);
		} else {
			return $db->query('SELECT * FROM announces ORDER BY id DESC');
		}
	}

	public function getLast()
	{
		$db = new DbControl();

		return $db->query('SELECT * FROM announces ORDER BY id DESC LIMIT 0, 1');
	}
}