<?php
//session_start();
//include ( "functions.php" );
//$conn = oci_connect(DBUSER, DBPASSWORD, DBHOST);
//isLoggedIn( $conn );
require ("header.php");
?>

	<div class="container">
		<h1><u>Add to Inventory</u></h1>
	</div>
		
	<div class="jumbotron container">
		<div class="center-block container">
			<p>Select Item And Quantity To Add:</p>
			<!-- form class="input-group" action="increment_inventory.php" method="POST" -->
			<div class="container col-sm-5">
				<div class="row">
					<div class="col-xs-5">
						<p>Donor:</p>
					</div>
					<div class="col-xs-6">
						<select id="donor" name="donor" value="3" style="width:100px">
							<?php getDonors();?>
						</select> 
					</div>
				</div>
			
				<div class="row">
					<div class="col-xs-5">
						<p>Category:</p>
					</div>
					<div class="col-xs-6">
						<select id="category" name="category" onchange="filterItems()" value="All" style="width:100px">
							<option value="All">Any</option>
							<?php getCategories(); ?>
						</select>
					</div>
				</div>
				
				<div class="row">
					<div class="col-xs-5">
						<p>Item:</p>
					</div>
					<div class="col-xs-6">
						<select id="itemId" name="itemId" style="width:100px">
							<?php getItemsIn("All"); ?>
						</select> <br> <a  href="newItemTypes.php" >Need a new item type</a>
					</div>
				</div>
				
				<div class="row">
					<div class="col-xs-5">
						<p>Quantity:</p>
					</div>
					<div class="col-xs-6">
						<input type="number" id="increase" min="1" value="1" style="width:50px">
						<button class="btn btn-default" onclick="submit()" type="button">Submit</button>
					</div>
				</div>
			<!--/form-->
			</div>
		</div>
	</div>
	
	<script>
		function filterItems() {
			var cat = document.getElementById("category").value;
			
			//alert("boop: "+cat);
			var jqxhr = $.ajax( "functions.php?action=getItemsIn&category="+cat)
				.done(function(responceText) {
					//alert( "success" );
					//alert(responceText);
					
					//Sets the Item dropdown to the list of items that match the category
					document.getElementById("itemId").innerHTML = responceText; 
				})
				.fail(function() {
					//alert( "error" );
				})
				.always(function() {
					//alert( "complete" );
				});
		}
		
		function submit() {
			var itemBox = document.getElementById("itemId");
			var donorBox = document.getElementById("donor");
			var qtyBox = document.getElementById("increase");
			var catBox = document.getElementById("category");
		
			var itemId = itemBox.value;
			var donorId = donorBox.value;
			var qty = qtyBox.value;
			//alert(""+itemId+" "+donorId+" "+qty);
			
			var jqxhr = $.ajax( "functions.php?action=incrementInventory&itemId="+itemId+"&qty="+qty+"&donorId="+donorId)
				.done(function(responceText) {
					//alert("success");
					if(responceText == "success"){
						location.reload();
						alert("success");
					}
					else
						alert(responceText);

						
				})
				.fail(function() {
					//alert( "error" );
				})
				.always(function() {
					//alert( "complete" );
				});
			
			
		}
	</script>
<?php require("footer.html"); ?>