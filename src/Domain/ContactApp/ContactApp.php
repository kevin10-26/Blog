<?php declare(strict_types=1);

namespace Blog\Domain\ContactApp;

use Http\Request;
use Blog\Repository\Sender;
use Blog\Repository\DbControl;
use \Exception;

class ContactApp extends DbControl
{
	private $input;

	public function getAll()
	{
		$db = new DbControl();

		return $db->query('SELECT * FROM messages ORDER BY id DESC');
	}

	public function send(Request $data) {
		$this->input = $data->getParameters();

		if ($this->checkData($data->getParameters())) {
			$data = $this->checkNames($data);
			$sender = new Sender($this->input);

			$sender->send();
		}
	}

	private function checkNames($input) {
		switch($this->input) {
			case isset($this->input['firstName']) && isset($this->input['lastName']):
				$this->input['name'] = $this->input['firstName']. ' ' . $this->input['lastName'];
				break;
			
			case isset($this->input['firstName']) && !isset($this->input['lastName']) || !isset($this->input['firstname']) && isset($this->input['lastName']):
				$this->input['name'] = (isset($this->input['firstName'])) ? $this->input['firstName'] : $this->input['lastName'];
				break;
			
			default:
				$this->input['name'] = '';
				break;
		}
	}

	private function checkData ($data) {
		if (isset($data['email'], $data['topic'], $data['content']) && !empty($data['email']) && !empty($data['topic']) && !empty($data['content']))
		{
			return true;
		} else {
			throw new Exception('Tous les champs obligatoires n\'ont pas été renseignés');
			return false;
		}
	}
}
