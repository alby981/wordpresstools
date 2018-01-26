<?php
/**
 * Author: Alberto Belotti
 * Purpose: Insert into a WP database a post with a youtube video
 * content. I use an array with YouTubeID as a key and title as a value.
 * In the future i will use a separate table for sure and a fancy 
 * object. 
 * 
 * This file must be in the WP root of the project. eg. /var/www/wp/
 * This can be executed only in command line interface. 
 * 
 * Sorry if is not indented properly and not using PSR standards. 
 * I used geany and i did this in 10 minutes. So please if you use 
 * Netbeans ALT + SHIFT + F for the right indentation. 
 * 
 */ 
if (php_sapi_name() != "cli") {
	return;
}
require(dirname(__FILE__) . '/wp-load.php');

// Without this line you can't insert an iframe into WP posts
kses_remove_filters();


// In nearest future i will use a DB table. 
$aVideos = [
	'h7tokK_B4B4' => [
		'title' => "Rimozione di un punto nero enorme con la pinzetta!",
	]
];

// In the future i will have more than one setting
$settings = [];
$settings['featuredIMG'] = true;

foreach($aVideos as $key => $aVideo) {
	$title = $aVideo['title'];
	$content = '<div class="rwd-video">
		<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$key.'" frameborder="0" allowfullscreen></iframe>
	</div>';
	
	$thumbnailUrlMedium = "https://i.ytimg.com/vi/{$key}/mqdefault.jpg";
	$my_post = array();
	$my_post['post_title']    = $title;
	$my_post['post_content']  = $content;
	$my_post['post_status']   = 'publish';
	$my_post['post_author']   = 1;
	$my_post['post_category'] = array(0);
	$postID = wp_insert_post( $my_post );
	
	if ($settings['featuredIMG']) {
		insertFeaturedImg($thumbnailUrlMedium, $postID);	
	}
	usleep(300);
}

/**
 * Insert featured img from an image url and a postID
 * Found on the web and did a little bit of refactoring...
 */ 
function insertFeaturedImg($image_url, $postID) {
    $upload_dir = wp_upload_dir();
    $image_data = file_get_contents($image_url);
    $imageUrlExp = explode(".",basename($image_url));
    $filename = $imageUrlExp[0] . $postID . "." . $imageUrlExp[1];
    $file = $upload_dir['basedir'] . '/' . $filename;
    if (wp_mkdir_p($upload_dir['path'])) {
		$file = $upload_dir['path'] . '/' . $filename;	
	}
    file_put_contents($file, $image_data);
    $wp_filetype = wp_check_filetype($filename, null );
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name($filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    $attachID = wp_insert_attachment( $attachment, $file, $postID );
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attachData = wp_generate_attachment_metadata( $attachID, $file );
    $res1= wp_update_attachment_metadata( $attachID, $attachData );
    $res2= set_post_thumbnail( $postID, $attachID );
}
