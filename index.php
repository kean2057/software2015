<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Maroon Solutions</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Software Engineering, Siena College">
<meta name="author" content="Maroon Solutions">

<!-- styles -->
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/index.css" rel="stylesheet">
<link href="css/bootstrap-responsive.css" rel="stylesheet">

<!-- Fav and touch icons -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="images/fab.png">

</head>
<body>

<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
    	<div class="container-fluid">
	    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	    <span class="icon-bar"></span>
	    <span class="icon-bar"></span>
	    <span class="icon-bar"></span>
	    </button>
		<a id="index" class="brand" href="index.php">Maroon Solutions</a>
			<div class="nav-collapse collapse">
	            <ul class="nav">
	              <li id="home"><a href="index.php">Home</a></li>
				  <li id="about"><a href="about.php">About Us</a></li>
				  <li id="status"><a href="status.php">Project Status</a></li>
				  <li id="docs"><a href="docs.php">Documents</a></li>
				  <li id="notes"><a href="notes.php">Notes</a></li>
	            </ul>
			</div><!--/.nav-collapse -->
		</div><!--container-fluid-->
	</div>
</div><!--end class="navbar navbar-inverse navbar-fixed-top"-->
	
<div class="jumbotron" id="statuspic">
	<img src="images/logo.png" id="biglogo" class="center-block" alt="logo"/>
	<div class="well center-block" style="padding:10px;width:80%;max-width:568px;">
				<img style="max-height:600px" class="teampic img-responsive" id="tpic" src="images/team.png" alt="Team Picture" usemap="#imgmap"><br></a>
				<p class="hideme text-center" id="default" style="display:block">
					Kean Smullen, Kyle Flack, Marissa Gasparro, Kathleen Rotondo, Mathew Banville
				</p>
				<p class="hideme text-center" id="riskdat" style="display:none">
					<strong>Kean Smullen</strong>
				</p>
				<p class="hideme text-center" id="ccdat" style="display:none">
					<strong>Kyle Flack</strong>
				</p>
				<p class="hideme text-center" id="reqdat" style="display:none">
					<strong>Marissa Gasparro</strong>
				</p>
				<p class="hideme text-center" id="pddat" style="display:none">
					<strong>Kathleen Rotondo</strong>
				</p>
				<p class="hideme text-center" id="reldat" style="display:none">
					<strong>Mathew Banville</strong>
				</p>
	</div><!--end well-->
	<map name="imgmap">
		<area shape="rect" coords="0,0,0,0" target="_blank" href="resumes/Smullen.pdf" alt="Risk analysis" id="risk" class="imgmaploc">
		<area shape="rect" coords="0,0,0,0" target="_blank" href="resumes/Flack.pdf" alt="Cumulative cost" id="cc" class="imgmaploc">
		<area shape="rect" coords="0,0,0,0" target="_blank" href="resumes/Gasp.pdf" alt="Requirements" id="req" class="imgmaploc">
		<area shape="rect" coords="0,0,0,0" target="_blank" href="resumes/Rotondo.pdf" alt="Preliminary Design" id="pd" class="imgmaploc">
		<area shape="rect" coords="0,0,0,0" target="_blank" href="resumes/Ban.pdf" alt="Release" id="rel" class="imgmaploc">
	</map>
</div>
<script src="js/jquery.js"></script>
<script>
	window.onload = function(){recalcMap();}
	window.onresize = function(){recalcMap();}
	
	$(".imgmaploc").hover(function(){
			$(".hideme").attr("style","display:none");
			$("#"+this.id+"dat").attr("style","display:block");
		}, 
		function(){
				$(".hideme").attr("style","display:none");
				$("#default").attr("style","display:block");
		});
	
	function recalcMap() {
		var width = $("#tpic").width();
		var height = $("#tpic").height();

		
		//set the areas based on image hight and width
		$("#risk").attr("coords",""+(width*0.10)+","+(height*0.20)+","+(width*0.21)+","+(height*0.45));
		$("#cc").attr("coords",""+(width*0.34)+","+(height*0.22)+","+(width*0.44)+","+(height*0.44));
		$("#req").attr("coords",""+(width*0.44)+","+(height*0.45)+","+(width*0.54)+","+(height*0.68));
		$("#pd").attr("coords",""+(width*0.58)+","+(height*0.20)+","+(width*0.68)+","+(height*0.43));
		$("#rel").attr("coords",""+(width*0.81)+","+(height*0.20)+","+(width*0.92)+","+(height*0.43));
	}

//fixed space between logo and menu when window is resized
$(window).resize(function(){
	
	var width = $('.jumbotron').width();
	if (width < 904) {
	 $('.jumbotron').css("padding", "0 30px 0px 30px").css("margin-top","-20px");
	}else{
		$('.jumbotron').css("padding", "40px 30px 0px 30px").css("margin-top","0");
	}
});
var width = $('.jumbotron').width();  
	if (width < 904) {
		$('.jumbotron').css("padding", "0 30px 0px 30px").css("margin-top","-20px");
	}
</script>
<?php require("footer.html"); ?>