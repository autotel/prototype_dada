<?php
//DADA editor index page
	/*
	Sources:
		UserPie Version: 1.0
		http://userpie.com


	*/
	require_once("../models/config.php");


?>
<head>
	<style>
	#content{
		width:100%;
	}
	#liveCanvas{
		width:100%;
		background-color:gray;
		position:relative;
	}
	#liveCanvas>#mainimage{
		width:100%;
		pointer-events:none;
		position:absolute;
	}
	#liveCanvas>.zone,#zonePreview{
		position:absolute;
	}
	#liveCanvas>.zone{
		background-color: transparent;
		transition: background-color 0.5s;
	}
	#liveCanvas>.zone:hover{
		background-color:rgba(0,0,0,0.2);
		cursor:pointer;
		transition: background-color 0.5s;
	}
	#liveCanvas>.selected{
		background-color:transparent;
		border:solid 1px red;
		border-left:solid 7px;
		margin-left: -7px;
		color:red;
		cursor:pointer;
		transition:border color background-color0.5s;
	}

	#toolbox{
		position:fixed;
		left:0px;
		top:100px;
		height:100%;
		width:100px;
		background-color: gray;
	}
	#zonePreview{
		pointer-events:none;
	}
	.css_field{
		width:40px;
		display:block;
	}
	</style>
	<script src="http://autotel.co/wp-content/uploads/2015/11/pixi.min_.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $websiteName; ?> Editor</title>
<?php require_once("../head_inc.php"); ?>


</head>
<body>
<?php require_once("../navbar.php"); ?>
<div id="content">
	<div id="liveCanvas">

		<?php
		if(isset($_GET['f'])){
			$pagedisplay=$_GET['f'];
		}else{
			$pagedisplay="core/index";
		}
		echo "<!--";
		$load=file_get_contents('../webcontents/'.$pagedisplay."/post.txt");
		echo "-->";
		echo $load;

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
