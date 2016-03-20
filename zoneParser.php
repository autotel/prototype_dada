<?php
/*
zone types:
  image
  link
  video
  custom
*/

//function to open a post content file
function loadZones($file){
  //echo "loading file\n";
  $j = file_get_contents($file);
  if($j){
    //echo "hik".$j;
    return(bakeZoneJson($j));
  }else{
    return false;
  }
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
