<?php
session_start();
require("header.php");
//require "Retired Functions/Test.php";

$conn = connect();

isLoggedIn( $conn );

$conn = connect();
$query = 'select * from customer where cid = :custid_bv';

$stid = oci_parse($conn, $query);
$custid = $_POST["id"];
oci_bind_by_name($stid, ":custid_bv", $custid);
oci_execute($stid);
$fname = "";
$lname = "";

while ( ($row = oci_fetch_array($stid, OCI_BOTH) ) != false) {
	$fname = $row["FNAME"];
	$lname = $row["LNAME"];
}
	
?>

	<div class="container">
		<h1><u>Checkout</u></h1>
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
			<h3>Checkout for customer:</h3>
			<?php echo "<p class=\"idholder\" id=\"$custid\">$fname $lname</p>" ?>
		</div>
		
		<hr>
		
		<div class="center-block container">
		
			<div class="row">
				<div class="col-sm-3">
					<p>Select Item:</p>
					<div class="input-group">
						<span class="input-group-addon">
							<select id="catFilter" onchange="filterItems()">
								<option value="All">Any</option>
								<?php getCategories();?>
							</select>
						</span>
						<input id="detailsFilter" class="form-control" type="text" action="search" placeholder="Search" onkeypress="filterItems()"></input>
					</div>
					<ul id="itemsList" class="list-group" style="height:200px;overflow:scroll">
						<?php getItemList('All', '');?>	
					</ul>
				</div>
				
				<div class="col-sm-2"> 
					<p>Quantity of Item:</p>
					<!--p class="hidden" id="activeTarget"></p-->
					
					<div class="input-group">
						<input class="form-control" id="quantity" value="1" type="number" ></input>
						<span onclick="addItem()" class="input-group-addon">Add<span id="glph" class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></span>
					</div>
					<hr>
					<div class="text-center"><button onclick="removeItem()" class="button button-default"><span class="glyphicon glyphicon-chevron-left"></span>Remove</button></div>
				</div>
				
				<div class="col-sm-3"> 
					<p>Receipt</p>
					<br>
					<ul id="receipt" class="list-group" style="height:200px;overflow:scroll">
					</ul>
					<div class="text-right"><button onclick="submit()" class="btn btn-default">Submit</button></div>
				</div>
			</div>
			
			
		</div>
	</div>
	
	<script type="text/javascript">
		function filterItems(){
			var categoryBox = document.getElementById("catFilter");
			var detailsBox = document.getElementById("detailsFilter");
			var itemsList = document.getElementById("itemsList");
			
			var cat = categoryBox.value;
			var details = detailsBox.value;
			
			var jqxhr = $.ajax( "functions.php?action=getItemList&category="+cat+"&searchText="+details)
				.done(function(responceText) {
					itemsList.innerHTML = responceText;
					click();
				})
				.fail(function() {
					//alert( "error" );
				})
				.always(function() {
					//alert( "complete" );
				});
		}
		
		//click();
		function click(){
			$("a").click(
				function () {
					//alert(this.id);
					$("a").removeClass("active activeTarget");
					$("#"+this.id).addClass("active activeTarget");
					//alert(this.id);
					//alert($("#"+this.id).html());
					//$("#activeTarget").html($("#"+this.id).html());
					//$("#activeTarget").name(this.id);
				});
		}
		
		function addItem(){
			
			//alert($(".activeTarget").attr("id"));
			var targetItem = $(".activeTarget");
			//if(targetItem){}
			if(targetItem.attr("id") != null && $("#quantity").val() > 0)
			$("#receipt").append("<a id=\"" +"r"+ targetItem.attr("id") + "\" class=\"list-group-item receiptItem\">" + targetItem.html() + ": " + $("#quantity").val() + "</a>");
			click();
		}
		
		function removeItem(){
			//alert("removing");
			var targetItem = $(".activeTarget");
			var element = document.getElementById(targetItem.attr("id"));
			var parent = document.getElementById("receipt");
			if(element != null && element.parentNode == parent)
			parent.removeChild(element);	
		}
		
		function submit() {
			//$.each(document.getElementById("receipt").children, function(k, v){
			//$.each($(".receiptItem"), function(k, v){
			$(".receiptItem").each(function(index){
				//alert($(this).attr("id"));
				var itemId = $(this).attr("id").replace( /^\D+/g, '');
				//alert(itemId);
				var qty = $(this).text().replace( /^\D+/g, '');
				//alert(""+itemId+" "+qty);
				
				var customerid = $(".idholder").attr("id");
				//alert(customerid);
				//return;
				
				var jqxhr = $.ajax( "functions.php?action=checkout&itemId="+itemId+"&quantity="+qty+"&customerId="+customerid)
					.done(function(responceText) {
						//alert("success");
						if(responceText == "success"){
							location.reload();
							//alert("success");
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
			});
			
			alert("Items successfully checked out.");
			
			//var thenum = thestring.replace( /^\D+/g, '');
		}
		
		click();
	</script>
	
	
<?php require("footer.html"); ?>