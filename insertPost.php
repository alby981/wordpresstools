<?php
require('./wp-load.php');
$author_id = 1;
//array with parent ID page
$aParent = ["telefonia" => 15,"aerei" => 22,"auto"=>19,"moda"=>735];
//use file?
$file = file("auto.txt");
//use array?
$file = ['Chanel','Dior','Dolce & Gabbana','Gucci','Versace','Yves Saint Laurent','Armani','Louis Vuitton','Moschino','Fiorucci','Lacoste','Valentino'];
foreach ($file as $title) {
	$slug = sanitize_title($title);
	if(empty($slug))
		continue;
	$post_id = wp_insert_post(
		[
			'comment_status'	=>	'closed',
			'ping_status'		=>	'closed',
			'post_author'		=>	$author_id,
			'post_name'		    =>	$slug,
			'post_title'		=>	$title,
			'post_status'		=>	'publish',
			'post_type'		    =>	'page',
			'post_parent'		=>	$aParent["moda"]
		]
	);
}
