<?php declare(strict_types=1);

namespace Blog\Controllers;

use Http\Request;
use Http\Response;
use Blog\Template\FrontendRenderer;
use Blog\Utilities\Sidebar;

class About
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

	/**
	 * Analyzes the Request object (set by constructor while instanciating in Bootstrap.php)
	 * Every `post` request must be precised with a `get` parameter
	 * 
	 * The function will simply return the result of the called function, according to the `get` (or `post` if necessary) request
	 * Hence, only 2 `get` parameters can be passed, to avoid url overloading first, and second, having to much conditionnal statements in the `head` function
	 * 
	 * The `post` parameters are never analyzed here, just pass them in function arguments
	 * 
	 * This 'default' statement points to the About page.
	 * 
	 * @see /kevin1026/docs/internal_router.md to get 'case' options (common to every internal router)
	 * 
	 * Not working anymore, but keep them for plugins with multiple paths.
	*/

	public function head()
	{
		$this->show();
	}

	public function show()
	{
		$sidebar = new Sidebar();
		$data = [
			'name' => $this->request->getParameter('name', 'stranger'),
			'sidebar' => $sidebar->getData(),
			'tabs' => array(
				0 => array(
					'name' => 'Qui suis-je ?',
					'param' => 'discover',
					'default' => true
				),
				1 => array(
					'name' => 'Diplômes',
					'param' => 'degrees'
				),
				2 => array(
					'name' => 'Parcours',
					'param' => 'steps'
				),
			),
			'tabData' => array(
				'discover' => array(
					'hobbies' => array(
						0 => array(
							'name' => 'Développement Web',
							'img' => 'devweb.jpg'
						),
						1 => array(
							'name' => 'Tennis de table',
							'img' => 'devweb.jpg'
						),
						2 => array(
							'name' => 'Le Droit',
							'img' => 'devweb.jpg'
						),
						3 => array(
							'name' => 'Langues vivantes étrangères',
							'img' => 'devweb.jpg'
						),
					),
					'networks' => ['fa-brands fa-instagram', 'fa-brands fa-linkedin', 'fa-brands fa-facebook']
				),
				'degrees' => array(
					0 => array(
						'name' => 'Baccalauréat',
						'year' => 2021,
						'struct' => 'Édouard Herriot'
					)
				),
				'steps' => array(
					0 => array(
						'name' => 'Lancement du site RusseHerriot',
						'description' => 'Durant la crise sanitaire liée à la pandémie de CoViD-19, j\'ai mis en ligne mon tout premier site : RusseHerriot, destiné au début à aider ceux qui apprenaient le russe dans ma classe au lycée.',
						'year' => '23 juillet 2020'
					),
					1 => array(
						'name' => 'Entrée en licence de droit',
						'description' => 'Après obtention du Baccalauréat, j\'ai commencé une licence de droit afin de m\'orienter vers le droit du numérique',
						'year' => 2021
					),
				),
			),
			'title' => 'À propos'
		];

		$html = $this->renderer->render('About', $data);
		$this->response->setContent($html);
	}
}