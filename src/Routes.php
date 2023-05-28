<?php declare(strict_types=1);

return [
	['GET', '/kevin1026/', ['Blog\Controllers\Index', 'show']],
	['GET', '/kevin1026/index', ['Blog\Controllers\Index', 'show']],
	['GET', '/kevin1026/about', ['Blog\Controllers\About', 'show']],
	['GET', '/kevin1026/blog', ['Blog\Controllers\Posts\List', 'show']],
	['GET', '/kevin1026/announces', ['Blog\Controllers\Announces\List', 'show']],
	['GET', '/kevin1026/contact', ['Blog\Controllers\Contact', 'show']],
];