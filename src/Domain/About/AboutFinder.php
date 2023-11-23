<?php declare(strict_types=1);

namespace Blog\Domain\About;

class AboutFinder
{
	public function getDegrees()
	{
		return json_decode(file_get_contents('http://' . $_SERVER['SERVER_NAME'] . '/kevin1026/src/files/achievements.json'), true);
	}

	public function getInterests()
	{
		return json_decode(file_get_contents('http://' . $_SERVER['SERVER_NAME'] . '/kevin1026/src/files/interests.json'), true);
	}
}
