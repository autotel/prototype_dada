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
		width:70%;
		background-color:gray;
		position:absolute;
		right:0;
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
		z-index: 3;
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
<h1>Post editor page</h1>
<div id="toolbox">
	<span id="coords"></span>
	<div class="toolbox_button tool" data-tool="select">select zone</div>
	<div class="toolbox_button tool" data-tool="zone">create zone</div>
	<div id="savepost" onclick="javascript:savefile()">save post</div>

	<div id="div_options">
		<input id="css_l" type="text" class="css_field"></input>
		<input id="css_t" type="text" class="css_field"></input>
		<input id="css_w" type="text" class="css_field"></input>
		<input id="css_h" type="text" class="css_field"></input>
		<input id="css_rot" type="text" class="css_field"></input>
		<div id="div_remove" class="toolbox_button">remove zone</div>
	</div>
	<div id="selectedoptions">
	</div>
</div>
<div id="editorCanvas">

	<?php
	echo "<!--";
	$load=file_get_contents('../webcontents/'.str_replace(" ","-", $loggedInUser->display_username)."/".$_GET['post']."/post.txt");
	echo "-->";
	if($load){
		echo $load;
	}else{
			echo'<img id="mainimage" src="webcontents/'.str_replace(" ","-", $loggedInUser->display_username)."/".$_GET['post'].'/index.jpg">';
	}
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
var zones=[];
// var stage;
// var renderer;
// var graphics;
var tool="zone";
var cvs={width:0,height:0};

respond=function(){};
pixiInit=function(){};
// graphics = new PIXI.Graphics();
//graphics.blendMode = PIXI.BLEND_MODES.ADD;
// Autodetect, create and append the renderer to the body element
// renderer = PIXI.autoDetectRenderer(800, 0, { transparent: true, antialias: true });
// document.getElementById('editorCanvas').appendChild(renderer.view).setAttribute("id", "canvasPixi");

// Create the main stage for your display objects
// stage = new PIXI.Container();

// ...
// The rest of the code will go here
// ...

// Start animating
animate();
function animate() {
		//Render the stage
		//renderer.render(stage);
		requestAnimationFrame(animate);
}

