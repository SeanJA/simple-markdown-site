<?php

require 'classes/markdown.php';

$google_analytics_id = '';

function is_cached($file){

	$cache = '.page-cache/'.sha1($file);
	
	if(file_exists($cache)){
		if(filemtime($file) < filemtime($cache)){
			header('X-PAGE-CACHE: '.(time() - filemtime($cache)));
			include $cache;
			return true;
		}
	}
	return false;
	
}

function cache_file($file, $data){
	$file = '.page-cache/'.sha1($file);
	file_put_contents($file, compress($data));
}

function compress($data){
	$search = array(
		'/\n/',			// replace end of line by a space
		'/\>[^\S ]+/s',		// strip whitespaces after tags, except space
		'/[^\S ]+\</s',		// strip whitespaces before tags, except space
		'/(\s)+/s'		// shorten multiple whitespace sequences
	);

	$replace = array(
		' ',
		'>',
		'<',
		'\\1'
	);

	$data = preg_replace($search, $replace, $data);
	return $data;
}