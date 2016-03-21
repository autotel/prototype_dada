<?php


require_once("../zoneParser.php");
require_once("../models/config.php");




//open a post by using username and postname
function getUserPost($user,$post){
  return loadZones('../webcontents/'.str_replace(" ","-", $user).'/'.$post."/post.json");
}
function getMyPost($post){
  global $loggedInUser;
  if (!isset($loggedInUser)){
		echo "loggedin user undefined";
	}
  return getPostByUrl('../webcontents/'.str_replace(" ","-", $loggedInUser->display_username).'/'.$post."/post.json");
}
//open a post by using post name
function getCorePost($page){
  $load= loadZones('../webcontents/'.$page."/post.json");
  return $load;
}

function getPostByUrl($url){
  $load=loadZones('../webcontents/'.$url."/post.json");
  if($load){
		return $load;
	}else{
    echo "<!-- this is a new post -->";
		return'<img id="mainimage" src="webcontents/'.$url.'/index.jpg">';
	}
  return $load;
}

?>