//}
$(document).ready(function(){
	//append file saving action
	// pixiInit();
	respond=function(){
		 cvs.width=$("#editorCanvas>#mainimage").width();
		 cvs.height=$("#editorCanvas>#mainimage").height();
		 $("#editorCanvas").css({height:cvs.height});
	 }
	respond();
	savefile=function(){
		zoneFileArray={"img":"","zones":[]};
		$(".zone").each(function(){
			zoneFileArray.zones.push({
	      "id":$(this).attr("data-index"),
	      "left":100.00*parseInt($(this).css("left"))/cvs.width,
	      "top":100.00*parseInt($(this).css("top"))/cvs.height,
	      "width":100.00*parseInt($(this).css("width"))/cvs.width,
	      "height":100.00*parseInt($(this).css("height"))/cvs.height,
	      "classes":"",
	      "type":"link",
	      "href":$(this).html()
	    });
		});
		zoneFileArray.img=$("#mainimage").attr("src");
		console.log(zoneFileArray);
		$(".selected").removeClass("selected");
		$.get( "editor/postsave.php", {
			post: "<?php echo $_GET['post']; ?>", content: $("#editorCanvas").html()
		}).done(function( data ) {
			console.log( "Data Loaded: " + data );
		}).fail(function(e){
			console.log("error: "+e.responseText);
			console.log(e);
		}).always(function() {
			console.log( "finished" );
		});
	}
	updateToolbox=function (){
		$("#toolbox > #coords").html("x:"+mouse.x+"% y:"+mouse.y+"%");
	}
	drawZones=function(list){
		for(itm in list){
			addzone({sx:list[itm].sx,sy:list[itm].sy,ex:list[itm].ex,ey:list[itm].ey});
		}
	}
	refreshmouse=function(e){
		mouse.x=100.00*e.offsetX/cvs.width;
		mouse.y=100.00*e.offsetY/cvs.height;
	}
	//we need to read the HTML loaded zones so when loading a file, dom elements don't get replaced on zone creation.
	readHtmlZones=function(){
		$(".zone").each(function(){
			while((typeof zones[itm] === "object"))
				itm++;
			console.log("reading zone in array pos"+itm+" this is");
			console.log(zones[itm]);
			zones[itm]={source:"loaded"};
			zones[itm].sprite=$(this).html();
			// $('#d'+itm+'').css({left:zones[itm].sx+"%",top:zones[itm].sy+"%",width:zones[itm].ex-zones[itm].sx+"%",height:zones[itm].ey-zones[itm].sy+"%"})
		});
	}
	readHtmlZones();
	addZone=function(m){
		while((typeof zones[itm] === "object"))
			itm++;
		console.log("creating zone in array pos"+itm+" this is");
		console.log(zones[itm]);
		zones[itm]={source:"created",sx:m.sx,sy:m.sy,ex:m.ex,ey:m.ey};
		zones[itm].sprite=$("#editorCanvas").append('<div class="zone" data-index="'+itm+'" id=d'+itm+'></div>');
		reappend();
		$('#d'+itm+'').css({left:zones[itm].sx+"%",top:zones[itm].sy+"%",width:zones[itm].ex-zones[itm].sx+"%",height:zones[itm].ey-zones[itm].sy+"%"})
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
		refreshmouse(e);
		if(tool=="zone"){
			refreshmouse(e);
			mouse.ex=mouse.x;
			mouse.ey=mouse.y;
			$(".zone").css({"pointer-events":"none"});
			zp.css({left:mouse.sx+"%",top:mouse.sy+"%",width:mouse.ex-mouse.sx+"%",height:mouse.ey-mouse.sy+"%"});
		}else{
			$(".zone").css({"pointer-events":""});
		}
		updateToolbox();
	}).on("mousedown",function(e){
		//zones affect the ofset mouse coors
		if(tool=="zone"){
			$(".zone").css({"pointer-events":"none"});
			refreshmouse(e);
			mouse.sx=mouse.x;
			mouse.sy=mouse.y;
			zp.css({left:mouse.sx+"%",top:mouse.sy+"%"});
			zp.animate({opacity:1});
			console.log(zones);
		}
	}).on("mouseup",function(e){
		if(tool=="zone"){
			refreshmouse(e);
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
							$("#selectedoptions").html('<span>'+$(this).css("top")+','+$(this).css("left")+'<br>'+$(this).css("width")+','+$(this).css("height")+'</span>,<textarea id="htmledit">'+$(this).html()+'</textarea>');
							var pare=$(this);
							$("#htmledit").on("input change blur",function(){
								$(".selected").html($("#htmledit").val());
							})
						}
					}).on("mouseup",function(e){
						$("#css_l").val(100.00*parseInt($(this).css("left"))/cvs.width);
						$("#css_t").val(100.00*parseInt($(this).css("top"))/cvs.height);
						$("#css_w").val(100.00*parseInt($(this).css("width"))/cvs.width);
						$("#css_h").val(100.00*parseInt($(this).css("height"))/cvs.height);
						//$("#css_rot").val($(this).css()/width);
					});
				$(this).data("appended","true");
			}
		});
	}
	reappend();
	//append realtime edition for css boxes
	$("#css_l").on("input change",function(){
		$(".selected").css({"left":$(this).val()+"%"});
	});
	$("#css_t").on("input change",function(){
		$(".selected").css({"top":$(this).val()+"%"});
	});
	$("#css_w").on("input change",function(){
		$(".selected").css({"width":$(this).val()+"%"});
	});
	$("#css_h").on("input change",function(){
		$(".selected").css({"height":$(this).val()+"%"});
	});
	$("#css_rot").on("input change",function(){
		$(".selected").css("transform","rotate("+$(this).val()+" deg)");
		console.log("rotate("+$(this).val()+"deg)")
	});
	$("#div_remove").on("click",function(){
		$(".selected").each(function(){
			n=$(this).data("index");
			zones[n]=null;
			$(this).remove();
			console.log("removed div "+n);
		});
	});
});
$(window).on("resize load",function(){respond()});

</script>
</html>
