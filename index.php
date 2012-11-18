<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

require 'config.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'page-1';

$m = new markdown();

$file = 'pages/' . $page . '.md';

if (!file_exists($file)) {
    header('HTTP/1.0 404 Not Found');
    $file = 'pages/404.md';
}

if (!is_cached($file)) {
	ob_start();
	// read the first line
	$f = fopen($file, 'r');
	$first = true;
	while (!feof ($f)) {
		if($first){
			$source = fgets($f);
			$title = trim($source);
			$first = false;
		} else {
			$source .= fgets($f);
		}
	}
	fclose($f);

	// if the title is not Suzuki T500 Cobra MK I Rebuild, append it to the title
	if ($title != 'Suzuki T500 Cobra MK I Rebuild') {
	    $title = $title . ' | Suzuki T500 Cobra MK I Rebuild';
	}
	// end of modifications

	$body = $m->transform($source);

	//the header source
	include 'templates/header.php';

	//the converted markdown
	echo $body;

	//the footer source (has the source rollup in it)
	include 'templates/footer.php';
	$data = ob_get_flush();
	cache_file($file, $data);
}