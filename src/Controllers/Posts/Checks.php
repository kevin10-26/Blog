<?php declare(strict_types=1);

namespace Blog\Controllers\Posts;

use Http\Request;
use Blog\Domain\Posts\Checker;

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
			$res = $checker->checkCategory($this->request->getParameter('category'));
			echo ($res !== false) ? json_encode([$res]) : json_encode(['no']);
			break;
		}
	}
}
