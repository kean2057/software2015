<?php
session_start();
require("header.php");
//require "Retired Functions/Test.php";

$conn = connect();

isLoggedIn( $conn );

$conn = connect();
$query = 'select * from donor where did = :donorid_bv';

$stid = oci_parse($conn, $query);
$donorid = $_POST["id"];
oci_bind_by_name($stid, ":donorid_bv", $donorid);
oci_execute($stid);
$fname = "";
$lname = "";

while ( ($row = oci_fetch_array($stid, OCI_BOTH) ) != false) {
	$fname = $row["FNAME"];
	$lname = $row["LNAME"];
}
	

?>

	<div class="container">
		<h1><u>Print Receipt</u></h1>
	</div>
		
	<div class="jumbotron container">
		<!--div class="center-block container">
			<p>Select Customer:</p>
			<input type="text" action="search" placeholder="Search" onchange="filterCust()"></input>
			<ul class="list-group" style="height:200px;overflow:scroll">
				<?php //getCustomersLike(""); ?>
			</ul>
		</div-->
		<div class="well">
			<h3>Print Receipt for:</h3>
			<?php echo "<p class=\"idholder\" id=\"$donorid\">$fname $lname</p>" ?>
		</div>
		<hr>
		
		<div class="center-block container">
			<p>Date to start looking for donations</p>
			<input type="date" value="<?php echo date('Y-m-d');?>" id="startDate"/>
			<button id="submit" class="btn btn-default">Submit</button>
		</div>
	</div>
	
	<script type="text/javascript">
		
		// function click(){
			$("#submit").click(
				function () {
					var startDate = document.getElementById("startDate").value;
					var donorId = $(".idholder").attr("id");
					//alert(donorId);
					window.open("functions.php?action=receipt&donorId="+donorId+"&startDate=" + startDate, "Receipt", "width=400, height=800");
					// var jqxhr = $.ajax( "functions.php?action=receipt&donorId=1&startDate=" + startDate)
					// .done(function(responceText) {
						
						// alert(responceText);
					// })
					// .fail(function() {
						// //alert( "error" );
					// })
					// .always(function() {
						// //alert( "complete" );
					// });
				});
		// }
	</script>
	
	
<?php require("footer.html"); ?>