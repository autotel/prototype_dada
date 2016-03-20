<?php
//DADA editor index page
	/*
	Sources:
		UserPie Version: 1.0
		http://userpie.com


	*/
	require_once("../models/config.php");
	if(isset($_GET['f'])){
		$pagedisplay=$_GET['f'];
	}else{
		$pagedisplay="core/index";
	}

?>
<head>
	<style>
	body{
		margin:0;
		padding:0;
		background-image: url("../../webcontents/background.jpg");
	}
	#content{
		width: 87%;
		left: 6%;
		position: absolute;
		top: 40px;
		box-shadow: 0 20px 20px 2px #000000;
	}
	<?php
	include "../generalZoneStyle.css";
	?>
	#liveCanvas>#mainimage{
	  width:100%;
	  pointer-events:none;
	  position:absolute;
	}
	#liveCanvas{
	  width:100%;
	  background-color:gray;
	  position:relative;
	}

	</style>
	<script src="http://autotel.co/wp-content/uploads/2015/11/pixi.min_.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $websiteName.' '.$pagedisplay; ?></title>
<?php require_once("../head_inc.php"); ?>


</head>
<body>
<?php

require_once("../navbar.php");
require_once("../postFileManagement.php");

?>
<div id="content">
	<div id="liveCanvas">
		<?php

		echo getCorePost($pagedisplay);
		?>
	</div>
</div>



</body>
<script>
var itm=0;
var mouse={x:0,y:0,sx:0,sy:0,ex:0,ey:0}
function updateToolbox(){};
function drawZones(){};
function savefile(){};
respond=function(){};
var zones=[];

var tool="zone";
var cvs={width:0,height:0};

$(document).ready(function(){
	respond=function(){
		 cvs.width=$("#liveCanvas>#mainimage").width();
		 cvs.height=$("#liveCanvas>#mainimage").height();
		 $("#liveCanvas").css({height:cvs.height});
	 }
	 respond();
});
$(window).on("load resize",function(){respond()});

</script>
</html>
