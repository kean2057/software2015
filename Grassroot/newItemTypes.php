<?php require("header.php"); 
	//include("functions.php")?>

	<div class="container">
		<h1><u>Add to Inventory</u></h1>
	</div>
		
	<div class="jumbotron container">
		<div class="center-block container">
			<p>Select Item And Quantity To Add:</p>
			<!--form class="input-group" action="" method="POST" -->
			<div class="container col-sm-5">

			
				<div class="row">
					<div class="col-xs-5">
						<p>Donor:</p>
					</div>
					<div class="col-xs-6">
						<select id="donor" name="donor" style="width:150px">
							<?php getDonors();?>
						</select> 
					</div>
				</div>
				
				<div class="row">
					<div class="col-xs-5">
						<p>Category:</p>
					</div>
					<div class="col-xs-6">
						<select id="category" name="category" onchange="toggleNewFeild()" style="width:150px">
							<option value="newCat">New Category</option>
							<?php getCategories(); ?>
						</select>
						<input  type="text" name="newCat" id="newCatField" style="width:150px">
					</div>
				</div>
				
				<br>
				
				<div class="row">
					<div class="col-xs-5">
						<p>Item:</p>
					</div>
					<div class="col-xs-6">
						<input  type="text" name="newItem" id="newItemField" style="width:150px">
					</div>
				</div>
				
				<div class="row">
					<div class="col-xs-5">
						<p>Monetary Value:</p>
					</div>
					<div class="col-xs-6">
						<input type="number" id="dollarAmount" style="width:50px">
					</div>
				</div>
				
				<div class="row">
					<div class="col-xs-5">
						<p>Quantity:</p>
					</div>
					<div class="col-xs-6">
						<input type="number" id="increase" min="0" style="width:50px">
						<button class="btn btn-default" onclick="submit()" type="button">Submit</button>
					</div>
					
				</div>
			</div>
			<!--/form -->
			
		</div>
	</div>
	
	<script>
		function toggleNewFeild() {
			var cat = document.getElementById("category").value;
			if(cat === "newCat")
			document.getElementById("newCatField").disabled=false;
			else
			document.getElementById("newCatField").disabled=true;
		}
		
		function submit() {
			var donorBox = document.getElementById("donor");
			var qtyBox = document.getElementById("increase");
			var catBox = document.getElementById("category");
			var newCatBox = document.getElementById("newCatField");
			var itemDetailsBox = document.getElementById("newItemField");
			var valueBox = document.getElementById("dollarAmount");
			
			var donor = donorBox.value;
			var qty = qtyBox.value;
			var cat = catBox.value;
			var newCat = newCatBox.value;
			var details = itemDetailsBox.value;
			var value = valueBox.value;
			
			var jqxhr = $.ajax( "functions.php?action=addNewType&donor="+donor+"&category="+cat+"&newCat="+newCat+"&newItem="+details+"&increase="+qty+"&dollarAmount="+value)
				.done(function(responceText) {
					//alert("success");
					if(responceText == "success"){
						location.reload();
						alert("Donation added to inventory");
					}
					else
						alert(responceText);
						//alert("attempted");

						
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