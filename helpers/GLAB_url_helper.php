<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function controller_path () {
	$CI =& get_instance();
	$segments = $CI->uri->segment_array();
	
	$controllerSegment = 0;
	foreach ($segments as $id=>$segment)
		if ($segment == $CI->router->fetch_class()) $controllerSegment = $id;
	
	foreach ($segments as $id=>$segment)
		if ($id > $controllerSegment) unset($segments[$id]);
		
	$path = implode('/',$segments).'/';
	
	return $path;
}

function controller_url () { 
	$CI =& get_instance();
	$a_ruri = $CI->uri->segment_array();
	
	// Check If Using Query Strings
	if ($CI->input->get('c')) return site_url();
	
	foreach ($a_ruri as $key=>$ruri)
		if (strtolower($ruri) == strtolower($CI->router->fetch_class())) $ruri_key = $key;
	foreach ($a_ruri as $key=>$ruri)
		if ($key > $ruri_key) unset($a_ruri[$key]);
	return rtrim(site_url(),'/').'/'.implode('/',$a_ruri); 

}

function assets_url ($asset_uri=null) {
	
	if (ENVIRONMENT != 'production') {
		$base_url =  'https://glabassets.s3.amazonaws.com/';
	} else {
		if ( isset($_SERVER['HTTPS']) ) $base_url = 'https://dbvnztzf4j5z6.cloudfront.net/';
		else $base_url = 'http://assets.glabstudios.com/';
	}
	
	return $base_url.$asset_uri;
}

// Overrides CI Function
function site_url($uri = '',$secure=FALSE) {
	$CI =& get_instance();
	if ($secure) return "https://".ltrim($CI->config->site_url($uri),'http://');
	else return $CI->config->site_url($uri);
}

function company_url ($uri) {
	if (preg_match("/staging/", $_SERVER['SERVER_NAME'])) return 'http://staging.glabstudios.com/'.$uri;
	else return 'http://glabstudios.com/'.$uri;
}