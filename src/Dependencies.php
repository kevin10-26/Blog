<?php declare(strict_types=1);

$injector = new \Auryn\Injector;

$injector->alias('Http\Request', 'Http\HttpRequest');
$injector->share('Http\HttpRequest');
$injector->define('Http\HttpRequest', [
	':get' => $_GET,
	':post' => $_POST,
	':cookies' => $_COOKIE,
	':files' => $_FILES,
	':server' => $_SERVER,
]);

$injector->alias('Http\Response', 'Http\HttpResponse');
$injector->share('Http\HttpResponse');

$injector->alias('Blog\Template\Renderer', 'Blog\Template\TwigRenderer');

$injector->define('Mustache_Engine', [
	':options' => [
		'loader' => new Mustache_Loader_FilesystemLoader(dirname(__DIR__) . '/templates', [
			'extension' => '.html',
		]),
	],
]);

$injector->delegate('Twig_Environment', function () use ($injector) {
	$loader = new Twig_Loader_Filesystem(dirname(__DIR__) . '/templates');
	$twig = new Twig_Environment($loader, ['debug' => true]);
	$twig->addExtension(new \Twig\Extension\DebugExtension());
	return $twig;
});

$injector->alias('Blog\Template\FrontendRenderer', 'Blog\Template\FrontendTwigRenderer');

$injector->alias('Blog\Menu\MenuReader', 'Blog\Menu\ArrayMenuReader');
$injector->share('Blog\Menu\ArrayMenuReader');

return $injector;