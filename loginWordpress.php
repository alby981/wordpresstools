<?php
$aCredentials = [
	'https://www.<domain>.com/<login page>' => [
		'user' => 'pass'
	],
];

function curl_get_wp_login( $login_user, $login_pass, $login_url, $visit_url, $http_agent, $cookie_file ){
	if (!function_exists( 'curl_init' ) || ! function_exists( 'curl_exec' )) {
		die("cUrl is not available");
	}

	$data = "log=". $login_user ."&pwd=" . $login_pass . "&wp-submit=Anmelden&redirect_to=" . $visit_url;

	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, $login_url );
	curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookie_file );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch, CURLOPT_USERAGENT, $http_agent );
	curl_setopt( $ch, CURLOPT_TIMEOUT, 60 );
	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt( $ch, CURLOPT_REFERER, $login_url );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
	curl_setopt( $ch, CURLOPT_POST, 1);
	$content = curl_exec ($ch);
	curl_close( $ch );
	echo $content;
}


foreach($aCredentials as $key => $credentials) {
	$login_url = $key;
	$domain = $key;
	$domain = parse_url($domain);
	$scheme = $domain['scheme'];
	$host = $domain['host'];
	$domain = $scheme . '://' . $host;
	
	$domainMd5 = md5($domain);
	foreach($credentials as $user => $pass) {
		
		$login_user = $user;
		$login_pass = $pass;
		$visit_url =  "$domain/wp-admin/admin.php?page=<page>";
		$cookie_file = $domainMd5 . "cookie.txt";
		$http_agent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6";
		curl_get_wp_login( $login_user, $login_pass, $login_url, $visit_url, $http_agent, $cookie_file );
	}
}
