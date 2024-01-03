<?php declare(strict_types=1);

namespace Blog\Domain\Posts;

use Blog\Repository\DbControl;
use Blog\Domain\Posts\PostsFinder;

class Uploader extends DbControl
{
	public function submit($data, $thumbnail)
	{
		if ($this->checkExisting($data['title'])) {
			throw new \Exception('Cette publication existe déjà');
			exit();
		}
		$db = new DbControl();	
		
		$data['content'] = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $data['content']);	
		$fields = array_slice($data, 3);
		$stmt = $db->insert('posts', $fields);
		$this->addThumbnail($thumbnail['thumbnail'], $stmt);

		return true;
	}

	public function edit($data, $thumbnail)
	{
		$db = new DbControl();
		$finder = new PostsFinder();
			
		$data['content'] = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $data['content']);
	
		$fields = array_slice($data, 4);
		$formerPost = $finder->getPostByTitle($data['base-title']);

		$wCond = array(
			'cond' => 'id',
			'value' => $formerPost[0]['id']
		);

		$db->update($fields, 'posts', $wCond, false);
		
		if (!empty($thumbnail['thumbnail']['name'])) {
			$this->modifyThumbnail($thumbnail['thumbnail'], $formerPost[0]['thumbnail'], $formerPost[0]['id']);
		}
		
		return true;

	}

	public function addThumbnail($picture, $id)
	{
		# Recreating the array, because the http FILES are not in a convenient order.		
		$allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png", "webp" => "image/webp");

		$filename = $picture["name"];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);

		$beforeExt = strstr($filename, '.'.$ext, true);
		$realfn = "";
		$filetype = $picture["type"];
		$filesize = $picture["size"];


		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		// die(var_dump($ext, $allowed, $filename));
		if(!array_key_exists($ext, $allowed)) die("Erreur : Veuillez sélectionner un format de fichier valide.".$beforeExt);

	        
	        $maxsize = 5 * 1024 * 1024;
	        if($filesize > $maxsize) die("Error: La taille du fichier est supérieure à la limite autorisée.");
	        
	        if(in_array($filetype, $allowed)){
	            
	            if(file_exists("./img/blog/thumbnails/" . $filename)){
	            	die("Votre fichier ".$filename." existe déjà :/");
		    } else {
	            	$realfn = $beforeExt.'.'.$ext;
			move_uploaded_file($picture["tmp_name"], "./img/blog/thumbnails/" . $realfn);
			$db = new DbControl();
			$values = array(
				'thumbnail' => $realfn
			);
			$wCond = array(
				'cond' => 'id',
				'value' => $id
			);

			$db->update($values, 'posts', $wCond, true);
		    }
		}
	}
	
	// Delete the old thumbnail, and replace it with the new one.
	public function	modifyThumbnail($picture, $oldPicture, $id)
	{
		if (file_exists('./img/blog/thumbnails/' . $oldPicture)) unlink('./img/blog/thumbnails/' . $oldPicture);

		$this->addThumbnail($picture, $id);
	}
	
	// Check if another post with the same title exist.
	// If this is the case, cancel the operation
	private function checkExisting($title)
	{
		$postsFinder = new PostsFinder();

		if (count($postsFinder->getPostByTitle($title)) > 0)
		{
			return true;
		}
	}

	public function addDomain($data)
	{
		$db = new DbControl();
		$postsFinder = new PostsFinder();

		$values = $postsFinder->getDomains();

		if(in_array($data, $values)) return;
		
		array_push($values, $data);
		$values = array_map(function($value) { return '"'.$value.'"'; }, $values);
		$values = implode(', ', $values);

		$db->alter('posts', 'domain', $values, 'enum');

		return true;
		
	}

	public function addCategory($data)
	{
		$db = new DbControl();
		$postsFinder = new PostsFinder();

		$values = $postsFinder->getCategories();

		if(in_array($data, $values)) return;
		
		array_push($values, $data);
		$values = array_map(function($value) { return '"'.$value.'"'; }, $values);
		$values = implode(', ', $values);

		$db->alter('posts', 'category', $values, 'enum');

		return true;	
	}

}
