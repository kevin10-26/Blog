<?php declare(strict_types=1);

namespace Blog\Utilities\Backoffice;

use Blog\Repository\DbControl;

class AdminModel extends DbControl
{
	public function get()
	{
		return json_decode(file_get_contents('http://' . $_SERVER['SERVER_NAME'] . '/kevin1026/src/files/admin_data.json'), true);
	}

	public function getDegreeData($degree)
	{
		return json_decode(file_get_contents('http://' . $_SERVER['SERVER_NAME'] . '/kevin1026/src/files/achievements.json'), true)[$degree];
	}

	public function getInterestData($interest)
	{
		return json_decode(file_get_contents('./../src/files/interests.json'), true)[$interest];
	}

	public function deleteInterestPicture($data)
	{
		if (file_exists('./img/misc/about/interests/' . $data['key'] . '/' . $data['name'])) {
			unlink('./img/misc/about/interests/' . $data['key'] . '/' . $data['name']);
			$base = json_decode(file_get_contents('http://' . $_SERVER['SERVER_NAME'] . '/kevin1026/src/files/interests.json'), true);

		//	die(var_dump('here', array_search('ihd-2.png', array_column($base['sv']['images'], 'name'))));

			for($i = 0; $i < count($base[$data['key']]['images']); $i++) {

				$key = array_search($data['name'], array_column($base[$data['key']]['images'], 'name'));

			}

			unset($base[$data['key']]['images'][$key]);

			$base[$data['key']]['images'] = array_values($base[$data['key']]['images']);

			#die(var_dump($base[$data['key']]['images']));

			file_put_contents('./../src/files/interests.json', json_encode($base, JSON_PRETTY_PRINT));

			return true;
		} else {
			die(var_dump('here', './img/misc/about/interests/' . $data['key'] . '/' . $data['name']));
			throw new \Exception('Le fichier n\'a pas été trouvé');
		}
	}

	public function newDegree($data)
	{
		$newData = array(
			'title' => $data['title'],
			'finished' => $data['finished'],
			'year' => (!$data['finished']) ? array('start' => $data['year']) : $data['year'],
			'structure' => $data['structure']
		);
		$base = json_decode(file_get_contents('http://' . $_SERVER['SERVER_NAME'] . '/kevin1026/src/files/achievements.json'), true);
		
		$newData = array_merge($base, array($data['title'] => $newData));

		# var_dump(scandir('./../src/files/'));	
		file_put_contents('./../src/files/achievements.json', json_encode($newData, JSON_PRETTY_PRINT));
		return true;
		
	}

	public function editDegree($data)
	{
		$newData = array(
			'title' => $data['title'],
			'finished' => $data['finished'],
			'year' => (!$data['finished']) ? array('start' => $data['year']) : $data['year'],
			'structure' => $data['structure']
		);
		$base = json_decode(file_get_contents('http://' . $_SERVER['SERVER_NAME'] . '/kevin1026/src/files/achievements.json'), true);

		$base[$data['base-title']] = $newData;

		file_put_contents('./../src/files/achievements.json', json_encode($base, JSON_PRETTY_PRINT));
		return true;

	}

	public function deleteDegree($data)
	{
		$base = json_decode(file_get_contents('./../src/files/achievements.json'), true);
		unset($base[$data['key']]);

		file_put_contents('./../src/files/achievements.json', json_encode($base, JSON_PRETTY_PRINT));
		return true;
	}

	public function newInterest($data, $pictures)
	{
		$pictureNames = array();
		for ($i = 0; $i < count($pictures['pictures']['name']); $i++)
		{
			$pictureNames[$i] = array(
				'name' => $pictures['pictures']['name'][$i],
				'alt' => 'Image : ' . $pictures['pictures']['name'][$i]
			);
		}

		$newData = array(
			'title' => $data['title'],
			'key_title' => $data['key-title'],
			'achievements' => $data['achievements'],
			'images' => $pictureNames,
			'description' => $data['description'],
			'content' => $data['content']
		);
		$base = json_decode(file_get_contents('http://' . $_SERVER['SERVER_NAME'] . '/kevin1026/src/files/interests.json'), true);
		
		$newData = array_merge($base, array($data['key-title'] => $newData));
	
		$this->uploadPicture($pictures, $data['key-title']);
	
		file_put_contents('./../src/files/interests.json', json_encode($newData, JSON_PRETTY_PRINT));
		return true;
	}

