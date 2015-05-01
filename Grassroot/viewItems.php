<?php require("header.php");
	//echo 'boop';
	//require ('./Retired Functions/Test.php');?>
<!--link rel="stylesheet" type="text/css" href="./css/panelCollapse.css" -->

<div class="container">			
<h1>Item Inventory</h1>
</div>

<div class="container" id="accordion">
<?php 
	$admin = isAdmin();
	$conn = connect();
	if (!$conn) {
		$m = oci_error();
		echo $m['message']. "\n";
		exit;
	}
	else {
		//echo "<p>connected</p>";
	}
	
	//Define query
	$query = 'select * from item order by category, details';
	
						
	//echo $query;
	$stid = oci_parse($conn, $query);
	$clear = oci_execute($stid);
	if($clear){
	//echo '<p>successful!!</p>';
	}
	else
	echo '<p>error attempting to update the database</p>';
	//echo "Queried";
	
	$lastCat = "";
	//echo '<ul class="list-group">';
	while ( ($row = oci_fetch_array($stid, OCI_BOTH) ) != false) {
		$cat = $row['CATEGORY'];
		
		if(strcmp($lastCat, $cat) != 0){
			if(strcmp($lastCat, "") != 0){
				//echo '</tbody></table></div><br>';
				echo '</tbody></table></div></div></div><br>';
			}
			$lastCat = $cat;
			
			//echo '<div class="panel panel-default"><div class="panel-heading"><p>'.$lastCat.'</p></div><table class="table"><thead><tr><th style="width:45%">Details</th><th style="width:15%">Quantity</th><th style="width:15%">Value</th>';
			echo	'<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#dat'.filter_var($lastCat, FILTER_SANITIZE_EMAIL).'">'.$lastCat.'</a></h4>
						</div>
						
						<div id="dat'.filter_var($lastCat, FILTER_SANITIZE_EMAIL).'" class="panel-collapse collapse">
							<div class="panel-body">
								<table class="table">
									<thead><tr><th style="width:45%">Details</th><th style="width:15%">Qty</th><th style="width:15%">Value</th>';
			
			if($admin)
				echo '<th style="width:25%">Edit Value</th>';
			echo '</tr></thead><tbody>';
		}
		//else{
		$quant = $row['QUANTITY'];
		$details = $row['DETAILS'];
		$value = $row['VALUE'];
		$iid = $row['IID'];

		echo "<tr><td>$details</td><td>$quant</td><td><input type=\"number\" id=\"lock $iid\" value=\"$value\" hidden /><input style=\"width:50px\" disabled id=\"val $iid\" type=\"number\" value=\"$value\"></input></td>";
		if($admin)
			echo '<td id='.$iid.'><button onClick="editClicked('.$iid.')">Edit</button></td>';
		echo "</tr>";
		
	}
	//echo '</tbody></table></div>';
	echo '</tbody></table></div></div></div>';
?>
</div>


<script>

	function editClicked(itemId) {
		//alert("editClicked " + itemId);
		document.getElementById(itemId).innerHTML = "<button onClick =\"resetBnts("+ itemId +")\">Cancel</button><button onClick=\"submit("+ itemId +")\">Submit</button>";
		document.getElementById("val " + itemId).disabled = false;
		
	}
	
	function resetBnts(itemId){
		document.getElementById(itemId).innerHTML = "<button onClick=\"editClicked("+ itemId +")\">Edit</button>";
		var itemValBox = document.getElementById("val " + itemId);
		itemValBox.disabled = true;
		itemValBox.value = document.getElementById("lock " + itemId).value;

	}
	
	function submit(itemId){
		document.getElementById(itemId).innerHTML = "<button onClick=\"editClicked("+ itemId +")\">Edit</button>";
		var itemValBox = document.getElementById("val " + itemId);
		var strVal = ""+itemValBox.value;
		
		if(!strVal.match(/\d/)){
			alert("Invalid character, numbers only please.");
			return;
		}
		document.getElementById("lock " + itemId).value = strVal;
		itemValBox.disabled = true;
		//alert("functions.php?action=setPrice&newPrice="+itemValBox.value+"itemId="+itemId);
		var jqxhr = $.ajax( "functions.php?action=setPrice&newPrice="+itemValBox.value+"&itemId="+itemId)
				.done(function(responceText) {
					//alert( "success" );
					//alert(responceText);
					
				})
				.fail(function() {
					alert( "error" );
				})
				.always(function() {
					alert( "complete" );
				});
	}
</script>
<?php require("footer.html"); ?>