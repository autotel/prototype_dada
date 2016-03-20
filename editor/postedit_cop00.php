<?php
//DADA editor index page
	/*
	Sources:
		UserPie Version: 1.0
		http://userpie.com


	*/
	require_once("../models/config.php");

	/*
	* Uncomment the "else" clause below if e.g. userpie is not at the root of your site.
	*/
	if (!isset($loggedInUser)){
		header('Location: login.php');
	// else
	// 	header('Location: /');
		exit();
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<style>
	#editorCanvas{
		width:800px;
		background-color:gray;
		position:relative;
	}
	#editorCanvas>#mainimage{
		width:100%;
		pointer-events:none;
		position:absolute;
	}
	#editorCanvas>.zone,#zonePreview{
		border: solid 1px;

		margin:-1px;
		position:absolute;
		z-index:2;
		transition: color border 0.5s;
	}
	#editorCanvas>.zone{
		border-left:solid 7px;
		margin-left: -7px;
	}
	#editorCanvas>.zone:hover{
		background-color:rgba(0,0,0,0.2);
		cursor:pointer;
		transition: border color background-color 0.5s;
	}
	#editorCanvas>.selected{
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
	</style>
	<script src="http://autotel.co/wp-content/uploads/2015/11/pixi.min_.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $websiteName; ?> Editor</title>
<?php require_once("../head_inc.php"); ?>


</head>
<body>
<?php require_once("../navbar.php"); ?>
	<div id="content">
<h1>Post editor page</h1>
<div id="toolbox">
	<span id="coords"></span>
	<div class="tool" data-tool="select">select zone</div>
	<div class="tool" data-tool="zone">create zone</div>
	<div id="selectedoptions"></div>
</div>
<div id="editorCanvas">
	<img id="mainimage" src="<?php echo 'webcontents/'.str_replace(" ","-", $loggedInUser->display_username)."/".$_GET['post'] ?>/index.jpg">
</div>

	</div>



</body>
<script>
var mouse={x:0,y:0,sx:0,sy:0,ex:0,ey:0}
function updateToolbox(){};
function drawZones(){};
var zones=[];
var stage;
var renderer;
var graphics;
var tool="zone";
pixiInit=function(){}
	graphics = new PIXI.Graphics();
	//graphics.blendMode = PIXI.BLEND_MODES.ADD;
	// Autodetect, create and append the renderer to the body element
	renderer = PIXI.autoDetectRenderer(800, 600, { transparent: true, antialias: true });
	document.getElementById('editorCanvas').appendChild(renderer.view).setAttribute("id", "canvasPixi");

	// Create the main stage for your display objects
	stage = new PIXI.Container();

	// ...
	// The rest of the code will go here
	// ...

	// Start animating
	animate();
	function animate() {
			//Render the stage
			renderer.render(stage);
			requestAnimationFrame(animate);
	}

//}
$(document).ready(function(){
	pixiInit();
	updateToolbox=function (){
		$("#toolbox > #coords").html("x:"+mouse.x+" y:"+mouse.y);
	}
	drawZones=function(list){
		for(itm in list){
			addzone({sx:list[itm].sx,sy:list[itm].sy,ex:list[itm].ex,ey:list[itm].ey});
		}
	}
	addZone=function(m){
		itm=zones.push({sx:m.sx,sy:m.sy,ex:m.ex,ey:m.ey})-1;
		zones[itm].sprite=$("#editorCanvas").append('<div class="zone" data-index="'+itm+'" id=d'+itm+'>Z-'+itm+'</div>');
		reappend();
		$('#d'+itm+'').css({left:zones[itm].sx+"px",top:zones[itm].sy+"px",width:zones[itm].ex-zones[itm].sx+"px",height:zones[itm].ey-zones[itm].sy+"px"})
	}
	var zp=$("#editorCanvas").append('<div class="" id="zonePreview"></div>');
	zp=$("#zonePreview");
	zp.css({opacity:0});
	$(".tool").on("click",function(){
		tool=$(this).attr("data-tool");
		console.log("tool now is "+tool);
	});
	$("#editorCanvas").on("mousemove",function(e){
		//console.log(e);
		//all this should just be percentages
		mouse.x=e.offsetX;
		mouse.y=e.offsetY;
		if(tool=="zone"){
			$(".zone").css({"pointer-events":"none"});
			mouse.ex=mouse.x;
			mouse.ey=mouse.y;

			zp.css({left:mouse.sx+"px",top:mouse.sy+"px",width:mouse.ex-mouse.sx+"px",height:mouse.ey-mouse.sy+"px"});
		}else{
			$(".zone").css({"pointer-events":""});
		}
		updateToolbox();
	}).on("mousedown",function(){
		//zones affect the ofset mouse coors
		if(tool=="zone"){
			$(".zone").css({"pointer-events":"none"});
			mouse.sx=mouse.x;
			mouse.sy=mouse.y;
			zp.css({left:mouse.sx+"px",top:mouse.sy+"px"});
			zp.animate({opacity:1});
			console.log(zones);
		}
	}).on("mouseup",function(){
		if(tool=="zone"){
			mouse.ex=mouse.x;
			mouse.ey=mouse.y;
			zp.css({opacity:0});
			addZone(mouse);
			$(".zone").css({"pointer-events":""});
		}
	});
	reappend = function(){
		$(".zone").each(function(){
			if($(this).data("appended")!="true"){
					$(this).on("mousedown",function(e){
						if(tool=="select"){
							console.log("sel zone"+$(this).data("index"));
							$(".zone").removeClass("selected");
							$(this).addClass("selected");
							$("#selectedoptions").html('<textarea>+$(this).css()+</textarea>,<textarea id="htmledit">'+$(this).html()+'</textarea>');
							var pare=$(this);
							$("#htmledit").on("input change blur",function(){
								$(".selected").html($("#htmledit").val());
							})
						}
					}).on("mouseup",function(e){
				});
				$(this).data("appended","true");
			}
		});
	}
});

</script>
</html>
