<?php require("header.html"); ?>
	
<div class="center-block" id="statuspic">
	<h3>Spiral Method</h3>
	<div class="well">
	<div class="row">
	<div class="col-md-6">
		<a href="Documents/spiral.pdf"><img style="max-height:600px" class="img-responsive center-block"id="statusimg" src="images/SpiralNew.png" alt="Spiral Model" usemap="#imgmap"><br></a>
	</div>
	<div class="col-md-4">
		<p class="hideme" id="default" style="display:block">
			<strong>Spiral Method</strong>
			<br>
			The spiral model is a risk-driven process model generator for software projects. Based on the unique risk patterns of a given project, the spiral model guides a team to adopt elements of one or more process models, such as incremental, waterfall, or evolutionary prototyping.<br><br>The maroon dot is our current location within the spiral model.
		</p>
		<p class="hideme" id="riskdat" style="display:none">
			<strong>Risk analysis</strong>
			<br>
			Risk Analysis includes identifying, estimating, and monitoring technical feasibility and management risks, such as schedule slippage and cost overrun. After testing the build, at the end of first iteration, the customer evaluates the software and provides feedback.<br><br>
			<span><i>Deliverables</i><br>Preliminary Design document</span>
		</p>
		<!--
<p class="hideme" id="ccdat" style="display:none">
			<strong>Cumulative cost</strong>
			<br>
			This is some dumb stuff...
		</p>
-->
		<p class="hideme" id="reqdat" style="display:none">
			<strong>Requirements</strong>
			<br>
			To view this document, visit our documents page.
		</p>
		<p class="hideme" id="pddat" style="display:none">
			<strong>Preliminary Design</strong>
			<br>
			To view this document, visit our documents page.
		</p>
		<p class="hideme" id="reldat" style="display:none">
			<strong>Release</strong>
			<br>
			E.A.S. will be released in late May 2015.
		</p>
		<p class="hideme" id="impdat" style="display:none">
			<strong>Implementation</strong>
			<br>
			This document will be available shortly.
		</p>
		<p class="hideme" id="tesdat" style="display:none">
			<strong>Test</strong>
			<br>
			Unit tests will be available shortly.
		</p>
		<!--
<p class="hideme" id="intdat" style="display:none">
			<strong>Integration</strong>
			<br>
			This is some dumb stuff...
		</p>
		<p class="hideme" id="coddat" style="display:none">
			<strong>Code</strong>
			<br>
			This is some dumb stuff...
		</p>
-->
		<p class="hideme" id="dddat" style="display:none">
			<strong>Detailed Design</strong>
			<br>
			To view this document, visit our documents page.
		</p>
		<p class="hideme" id="devdat" style="display:none">
			<strong>Development</strong>
			<br>
			Development phase starts with the conceptual design in the baseline spiral and involves architectural design, logical design of modules, physical product design and final design in the subsequent spirals.<br><br>
			<span><i>Deliverables</i><br>Detailed Design document</span>
		</p>
		<p class="hideme" id="evadat" style="display:none">
			<strong>Evaluation</strong>
			<br>
			This phase allows the all parties to evaluate the output of the project to date before the project continues to the next spiral.
			<br><br>
			<span><i>Deliverables</i><br>Acceptance Test document</span>
		</p>
		<p class="hideme" id="pladat" style="display:none">
			<strong>Planning</strong>
			<br>
			This phase starts with gathering the business requirements in the baseline spiral. In the subsequent spirals as the product matures, identification of system requirements, subsystem requirements and unit requirements are all done in this phase.
<br><br>
This also includes understanding the system requirements by continuous communication between the customer and the system analyst. At the end of the spiral the product is deployed in the identified market.<br><br>
		<span><i>Deliverables</i><br>Requirements Specification document, a finalized list of requirements.</span>
		</p>
	</div>
	</div>
	</div>
	<map name="imgmap">
		<area shape="rect" coords="0,0,0,0" href="#" alt="Risk analysis" id="risk" class="imgmaploc">
		<!-- <area shape="rect" coords="0,0,0,0" href="#" alt="Cumulative cost" id="cc" class="imgmaploc"> -->
		<area shape="rect" coords="0,0,0,0" href="#" alt="Requirements" id="req" class="imgmaploc">
		<area shape="rect" coords="0,0,0,0" href="#" alt="Preliminary Design" id="pd" class="imgmaploc">
		<area shape="rect" coords="0,0,0,0" href="#" alt="Release" id="rel" class="imgmaploc">
		<area shape="rect" coords="0,0,0,0" href="#" alt="Implementation" id="imp" class="imgmaploc">
		<area shape="rect" coords="0,0,0,0" href="#" alt="Test" id="tes" class="imgmaploc">
		<!--
<area shape="rect" coords="0,0,0,0" href="#" alt="Integration" id="int" class="imgmaploc">
		<area shape="rect" coords="0,0,0,0" href="#" alt="Code" id="cod" class="imgmaploc">
-->
		<area shape="rect" coords="0,0,0,0" href="#" alt="Detailed Design" id="dd" class="imgmaploc">
		<area shape="rect" coords="0,0,0,0" href="#" alt="Development" id="dev" class="imgmaploc">
		<area shape="rect" coords="0,0,0,0" href="#" alt="Evaluation" id="eva" class="imgmaploc">
		<area shape="rect" coords="0,0,0,0" href="#" alt="Planning" id="pla" class="imgmaploc">
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
		var width = $("#statusimg").width();
		var height = $("#statusimg").height();
		
		//alert(height + " "+ width);
		
		//set the areas based on image hight and width
		$("#risk").attr("coords",""+(width*0.75)+","+(height*0.09)+","+(width*0.91)+","+(height*0.12));
		/* $("#cc").attr("coords",""+(width*0.84)+","+(height*0.25)+","+(width*0.97)+","+(height*0.32)); */
		$("#req").attr("coords",""+(width*0.49)+","+(height*0.62)+","+(width*0.64)+","+(height*0.64));
		$("#pd").attr("coords",""+(width*0.58)+","+(height*0.71)+","+(width*0.70)+","+(height*0.75));
		$("#rel").attr("coords",""+(width*0.38)+","+(height*0.89)+","+(width*0.46)+","+(height*0.91));
		$("#imp").attr("coords",""+(width*0.51)+","+(height*0.88)+","+(width*0.68)+","+(height*0.90));
		$("#tes").attr("coords",""+(width*0.66)+","+(height*0.83)+","+(width*0.70)+","+(height*0.85));
		/*
$("#int").attr("coords",""+(width*0.68)+","+(height*0.76)+","+(width*0.80)+","+(height*0.78));
		$("#cod").attr("coords",""+(width*0.76)+","+(height*0.65)+","+(width*0.81)+","+(height*0.67));
*/
		$("#dd").attr("coords",""+(width*0.78)+","+(height*0.55)+","+(width*0.87)+","+(height*0.61));
		$("#dev").attr("coords",""+(width*0.79)+","+(height*0.86)+","+(width*0.95)+","+(height*0.89));
		$("#eva").attr("coords",""+(width*0.05)+","+(height*0.74)+","+(width*0.18)+","+(height*0.76));
		$("#pla").attr("coords",""+(width*0.06)+","+(height*0.13)+","+(width*0.17)+","+(height*0.16));
	}
</script>
<?php require("footer.html"); ?>