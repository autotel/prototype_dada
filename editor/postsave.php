<?php
//DADA editor file saving module
//this is a provisional file saving method; should be DB based instead of file
	/*
	Sources:
		UserPie Version: 1.0
		http://userpie.com
	*/
	require_once("../models/config.php");

	if (!isset($loggedInUser)){
		header('Location: login.php');
		exit();
	}
$hand=fopen('../webcontents/'.str_replace(" ","-", $loggedInUser->display_username)."/".$_GET['post']."/post.txt","w");
if($hand){

  $_GET["content"]=preg_replace('/<!--[\W\w]*?-->/',"",$_GET["content"]);
  fwrite($hand,$_GET["content"]);
  fclose($hand);
}else{
  echo("couldnt fopen post file");
}
//print_r($_GET);
?>
