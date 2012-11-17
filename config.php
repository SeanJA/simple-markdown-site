<?php

require 'classes/markdown.php';

function is_cached($file){
	$file = '.cache/'.sha1($file);
	if(!file_exists($file) || time() - filemtime($file) < 3600){
		return false;
	}
	return file_get_contents($file);
}

function cache_file($file, $data){
	$file = '.cache/'.sha1($file);
	file_put_contents($file, $data);
}