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
  $load=loadZones('../webcontents/'.str_replace(" ","-", $loggedInUser->display_username).'/'.$post."/post.json");
	if($load){
		return $load;
	}else{
    echo "<!-- this is a new post -->";
		return'<img id="mainimage" src="webcontents/'.str_replace(" ","-", $loggedInUser->display_username)."/".$post.'/index.jpg">';
	}
}
//open a post by using post name
function getCorePost($page){
  return loadZones('../webcontents/'.$page."/post.json");
}

function getPostByUrl($url){
  return loadZones('../webcontents/'.$pagedisplay."/post.json");
}

?>
