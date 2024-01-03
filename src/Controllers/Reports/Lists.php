<?php declare(strict_types=1);

namespace Blog\Controllers\Reports;

use Http\Request;
use Http\Response;
use Blog\Template\FrontendRenderer;
use Blog\Domain\Reports\ReportsFinder;

// Mostly used with async. requests

class Lists
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

	public function show()
	{
		$reportsFinder = new ReportsFinder();

		$reports = $reportsFinder->getReportsByContent($this->request->getParameter('c_id'), $this->request->getParameter('c_type'));
		array_unshift($reports, 'ok');

		$reports = json_encode($reports);
		echo $reports;
		exit;	
	}
}
