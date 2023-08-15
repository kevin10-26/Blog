<?php declare(strict_types=1);

namespace Blog\Repository;

use Http\Request;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WebSocketServer as WsServer;
use Blog\Sockets\WSComments;

class WSManager
{
	private $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function init()
	{
		$server = IoServer::factory(
		    new HttpServer(
		        new WsServer(
		            new WSComments()
		        )
		    ),
		    443
		);

		$stream->run();
	}
}