<?php
require('./wp-load.php');

//TODO: hardcoded? mmmm
$author_id = 1;
//TODO: needs to get value from wp database. 
$aParent = ["telefonia" => 15,"aerei" => 22,"auto"=>19,"moda"=>735];
$aSettings['source'] = 'file';
$aSettings['parent'] = 'moda';
$aSources = ['file','array'];

//TODO: filename 
$filename = "auto.txt";
if (!in_array($aSettings['source'],$aSources)) {
	die("set data source");
}
if (!in_array($aSettings['parent'],$aParent)) {
	die("set correct parent");
}
switch ($aSettings['source']) {
	case 'file':
		$data = file($filename);
		break;
	case 'array':
		$data = ['Chanel','Dior','Dolce & Gabbana','Gucci','Versace','Yves Saint Laurent','Armani','Louis Vuitton','Moschino','Fiorucci','Lacoste','Valentino'];
		break;
}

foreach ($data as $title) {
	$slug = sanitize_title($title);
	if(empty($slug))
		continue;
	$post_id = wp_insert_post(
		[
			'comment_status'	=>	'closed',
			'ping_status'		=>	'closed',
			'post_author'		=>	$author_id,
			'post_name'		=>	$slug,
			'post_title'		=>	$title,
			'post_status'		=>	'publish',
			'post_type'		=>	'page',
			'post_parent'		=>	$aParent["moda"]
		]
	);
}
