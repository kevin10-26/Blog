<?php declare(strict_types=1);

return [
	['GET', '/kevin1026/', ['Blog\Controllers\Index', 'show']],
	['GET', '/kevin1026/index/', ['Blog\Controllers\Index', 'show']],

	[['GET', 'POST'], '/kevin1026/about/', ['Blog\Controllers\About', 'head']],

	['GET', '/kevin1026/blog/', ['Blog\Controllers\Posts\Lists', 'show']],
	['GET', '/kevin1026/blog/search/{domain}', ['Blog\Controllers\Posts\Lists', 'findByDomain']],
	['GET', '/kevin1026/blog/post/{id}', ['Blog\Controllers\Posts\View', 'show']],
	
	[['GET', 'POST'], '/kevin1026/blog/async/getRelatedPosts', ['Blog\Repository\WSManager', 'init']],

	['GET', '/kevin1026/announces/', ['Blog\Controllers\Announces\List', 'show']],

	['GET', '/kevin1026/contact/', ['Blog\Controllers\Contact', 'show']],

	['POST', '/kevin1026/checks/checkUser/', ['Blog\Controllers\Checks', 'checkUser']],
];
