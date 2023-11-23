<?php declare(strict_types=1);

namespace Blog\Controllers;

use Http\Request;
use Http\Response;
use Blog\Template\FrontendRenderer;
use Blog\Utilities\Sidebar;
use Blog\Domain\ContactApp\ContactApp;

class Contact
{
	private $request;
	private $response;
	private $renderer;

	public function __construct(
		Response $response,
		Request $request,
		FrontendRenderer $renderer
	) {
		$this->request = $request;
		$this->response = $response;
		$this->renderer = $renderer;
	}

	public function show() {
		$sidebar = new Sidebar();
		$data = [
			'title' => 'Contact',
			'sidebar' => $sidebar->getData()
		];

		$html = $this->renderer->render('Contact', $data);
		$this->response->setContent($html);
	}

	public function sendMail() {
		$contact = new ContactApp();

		$contact->send($this->request);
	}
}
