<?php declare(strict_types=1);

namespace Blog\Controllers\Posts;

use Http\Request;
use Blog\Domain\Posts\Checker;
use Blog\Domain\Posts\Uploader;

class Checks
{
	
	private $request;	

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function checkWriterData()
	{	
		switch ($this->request->getParameter('mode')) {
		case 'title':
			$checker = new Checker();
			$res = $checker->checkTitle($this->request->getParameter('title'));
			echo ($res !== false) ? json_encode([$res]) : json_encode(['no']);
			break;

		case 'domain':
			$checker = new Checker();
			$res = $checker->checkDomain($this->request->getParameter('domain'));
			echo ($res !== false) ? json_encode([$res]) : json_encode(['no']);
			break;

		case 'category':
			$checker = new Checker();
			$res = $checker->checkCategory($this->request->getParameter('category'), $this->request->getParameter('domain'));
			echo ($res !== false) ? json_encode([$res]) : json_encode(['no']);
			break;
		}
	}

	public function setNewMode()
	{
		$uploader = new Uploader();
		// TODO : Add domain / category
		switch ($this->request->getParameter('mode')) {
			case 'domain':
				$uploader->addDomain($this->request->getParameter('value'));
				echo 'ok';
				break;
			case 'category':
				$uploader->addCategory($this->request->getParameter('value'));
				echo 'ok';
				break;
			default:
				return false;
		}
	}
}
