<?php
/*
zone types:
  image
  link
  video
  custom
*/
//error_reporting(E_ALL);
//function to open a post content file
function loadZones($file){
  echo "loading file\n";
  $j = file_get_contents($file);
  print_r($j);
  echo(bakeZoneJson($j));

}
function saveZones($file){
  echo "saving file\n";
}
//function to create HTML out of the Json that determine the post content
function bakeZoneJson($json){
  $awrapping='
  <a href="{href}">
    {divwrapping}
  </a>';
  $divwrapping='<div style="left:{left}; top:{top}; width:{width}; height:{height};" class="zone {classes}" data-index="{id}" id="zone{id}">{innerContent}</div>';
  $ret="";
  $data=  json_decode ($json);
  print_r ($data);
  $i=$data->img;
  //echo $i;
  $ret.='
  <div id="post">';
  $ret.='
  <img id="mainImage" src="'.$i.'">';
  foreach($data->zones as $itm){
    $divwrapped=preg_replace_callback('({([\W\w]*?)})',function ($matches) use ($itm) {
      if(property_exists($itm,$matches[1])){
        return ($itm->$matches[1]);
      }else{
        return "";
      }
    },$divwrapping);
    $awrapped=preg_replace_callback('({([\W\w]*?)})',function ($matches) use ($itm,$divwrapped) {
      if($matches[0]=="{divwrapping}"){
        return $divwrapped;
      }else if(property_exists($itm,$matches[1])){
        return ($itm->$matches[1]);
      }else{
        return "";
      }
    },$awrapping);
    $ret.=$awrapped;
  }

  return $ret;
}
loadZones("testjson.json");


?>
