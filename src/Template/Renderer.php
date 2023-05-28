<?php declare(strict_types=1);

namespace Blog\Template;

interface Renderer
{
	public function render($template, $data = []) : string;
}