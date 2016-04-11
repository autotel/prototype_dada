<?php
/*
zone types:
  image
  link
  video
  custom
*/
require_once("models/settings.php");
require_once("models/config.php");
require_once("models/funcs.content.php");
//function to open a post content file
function loadZones($file){
  global $db_content_table;
  contents_connect();
  //pendant: check user permissions for the post after loading
  // $currentUser=$loggedInUser->user_id;
  // taskstack_connect();
	$sql = "SELECT *
	FROM `$db_content_table`
	WHERE (url=$file)
	ORDER BY id DESC
	LIMIT 1";
  if(!$result = $content_conn->query($sql)){
  		die('There was an error running the query [' . $content_conn->error . ']');
  }
  $j = file_get_contents($file);
  return(bakeZoneJson($result->fetch_assoc()['content']));
}

//function to create HTML out of the Json that determine the post content
function bakeZoneJson($json){
  $awrapping='
  <a href="{href}">
    {divwrapping}
  </a>';
  $divwrapping='<div style="left:{left}; top:{top}; width:{width}; height:{height};" {extraData} class="zone {classes}" data-index="{id}" id="zone{id}">{addedContent}{innerContent}</div>';
  $ret="";
  $data=  json_decode ($json);
  $i=$data->img;
  //echo $i;
  $ret.='
  <img id="mainimage" src="'.$i.'">';
  foreach($data->zones as $itm){
    if($itm->type=="link"&&property_exists($itm,"href")){
      $itm->addedContent='<a class="zonelink" href="'.$itm->href.'"></a>';
      $itm->extraData='data-href="'.$itm->href.'"';
    }
    $divwrapped=preg_replace_callback('({([\W\w]*?)})',function ($matches) use ($itm) {
      if(property_exists($itm,$matches[1])){
        return ($itm->$matches[1]);
      }else{
        return "";
      }
    },$divwrapping);
    // $awrapped=preg_replace_callback('({([\W\w]*?)})',function ($matches) use ($itm,$divwrapped) {
    //   if($matches[0]=="{divwrapping}"){
    //     return $divwrapped;
    //   }else if(property_exists($itm,$matches[1])){
    //     return ($itm->$matches[1]);
    //   }else{
    //     return "";
    //   }
    // },$awrapping);
    $ret.=$divwrapped;
  }

  return $ret;
}

?>
