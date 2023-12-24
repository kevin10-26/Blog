<?php declare(strict_types=1);

return [
	['GET', '/kevin1026/', ['Blog\Controllers\Index', 'show']],
	['GET', '/kevin1026/index/', ['Blog\Controllers\Index', 'show']],

	[['GET', 'POST'], '/kevin1026/about/', ['Blog\Controllers\About', 'head']],

	['GET', '/kevin1026/blog/', ['Blog\Controllers\Posts\Lists', 'show']],
	['GET', '/kevin1026/blog/search/{domain}', ['Blog\Controllers\Posts\Lists', 'findByDomain']],
	['GET', '/kevin1026/blog/post/{id}', ['Blog\Controllers\Posts\View', 'show']],
	
	[['GET', 'POST'], '/kevin1026/blog/async/getRelatedPosts', ['Blog\Repository\WSManager', 'init']],

	['GET', '/kevin1026/contact/', ['Blog\Controllers\Contact', 'show']],
	[['GET', 'POST'], '/kevin1026/contact/sendMsg', ['Blog\Controllers\Contact', 'sendMail']],

	['GET', '/kevin1026/announces/', ['Blog\Controllers\Announces', 'show']],
	
	['GET', '/kevin1026/announces/{view}', ['Blog\Controllers\Announces\View', 'viewAnnounce']],

	['GET', '/kevin1026/backoffice/', ['Blog\Controllers\Backoffice\Auth', 'login']],
	[['GET', 'POST'], '/kevin1026/backoffice/auth', ['Blog\Controllers\Backoffice\Login', 'signin']],

	['GET', '/kevin1026/backoffice/home/', ['Blog\Controllers\Backoffice\Home', 'show']],
	[['GET', 'POST'], '/kevin1026/xhradmin/', ['Blog\Controllers\Backoffice\Requests', 'route']],
	['POST', '/kevin1026/xhradmin/degrees/submit', ['Blog\Controllers\Backoffice\Alter', 'degrees']],
	['POST', '/kevin1026/xhradmin/degrees/view/', ['Blog\Controllers\Backoffice\Requests', 'viewDegree']],
	['POST', '/kevin1026/xhradmin/degrees/edit/', ['Blog\Controllers\Backoffice\Alter', 'degrees']],
	['POST', '/kevin1026/xhradmin/degrees/delete/', ['Blog\Controllers\Backoffice\Alter', 'degrees']],

	['POST', '/kevin1026/xhradmin/interests/submit/', ['Blog\Controllers\Backoffice\Alter', 'interests']],
	['POST', '/kevin1026/xhradmin/interests/view/', ['Blog\Controllers\Backoffice\Requests', 'viewInterest']],
	['POST', '/kevin1026/xhradmin/interests/edit/', ['Blog\Controllers\Backoffice\Alter', 'interests']],
	['POST', '/kevin1026/xhradmin/interests/deletePicture/', ['Blog\Controllers\Backoffice\Alter', 'interests']],
	['POST', '/kevin1026/xhradmin/interests/delete/', ['Blog\Controllers\Backoffice\Alter', 'interests']],

	['GET', '/kevin1026/blog/writer/new/', ['Blog\Controllers\Posts\Writer', 'newPost']],
	['POST', '/kevin1026/blog/writer/submit/', ['Blog\Controllers\Posts\Writer', 'submit']],
	['GET', '/kevin1026/blog/writer/edit/{id}', ['Blog\Controllers\Posts\Writer', 'edit']],
	['POST', '/kevin1026/blog/writer/update/', ['Blog\Controllers\Posts\Writer', 'updatePost']],
	['POST', '/kevin1026/xhradmin/writer/check/', ['Blog\Controllers\Posts\Checks', 'checkWriterData']],

	['POST', '/kevin1026/checks/checkUser/', ['Blog\Controllers\Checks', 'checkUser']],
];
