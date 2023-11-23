<?php declare(strict_types=1);

namespace Blog\Utilities\Backoffice;

use Blog\Repository\DbControl;

class AuthModel extends DbControl
{
	public function check($id, $password)
	{
		$data = json_decode($this->get(), true);

		if ($data['id'] === $id && $data['password'] === $password) {
			return true;
		} else {
			return false;
		}
	}

	private function get()
	{
	//	die(var_dump(getcwd()));
		$ids = file_get_contents('http://' . $_SERVER['SERVER_NAME'] . '/kevin1026/src/files/back_auth.json');

		return $ids;
	}

	public function activate()
	{
		$db = new DbControl();
	
		$token = bin2hex(openssl_random_pseudo_bytes(16));

		$args = array(
			0 => array(
				"field" => "token",
				"value" => $token
			)
			
		);

		$db->query('INSERT INTO sess_token(sess_token, dt_init) VALUES(:token, NOW())', $args);
		return $token;
	}
}
