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
function loadZones($url){
  // echo $url;
  $j = getUrlContent($url);
  return(bakeZoneJson($j['content']));
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
  echo("<!--");
  print_r($data);
  print_r($json);
  echo("-->");
  $i=$data->img;
  //echo $i;
  $ret.='
  <img id="mainimage" src="'.$i.'">';
  if(property_exists($data,"zones")){
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
      $ret.=$divwrapped;
    }
  }
  return $ret;
}

?>
