<?php declare(strict_types=1);

namespace Blog\Controllers\Backoffice;

use Http\Request;
use Http\Response;
use \Exception;

use Blog\Controllers\Backoffice\Home;
use Blog\Template\FrontendRenderer;

use Blog\Utilities\Backoffice\AuthModel;
use Blog\Utilities\Backoffice\AdminModel;
use Blog\Utilities\Users\UsersModel;

use Blog\Domain\Comments\CommentsFinder;
use Blog\Domain\Posts\PostsFinder;
use Blog\Domain\Announces\AnnouncesFinder;
use Blog\Domain\ContactApp\ContactApp;
use Blog\Domain\About\AboutFinder;
use Blog\Domain\Reports\ReportsFinder;

class Requests
{
	public function __construct(
		Request $request,
		Response $response,
		FrontendRenderer $renderer
	) {
		$this->request = $request;
		$this->response = $response;
		$this->renderer = $renderer;
	}

	public function viewDegree()
	{
		$admin = new AdminModel();
		
		$data = [$admin->getDegreeData($this->request->getParameter('degrees'))];

		$html = $this->renderer->render('/terminals/DegreeData', $data[0]);
		$this->response->setContent($html);
	}

	public function viewInterest()
	{
		$admin = new AdminModel();

		$data = [$admin->getInterestData($this->request->getParameter('interest'))];

		$html = $this->renderer->render('./terminals/InterestData', $data[0]);
		$this->response->setContent($html);
	}

	public function route()
	{
		$mode = $this->request->getParameter('m');

		switch ($mode)
		{
			case 'overview':
				$dataFinder = new AdminModel();
				$data = [$dataFinder->get()];
			//	die(var_dump($data));
				break;

			case 'reports':
				$dataFinder = new ReportsFinder();
				$data = [0 => array("data" => $dataFinder->getAll())];
				break;

			case 'users':
				$dataFinder = new UsersModel();
				$data = [0 => array("data" => $dataFinder->getUsers())];
				break;

			case 'comments':
				$dataFinder = new CommentsFinder();
				$data = [0 => array("data" => $dataFinder->get())];
				break;

			case 'posts':
				$dataFinder = new PostsFinder();
				$data = [0 => array("data" => $dataFinder->getAll())];
				break;

			case 'announces':
				$dataFinder = new AnnouncesFinder();
				$data = [0 => array("data" => $dataFinder->get())];
				break;

			case 'messages':
				$dataFinder = new ContactApp();
				$data = [0 => array("data" => $dataFinder->getAll())];
				break;

			case 'degrees':
				$dataFinder = new AboutFinder();
				//$data = [$dataFinder->getDegrees()];
				$data = [0 => array("data" => $dataFinder->getDegrees())];
				break;

			case 'interests':
				$dataFinder = new AboutFinder();
				$data = [0 => array("data" => $dataFinder->getInterests())];
				break;

			default:
				throw new Exception('Erreur fatale : les informations recherchées n\'ont pas pu être trouvées');
		}

		# die(print_r($data[0]));

		$html = $this->renderer->render('/terminals/' . $mode, $data[0]);
		$this->response->setContent($html);
	}
}
