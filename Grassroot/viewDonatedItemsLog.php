<?php require("header.php"); ?>

<div class="container">			
<h1>Item Donations</h1>
</div>

<div class="jumbotron container">
<div class="center-block container">
<?php 
	//include_once 'db_config.php';
	// Create connection to Oracle
	$conn = oci_connect(DBUSER, DBPASSWORD, DBHOST);
	
	if (!$conn) {
		$m = oci_error();
		echo $m['message']. "\n";
		exit;
	}
	else {
		//echo "<p>connected</p>";
	}
	
	//Define query
	$query = 'select * from donated_items_view order by TIME DESC';
	
						
	//echo $query;
	$stid = oci_parse($conn, $query);
	$clear = oci_execute($stid);
	if($clear){
	//echo '<p>successful!!</p>';
	}
	else
	echo '<p>error attempting to update the database</p>';
	//echo "Queried";
	echo '<pre><table class="table"><tr><td>  Date  </td><td>  who  </td><td>  Category  </td><td>  Details  </td><td>  Quantity  </td><td>  Authorizer  </td></tr></pre>';
	while ( ($row = oci_fetch_array($stid, OCI_BOTH) ) != false) {
							echo "<tr><td>". $row['TIME'] . "</td><td>" . $row['FNAME'] . " " . $row['LNAME'] . "</td><td>". $row['CATEGORY'] . "</td><td>" . $row['DETAILS'] . "</td><td>".$row['QUANTITY']."</td><td>".$row['AUTHORIZER']."</td></tr>";
	}							
	echo '</table>';
?>
</div>
</div>
<?php require("footer.html"); ?>