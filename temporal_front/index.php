
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head
         content must come *after* these tags -->
    <title>Dada</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="js/masonry.pkgd.min.js"></script>
    <script src="js/jquery.scrollNav.min.js"></script>
    <script src="js/jquery.superCss.js"></script>
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <style>
    .jumbotron{
      width:100%;
      text-align: center;
      background-color: transparent;
    }
    .imageItem{
      position:relative;
      width:120px;
      display:inline-block;
      margin:10px;
    }
    .imageItemImage{
      width:100%;
    }
    .imageTitle{
      position:absolute;
      opacity:0;
    }
    .fill{
      max-width: 100%;
    }
    #sidebar-wrapper{
      position:fixed;
      z-index: 3;
      background-image: linear-gradient(90deg,#fff,transparent);
      height:100%;
      transition: 0.4s;
      width:140px;
      left:-100px;
    }
    #sidebar-wrapper:hover{
      left:0;
      transition: 0.4s;
    }
    #sidebar-wrapper ol,#sidebar-wrapper li {
      list-style-type: none;
      list-style-position:inside;
      margin:0;
      padding:0;
    }
    #sidebar-wrapper li.active{/*in-view*/
      background-color: #CCC;
    }
    h1,h2,h3{
      color:#ef094a;
    }
    </style>
</head>
<body>
  <div id="sidebar-wrapper">
  </div>

  </div>
  <div class="jumbotron fill" style="z-index:5">
    <a name="home"></a>
    <img src="contents/dadaheader.png" class="fill" >
  </div>
  <div class="container">
    <div class="itemContainer" name="images">
    <?php
    $contents=json_decode(file_get_contents("contents.json"),true);
    foreach ($contents as $key => $content) {
      $end="";
      if($key=="parallaxImages"){
        // echo '<h1>'.$key.'</h1>';
        foreach ($content as $subkey => $item) {
          echo '<div class="item imageItem"><div data-z="'.(rand(-7,2)).'">';
          echo '<h2 class="imageTitle">'.$item['name'].'</h2>';
          if(array_key_exists('link',$item)){
            echo  '<a href="'.$item['link'].'">';
            $end.="</a>";
          }
          echo '<img class="imageItemImage" src="'.$item['src'].'">';
          echo $end;
          echo '</div></div>';
        }
      }
    }
    ?>
  </div>
    <?php
    foreach ($contents as $key => $content) {
      if($key=="textContents"){
        // echo '<h1>'.$key.'</h1>';
        foreach ($content as $subkey => $item) {
          echo '<div class="section" name="'.$item['name'].'"><h2>'.$item['name'].'</h2></div>';
          echo file_get_contents($item['contents']);
        }
      }
    }
    ?>
  </div>
  <script>
  $(document).ready(function(){
    var msnry = new Masonry( '.itemContainer');
    $('body').scrollNav({
      sections: '.section',
      subSections: false,
      sectionElem: 'div',
      showHeadline: false,
      showTopLink: true,
      topLinkText: 'Top',
      fixedMargin: 40,
      scrollOffset: 40,
      animated: true,
      speed: 500,
      insertTarget: "#sidebar-wrapper",
      insertLocation: 'appendTo',
      arrowKeys: false,
      scrollToHash: true,
      onInit: null,
      onRender: null,
      onDestroy: null
    });
    $(".scroll-nav").addClass("scss-vcenter");
    $(".imageItem>div").each(function(){
      $(this).parent().css("height",$(this).find("img").height());
    });
    $(window).on("scroll",function(event){
      $(".imageItem>div").each(function(){
        var postop=$(document).scrollTop()*parseFloat($(this).attr("data-z"))*0.1;
        // console.log(postop);
        $(this).css({position:"absolute","margin-top":postop+"px"});
      });
    })
  });
  </script>
</body>