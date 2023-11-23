<?php declare(strict_types=1);

namespace Blog\Utilities\Users;

use Blog\Repository\DbControl;

class UsersModel extends DbControl
{
	public function getUsers()
	{
		$db = new DbControl();

		return $db->query('SELECT * FROM users ORDER BY id DESC');
	}
}
