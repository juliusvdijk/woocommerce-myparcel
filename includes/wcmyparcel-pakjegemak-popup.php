<?php
// embed myparcel pakjegemak site locally
$hash = $_REQUEST['hash'];
$webshop = $_REQUEST['webshop'];
$username = $_REQUEST['user'];
$context = isset($_REQUEST['is_ssl']) ? 'https' : 'http';

$myparcel_url = sprintf('%s://www.myparcel.nl', $context);
$pakjegemak_url = $myparcel_url.'/pakjegemak-locatie';

// create POST string
$post = implode('&', array(
	'hash=' . $hash,
	'webshop=' . $webshop,
	'user=' . $username,
));	

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $pakjegemak_url );
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
$result = curl_exec($ch);
curl_close ($ch);

// convert relative urls to absolute
$result = str_replace('<link href="/css/', '<link href="'.$myparcel_url.'/css/', $result);
$result = str_replace('<link href="/images/', '<link href="'.$myparcel_url.'/images/', $result);
$result = str_replace('<script type="text/javascript" src="/js/', '<script type="text/javascript" src="'.$myparcel_url.'/js/', $result);

die($result);