	public function editInterest($data, $pictures)
	{
		if (!empty($pictures['pictures']['name'][0])) {

			$pictureNames = array();

			for ($i = 0; $i < count($pictures['pictures']['name']); $i++)
			{
				$pictureNames[$i] = array(
					'name' => $pictures['pictures']['name'][$i],
					'alt' => 'Image : ' . $pictures['pictures']['name'][$i]
				);
			}

			$this->uploadPicture($pictures, $data['key']);
		}
	
		$base = json_decode(file_get_contents('http://' . $_SERVER['SERVER_NAME'] . '/kevin1026/src/files/interests.json'), true);

		$newData = array(
			'title' => $data['title'],
			'key_title' => $data['key'],
			'achievements' => trim($data['achievements']),
			'images' => (isset($pictureNames)) ? array_merge($base[$data['key']]['images'], $pictureNames) : $base[$data['key']]['images'],
			'description' => $data['description'],
			'content' => $data['content']
		);

		$base[$data['key']] = $newData;

	//	die(var_dump($pictures['pictures']['name'][0]));

		file_put_contents('./../src/files/interests.json', json_encode($base, JSON_PRETTY_PRINT));
		return true;


	}

	public function deleteInterest($data)
	{
		// First : delete entries from interests.json
		// Second : delete interests picture dir
		
		$base = json_decode(file_get_contents('./../src/files/interests.json'), true);

		unset($base[$data['key']]);

		file_put_contents('./../src/files/interests.json', json_encode($base, JSON_PRETTY_PRINT));

		// Second now
		// Empty folder, to use rmdir then
		array_map('unlink', glob('./img/misc/about/interests/' . $data['key'] . '/*.*'));
		rmdir('./img/misc/about/interests/' . $data['key'] . '/');
	}

	public function uploadPicture($pictures, $dirTitle)
	{
		# Recreating the array, because the http FILES are not in a convenient order.
		$data = [];
		foreach ($pictures['pictures'] as $k => $v)
		{
			for ($i = 0; $i < count($pictures['pictures'][$k]); $i++) {

				$data[$i][$k] = $pictures['pictures'][$k][$i];
			}
		}

		$allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png", "webp" => "image/webp");


		if (!is_dir('./img/misc/about/interests/' . $dirTitle. '/')) {
			mkdir('./img/misc/about/interests/' . $dirTitle. '/');
		}

		// die(var_dump($dirTitle));

		for ($i = 0; $i < count($data); $i++) {

		    $filename = $data[$i]["name"];
		    $ext = pathinfo($filename, PATHINFO_EXTENSION);

		    $beforeExt = strstr($filename, '.'.$ext, true);
		    $realfn = "";
		    $filetype = $data[$i]["type"];
		    $filesize = $data[$i]["size"];


		    $ext = pathinfo($filename, PATHINFO_EXTENSION);
		    // die(var_dump($ext, $allowed, $filename));
		    if(!array_key_exists($ext, $allowed)) die("Erreur : Veuillez sélectionner un format de fichier valide.".$beforeExt);

	        
	        $maxsize = 5 * 1024 * 1024;
	        if($filesize > $maxsize) die("Error: La taille du fichier est supérieure à la limite autorisée.");
	        
	        if(in_array($filetype, $allowed)){
	            
	            if(file_exists("public/img/misc/about/interests/" . $dirTitle . '/' . $filename)){
	            	die("Votre fichier ".$filename." existe déjà :/");
	            } else {

	            	$realfn = $beforeExt.'.'.$ext;
	                move_uploaded_file($data[$i]["tmp_name"], "./img/misc/about/interests/" . $dirTitle . '/' . $realfn);

	            } 
	        } else{
			throw new \Exception("Error: Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer.", 91); 
	        }
	    }
	}
}
