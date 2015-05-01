<?php require("header.html"); ?>

	
<div class="jumbotron" style="padding-top:0px;">
<h3 class="center-block text-center" style="margin-bottom:0;">Meet Our Team</h3>
	<div class="well" style="padding:40px;">
		<div class="row center-block text-center" id="old">
			<div class="col-xs-6 thumbnail"><a href="resumes/Gasp.pdf"><img src="images/Mar.png" class="img-responsive img-thumbnail center-block" style="padding:0;border-width:0;" alt="Marissa Gasparro"></a><br><span><strong>Marissa Gasparro</strong></span>
			<br>
			<span>Team Lead</span>
			</div>
			<div class="col-xs-6 thumbnail" id="old"><a href="resumes/Smullen.pdf"><img src="images/Kean.png" class="img-responsive img-thumbnail center-block" style="padding:0;border-width:0;" alt="Kean Smullen"></a><br><span><strong>Kean Smullen</strong></span>
			<br>
			<span>Head Developer</span>
			</div>
			</div><!--end row-->
			<div class="row center-block text-center" id="old1">
			<div class="col-xs-6 col-md-4 thumbnail" id="old"><a href="resumes/Ban.pdf"><img src="images/Mat.png" class="img-responsive img-thumbnail center-block" style="padding:0;border-width:0;" alt="Mathew Banville"></a><br><span><strong>Mathew Banville</strong></span>
			<br>
			<span>Data Analyst</span>
			</div>
			<div class="col-xs-6 col-md-4 thumbnail" id="old"><a href="resumes/Flack.pdf"><img src="images/Kyle.png" class="img-responsive img-thumbnail center-block" style="padding:0;border-width:0;" alt="Kyle Flack"></a><br><span><strong>Kyle Flack</strong></span>
			<br>
			<span>Database Administrator</span>
			</div>
			<div class="col-xs-6 col-md-4 thumbnail" id="old"><a href="resumes/Rotondo.pdf"><img src="images/Kath.png" class="img-responsive img-thumbnail center-block" style="padding:0;border-width:0;" alt="Kathleen Rotondo"></a><br><span><strong>Kathleen Rotondo</strong></span>
			<br>
			<span>Assistant Developer</span>
			</div>
		</div><!--end row-->
	</div><!--end well-->
</div><!--end container-->


<script>
//fixed space between logo and menu when window is resized
$(window).resize(function(){
	
	var width = $('.jumbotron').width();
	if (width < 904) {
	 $('.jumbotron').css("padding", "0 30px 0px 30px").css("margin-top","-20px");
	}else{
		$('.jumbotron').css("padding", "0px 30px 0px 30px").css("margin-top","0");
	}
});
var width = $('.jumbotron').width();  
	if (width < 904) {
		$('.jumbotron').css("padding", "0 30px 0px 30px").css("margin-top","-20px");
	}
</script>
<?php require("footer.html"); ?>