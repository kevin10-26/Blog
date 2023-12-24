<?php declare(strict_types=1);

namespace Blog\Controllers\Backoffice;

use Http\Request;
use Blog\Utilities\Backoffice\AdminModel;

class Alter
{
	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function degrees()
	{
		switch ($this->request->getParameter('mode'))
		{
		case 'submit':
			$admin = new AdminModel();
			$admin->newDegree($this->request->getParameters());
			echo json_encode(['ok']);
			break;

		case 'edit':
			$admin = new AdminModel();
			$admin->editDegree($this->request->getParameters());
			echo json_encode(['ok']);
			break;	

		case 'delete':
			$admin = new AdminModel();
			$admin->deleteDegree($this->request->getParameters());
			echo 'ok';
			break;
		}
	}

	public function interests()
	{
		switch ($this->request->getParameter('mode'))
		{
		case 'submit':
			$admin = new AdminModel();
			$admin->newInterest($this->request->getParameters(), $this->request->getFiles());
			echo json_encode(['ok']);
			break;

		case 'edit':
			$admin = new AdminModel();
			$admin->editInterest($this->request->getParameters(), $this->request->getFiles());
			echo json_encode(['ok']);
			break;

		case 'deletePicture':
			$admin = new AdminModel();
			$admin->deleteInterestPicture($this->request->getParameters());
			echo json_encode(['ok']);
			break;

		case 'delete':
			$admin = new AdminModel();
			$admin->deleteInterest($this->request->getParameters());
			echo 'ok';
			break;
		}
	}
}
