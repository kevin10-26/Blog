<?php declare(strict_types = 1);

namespace Blog\Template;

use Twig_Environment;

class TwigRenderer implements Renderer
{
    private $renderer;

    public function __construct(Twig_Environment $renderer)
    {
        $this->renderer = $renderer;
    }

    public function render($template, $data = []) : string
    {
    	// die(var_dump($data));
        return $this->renderer->render("$template.html", $data);
    }
}
