<?php declare(strict_types=1);

namespace Blog\Menu;

class ArrayMenuReader implements MenuReader
{
	public function readMenu() : array
	{
		return [
			['href' => '/kevin1026/', 'text' => 'Accueil'],
			['href' => '/kevin1026/about/', 'text' => 'À propos de moi'],
			['href' => '/kevin1026/blog/', 'text' => 'Publications'],
			['href' => '/kevin1026/announces/', 'text' => 'Annonces'],
			['href' => '/kevin1026/contact/', 'text' => 'Contact'],

		];
	}
}