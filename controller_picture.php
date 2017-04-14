<?php
/**
 * Template Name: Picture controller
 * Description: Outputs the picture source as JSON
 *
 */
require_once('simple_html_dom.php');
require_once('url_to_absolute.php');
$return_msg=array();
//for security reasons the webscrapper should verify if
//the page to be scraped is the one picture should be scraped from 
const HOST_NAME = ''; //e.g google.com not https://www.google.com
if($_SERVER["REQUEST_METHOD"]=="POST") {
	$url = $_POST["url"];
	$parse = parse_url($url);
	if($parse["host"]==HOST_NAME){
		$html = file_get_html($url);
		$return_msg["src"]=array();
		foreach($html->find('img') as $element){
		//turns the sometimes relative sources of pictures into absolute urls
    	$absolute_url=url_to_absolute($url, $element->src);
		//pushes the absolute url of all images on the website into an array of sources
		array_push($return_msg["src"], $absolute_url);
		}
	} else {
	$return_msg["error"]="wrong domain";
	}
	
} else {
die();
}
header("Content-type: application/json");
print(json_encode($return_msg, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));