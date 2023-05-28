<?php declare(strict_types=1);

namespace Blog\Menu;

interface MenuReader
{
	public function readMenu() : array;
}