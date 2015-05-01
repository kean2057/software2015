<?php
/*
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);
*/
	//Simple functions for other php or javascript to call.
	//echo '<p>functions run</p>'; //for debug 

	include_once 'db_config.php';
	session_start();
	
	//Used in ajax calls: functions.php?action=[desiredAction]&[more vars...]
	//Calls getItemsIn() with the category passed in from the url
	if(isset($_GET["action"]) && $_GET["action"] == "getItemsIn")
		getItemsIn($_GET["category"]);
	
	//Calls setPrice() with the itemId passed in from the url
	if(isset($_GET["action"]) && $_GET["action"] == "setPrice")
		setPrice($_GET["itemId"], $_GET["newPrice"]);
		
	//Calls incrementInventory() with the itemId, qty, and donorId passed in from the url
	if(isset($_GET["action"]) && $_GET["action"] == "incrementInventory")
		incrementInventory($_GET["itemId"], $_GET["qty"], $_GET["donorId"]);
	
	//Calls addNewItemType() 
	if(isset($_GET["action"]) && $_GET["action"] == "addNewType")
		addNewItemType($_GET['donor'], $_GET["category"], $_GET["newCat"], $_GET["newItem"], $_GET["increase"], $_GET["dollarAmount"]);
		
	if(isset($_GET["action"]) && $_GET["action"] == "getItemList")
		getItemList($_GET['category'], $_GET['searchText']);
	
	if(isset($_GET["action"]) && $_GET["action"] == "checkout")
		checkout($_GET["customerId"], $_GET["itemId"], $_GET["quantity"]);
	
	if(isset($_GET["action"]) && $_GET["action"] == "receipt")
		printReceipt($_GET["donorId"], $_GET["startDate"]);
	
//--------------profile search-----------------------------------
	if(isset($_GET["action"]) && $_GET["action"] == "dceSearch")
		dceSearch($_GET['type']);
		
	if(isset($_GET["action"]) && $_GET["action"] == "dceLikeSearch")
		dceLikeSearch($_GET['type'], $_GET['likeType']);
		
	if(isset($_GET["action"]) && $_GET["action"] == "getEmpProfile")
		getEmpProfile($_GET['id']);
		
	if(isset($_GET["action"]) && $_GET["action"] == "getDonProfile")
		getDonProfile($_GET['id']);
		
	if(isset($_GET["action"]) && $_GET["action"] == "getCusProfile")
		getCusProfile($_GET['id']);
	
	if(isset($_GET["action"]) && $_GET["action"] == "newCusBtn")
		getCusProfile($_GET['id']);
		
	if(isset($_GET["action"]) && $_GET["action"] == "newDonBtn")
		getDonProfile($_GET['id']);
		
	if(isset($_GET["action"]) && $_GET["action"] == "newEmpBtn")
		getEmpProfile($_GET['id']);
		

		
	if(isset($_GET["action"]) && $_GET["action"] == "addDonPro")
		addDonPro($_GET['fname'], $_GET['lname'], $_GET['address'], $_GET['email']);
	
	if(isset($_GET["action"]) && $_GET["action"] == "sureAdd")
		sureAdd($_GET['fname'], $_GET['lname'], $_GET['address'], $_GET['email']);
	
	if(isset($_GET["action"]) && $_GET["action"] == "editDonPro")
		editDonPro($_GET['fname'], $_GET['lname'], $_GET['address'], $_GET['email']);
		
	if(isset($_GET["action"]) && $_GET["action"] == "subEditDon")
		subEditDon($_GET['id'], $_GET['fname'], $_GET['lname'], $_GET['address'], $_GET['email']);
		
	if(isset($_GET["action"]) && $_GET["action"] == "addCusPro")
		addCusPro($_GET['fname'], $_GET['lname'], $_GET['address'], $_GET['aff']);
		
	if(isset($_GET["action"]) && $_GET["action"] == "sureAddCustomer")
		sureAddCustomer($_GET['fname'], $_GET['lname'], $_GET['address'], $_GET['aff']);
	
	/*
if(isset($_GET["action"]) && $_GET["action"] == "editCusPro")
		editCusPro($_GET['fname'], $_GET['lname'], $_GET['address'], $_GET['aff']);
*/
	

function dceSearch($type){
	$conn = connect();
	$query = '';
	
	//get list of donors
	if($type == 'donor'){
		$query = 'SELECT * FROM donor ORDER BY lower(lname) ASC';
		$stid = oci_parse($conn, $query);
		$clear = oci_execute($stid);
	
		echo oci_error($stid)['message'];
		
		//Format query
		echo '<table class="table table-striped table-bordered table-responsive"><tbody><tr><th>First Name</th><th>Last Name</th></tr>';
		while ( ($row = oci_fetch_array($stid, OCI_BOTH) ) != false) {
			echo "<tr><td><a class=\"grabDon\" id=\"" . $row['DID'] . "\" href=\"#profileWell\">" . $row['FNAME'] . "</td><td>". $row['LNAME'] . "</td></tr>";
		}
			echo '<tbody></table>';
			echo '<div class="text-right"><button class="btn btn-default" id="newDonBtn" type="button">Create New Donor</button></div>';
	}//end list donors
	
	//get list of customers
	if($type == 'customer'){
		$query = 'SELECT * FROM customer ORDER BY lower(lname) ASC';
		$stid = oci_parse($conn, $query);
		$clear = oci_execute($stid);
	
		echo oci_error($stid)['message'];
		
		//Format query
		echo '<table class="table table-striped table-bordered table-responsive"><tbody><tr><th>First Name</th><th>Last Name</th></tr>';
		while ( ($row = oci_fetch_array($stid, OCI_BOTH) ) != false) {
			echo "<tr><td><a class=\"grabCus\" id=\"" . $row['CID'] . "\" href=\"#profileWell\">" . $row['FNAME'] . "</td><td>". $row['LNAME'] . "</td></tr>";
		}
			echo '<tbody></table>';
			echo '<div class="text-right"><button class="btn btn-default" id="newCusBtn" type="button">Create New Customer</button></div>';
	}//end list customers
	
	//get list of employees
	if($type == 'employee'){
		$query = 'SELECT * FROM sysuser ORDER BY lower(lname) ASC';
		$stid = oci_parse($conn, $query);
		$clear = oci_execute($stid);
		
		echo oci_error($stid)['message'];
		
		//Format query		
		echo '<table class="table table-striped table-bordered table-responsive"><tbody><tr><th>First Name</th><th>Last Name</th><th>Username</th><th>Admin</th></tr>';
		while ( ($row = oci_fetch_array($stid, OCI_BOTH) ) != false) {
			echo "<tr><td><a class=\"grabEmp\" id=\"" . $row['USERNAME'] . "\" href=\"#profileWell\">" . $row['FNAME'] . "</a></td><td>". $row['LNAME'] . "</td><td>". $row['USERNAME'] . "</td><td>". $row['ADMIN'] . "</td></tr>";
			}
		echo '<tbody></table>';
		echo '<div class="text-right"><button class="btn btn-default" id="newEmpBtn" type="button">Create New Employee</button></div>';
	}//end list employees
	
}//end dceSearch function


//dceLikeSearch
function dceLikeSearch($type, $likeType){
	
	$conn = connect();

	//set type and id for new profile button
	if($type == 'donor'){ $id='DID'; $btnId='newDonBtn';	
	}else if($type == 'customer'){ $id='CID';$btnId='newCusBtn';
	}else{  $id='username';$btnId='newEmpBtn';$type='sysuser';}
	
	//sanitize and validate user input
/*
	$b_isValidated = filter_var($likeType, FILTER_SANITIZE_EMAIL);
	if($b_isValidated == false){
		echo "Please enter valid search criteria"
	}else{
*/
		$likeType = $likeType.'%';
		
			$query = 'SELECT * FROM '.$type.' WHERE lower(fname) LIKE lower(:likeType) OR lower(lname) LIKE lower(:likeType) ORDER BY lower(lname) ASC';
		
			$stid = oci_parse($conn, $query);
			oci_bind_by_name($stid, ":type", $type);
			oci_bind_by_name($stid, ":likeType", $likeType);
			$clear = oci_execute($stid);
			echo oci_error($stid)['message'];
			
			echo '<table class="table table-striped table-bordered table-responsive"><tbody><tr><th>First Name</th><th>Last Name</th></tr>';
				while ( ($row = oci_fetch_array($stid, OCI_BOTH) ) != false) {
				echo "<tr><td><a class=\"grabDon\" id=\"" . $row[$id] . "\" href=\"#profileWell\">" . $row['FNAME'] . "</a></td><td>". $row['LNAME'] . "</td></tr>";
				}
			echo '<tbody></table>';
			echo '<div class="text-right"><button class="btn btn-default" id="'.$btnId.'" type="button">Create New Donor</button></div>';
	
	
	/*
}//end else from validation if
	
*/
}//end dceLikeSeach

//display donor profile
function getDonProfile($id){
	if($id == 'null'){
		echo '<br><form><div class="form-group" style="margin:0 10px 0 10px;">
		<div class="row"><div class="col-sm-6">
				<label for="fname" class="control-label">First Name</label>
				<input type="text" class="form-control" id="fname" style="width:100%;">
				</div>
				<div class="col-sm-6">
				<label for="lname">Last Name</label>
				<input type="text" class="form-control" id="lname" style="width:100%;">
				</div></div><br>
				<div class="row"><div class="col-sm-6">
				<label for="address">Address</label>
				<input type="text" class="form-control" id="address" style="width:100%;">
				</div><div class="col-sm-6">
				<label for="email">Email</label>
				<input type="email" class="form-control" id="email" style="width:100%;">
			</div></div>
		</div></form>';
		echo '<br><div class="text-right"><button onClick="cancelAddDon()" class="btn btn-default" id="cancelDonBtn" type="button">Clear</button><button onClick="addDonor()" class="btn btn-default" id="addDonBtn" type="button">Add New Donor</button></div>';
	}else{
		$conn = connect();
		$query = 'SELECT * FROM donor WHERE did=:EIDBV';
		
		$stid = oci_parse($conn, $query);
		oci_bind_by_name($stid, ":EIDBV", $id);
		$clear = oci_execute($stid);
		echo oci_error($stid)['message'];
		
		
		while ( ($row = oci_fetch_array($stid, OCI_BOTH) ) != false) {
			$donId = $row['DID'];
			$fname=$row['FNAME'];
			$lname=$row['LNAME'];
			$addr=$row['ADDRESS'];
			$email=$row['EMAIL'];
		}
				
		echo '<br><div class="form-group" style="margin:0 10px 0 10px;">
		<div class="row"><div class="col-sm-6">
				<label for="fname" class="control-label">First Name</label>
				<input type="text" value="'.$fname.'" class="form-control" id="fname" style="width:100%;" readonly="readonly">
				</div>
				<div class="col-sm-6">
				<label for="lname">Last Name</label>
				<input type="text" value="'.$lname.'" class="form-control" id="lname" style="width:100%;" readonly="readonly">
				</div></div><br>
				<div class="row"><div class="col-sm-6">
				<label for="address">Address</label>
				<input type="text" value="'.$addr.'" class="form-control" id="address" style="width:100%;" readonly="readonly">
				</div><div class="col-sm-6">
				<label for="email">Email</label>
				<input type="email" value="'.$email.'" class="form-control" id="email" style="width:100%;" readonly="readonly">
			</div></div>
		</div>';
			
		echo '<br><div class="text-right"><button onClick="editPro()" class="btn btn-default editProfile" type="button">Edit Profile</button><div id="changeBtn" style="display:none;"><button class="btn btn-default" id="cancelEdit" type="button">Cancel</button><button name="'.$donId.'" class="btn btn-default" id="submitEdit" type="button">Submit</button></div><form method="POST" action="printReceipts.php?" style="display:inline;"><input type="number" name="id" value="'.$donId.'" style="display:none;"/><input type="submit" class="btn btn-default editProfile" id="printReceiptBtn" value="View and Print Receipt" name="receiptBtn"/></form>
		</div>';
	}
}//end getDonProfile function

//display employee profile
function getEmpProfile($id){
	if($id == 'null'){
		echo '<br><form><div class="form-group" style="margin:0 10px 0 10px;">
		<div class="row"><div class="col-sm-6">
				<label for="fname" class="control-label">First Name</label>
				<input type="text" class="form-control" id="fname" style="width:100%;">
				</div>
				<div class="col-sm-6">
				<label for="lname">Last Name</label>
				<input type="text" class="form-control" id="lname" style="width:100%;">
				</div></div><br>
				<div class="row"><div class="col-sm-6">
				<label for="username">Username</label>
				<input type="text" class="form-control" id="username" style="width:100%;">
				</div><div class="col-sm-6">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="password" style="width:100%;">
			</div></div>
		</div></form>';
		echo '<br><div class="text-right"><button onClick="cancelAddEmp()" class="btn btn-default" id="cancelEmpBtn" type="button">Clear</button><button class="btn btn-default" id="addEmpBtn" type="button">Add New Employee</button></div>';
	}else{
		$conn = connect();
		$query = 'SELECT * FROM sysuser WHERE username=:EIDBV';
		
		$stid = oci_parse($conn, $query);
		oci_bind_by_name($stid, ":EIDBV", $id);
		$clear = oci_execute($stid);
		echo oci_error($stid)['message'];
		
		while ( ($row = oci_fetch_array($stid, OCI_BOTH) ) != false) {
			//$empId = $row['USERNAME'];
			$fname=$row['FNAME'];
			$lname=$row['LNAME'];
			$username=$row['USERNAME'];
			$admin=$row['ADMIN'];
		}
				
		echo '<br><div class="form-group" style="margin:0 10px 0 10px;">
			<div class="row"><div class="col-sm-6">
			<label for="fname" class="control-label">First Name</label>
			<input type="text" value="'.$fname.'" class="form-control" id="fname" style="width:100%;" readonly="readonly">
			</div>
			<div class="col-sm-6">
			<label for="lname">Last Name</label>
			<input type="text" value="'.$lname.'" class="form-control" id="lname" style="width:100%;" readonly="readonly">
			</div></div><br>
			<div class="row"><div class="col-sm-6">
			<label for="username">Username</label>
			<input type="text" value="'.$username.'" class="form-control" id="address" style="width:100%;" readonly="readonly">
			</div><div class="col-sm-6">
			<label for="admin">Admin</label>
			<input type="text" value="'.$admin.'" class="form-control" id="admin" style="width:100%;" readonly="readonly">
			</div></div>
			</div>';
		echo '<br><div class="text-right"><button onClick="editPro()" class="btn btn-default" id="editProfile" type="button">Edit Profile</button><div id="changeBtn" style="display:none;"><button class="btn btn-default" id="cancelEdit" type="button">Cancel</button><button class="btn btn-default" id="submitEdit" type="button">Submit</button></div></div>';
		
	}//end else
}//end getEmpProfile function

//display customer profile
function getCusProfile($id){
	if($id == 'null'){
		echo '<br><div class="form-group" style="margin:0 10px 0 10px;">
			<div class="row"><div class="col-sm-6">
			<label for="fname" class="control-label">First Name</label>
			<input type="text" value="'.$fname.'" class="form-control" id="fname" style="width:100%;">
			</div>
			<div class="col-sm-6">
			<label for="lname">Last Name</label>
			<input type="text" value="'.$lname.'" class="form-control" id="lname" style="width:100%;">
			</div></div><br>
			<div class="row"><div class="col-sm-6">
			<label for="address">Address</label>
			<input type="text" value="'.$addr.'" class="form-control" id="address" style="width:100%;">
			</div><div class="col-sm-6">
			<label for="aff">Affiliated with</label>
			<input type="text" value="'.$aff.'" class="form-control" id="aff" style="width:100%;">
			</div></div>
			
			<br><div class="row"><div class="col-sm-6">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title">Dependents</h3>
			  </div>
			  <div class="panel-body">
			  	<a href="" id="addDepend">Add a dependent</a>
			  	</div>
			  	</div>
			</div>
			<div class="col-sm-6">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title">History</h3>
			  </div>
			  <div class="panel-body">Customer\'s history will display here</div>
			  	</div>
			</div></div></div>';
		echo '<br><div class="text-right"><button onClick="cancelAddCus()" class="btn btn-default" id="cancelCusBtn" type="button">Clear</button><button onClick="addCust()" class="btn btn-default" id="addCusBtn" type="button">Add New Customer</button></div>';
	}else{
		$conn = connect();
		//$query = 'SELECT * FROM customer NATURAL JOIN customer_history WHERE cid=:EIDBV';
		$query = 'SELECT * FROM customer WHERE cid=:EIDBV';
		
		$stid = oci_parse($conn, $query);
		oci_bind_by_name($stid, ":EIDBV", $id);
		$clear = oci_execute($stid);
		echo oci_error($stid)['message'];
		
		$cusId="";
		$fname="";
		$lname="";
		$addr="";
		$iid="";
		$time="";

		while ( ($row = oci_fetch_array($stid, OCI_BOTH) ) != false) {
			$cusId = $row['CID'];
			$fname=$row['FNAME'];
			$lname=$row['LNAME'];
			$addr=$row['ADDRESS'];
			$iid=$row['IID'];
			$time=$row['TIME'];
			$aff=$row['AFFILIATED'];
		}
		if($aff=='undefined')$aff='No affiliations were added';
			echo '<br><div class="form-group" style="margin:0 10px 0 10px;">
			<div class="row"><div class="col-sm-6">
			<label for="fname" class="control-label">First Name</label>
			<input type="text" value="'.$fname.'" class="form-control" id="fname" style="width:100%;" readonly="readonly">
			</div>
			<div class="col-sm-6">
			<label for="lname">Last Name</label>
			<input type="text" value="'.$lname.'" class="form-control" id="lname" style="width:100%;" readonly="readonly">
			</div></div><br>
			<div class="row"><div class="col-sm-6">
			<label for="address">Address</label>
			<input type="text" value="'.$addr.'" class="form-control" id="address" style="width:100%;" readonly="readonly">
			</div><div class="col-sm-6">
			<label for="aff">Affiliated with</label>
			<input type="text" value="'.$aff.'" class="form-control" id="email" style="width:100%;" readonly="readonly">
			</div></div>
			
			<br><div class="row"><div class="col-sm-6">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title">Dependents</h3>
			  </div>
			  <table class="table"><tr><th>Name</th><th>Age</th><th>M/F</th></tr>'.getCustDepend($cusId).'
			  </table>
			  	</div>
			</div>
			<div class="col-sm-6">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title">History</h3>
			  </div>
			  <table class="table"><tr><th>Item</th><th>Qty</th><th>Date</th></tr>'.getCustHistory($cusId).'
			  </table>
			  	</div>
			</div>			</div></div>';
			echo '<br><div class="text-right"><button onClick="editPro()" class="btn btn-default editProfile" type="button">Edit Profile</button>
			<div id="changeBtn" style="display:none;"><button class="btn btn-default" id="cancelEdit" type="button">Cancel</button><button class="btn btn-default" id="submitEdit" type="button">Submit</button></div>
			<form method="POST" action="checkOut.php?" style="display:inline;"><input type="number" name="id" value="'.$cusId.'" style="display:none;"/><input type="submit" class="btn btn-default editProfile" id="checkOutBtn" value="Check Out" name="checkBtn"/></form></div>';
		}
}//end getCusProfile function


//user clicked yes to "are you sure" - add new donor
function sureAdd($fname, $lname, $addr, $email){
	
	$conn = connect();
	$query = 'select MAX(did) from donor';
		$stid = oci_parse($conn, $query);
		oci_execute($stid);		
		echo oci_error($stid)['message'];
		
		while ( ($row = oci_fetch_array($stid, OCI_BOTH) ) != false) {
			$idCount = $row[0];
		}
		oci_free_statement($stid);
		oci_close($conn);
		
		$conn = connect();
		$did = $idCount+1;
		$query = "insert into donor (did, fname, lname, address, email) values('".$did."', '".$fname."', '".$lname."', '".$addr."', '".$email."')";
		
		//echo $query;
		
		/*
if(oci_bind_by_name($stid, ":id_bv", $did)==false)echo 'error in bind1';
		if(oci_bind_by_name($stid, ":fn_bv", $fname)==false)echo 'error in bind2';
		if(oci_bind_by_name($stid, ":ln_bv", $lname)==false)echo 'error in bind3';
		if(oci_bind_by_name($stid, ":ad_bv", $addr)==false)echo 'error in bind4';
		if(oci_bind_by_name($stid, ":em_bv", $email)==false)echo 'error in bind5';
*/
		
		$stid = oci_parse($conn, $query);
		oci_execute($stid);		
		echo oci_error($stid)['message'];
		oci_free_statement($stid);
		oci_close($conn);
		
		echo '<div class="alert alert-note alert-dismissible fade in" role="alert"><p>Donor Successfully Added</p></div>';
		
}//end add donor

//user clicked yes to "are you sure" - add new customer
function sureAddCustomer($fname, $lname, $addr, $aff){
	
	//$conn = connect();
	/*
$query = 'select MAX(did) from donor';
		$stid = oci_parse($conn, $query);
		oci_execute($stid);		
		echo oci_error($stid)['message'];
		
		while ( ($row = oci_fetch_array($stid, OCI_BOTH) ) != false) {
			$idCount = $row[0];
		}
		oci_free_statement($stid);
		oci_close($conn);
*/
		
		$conn = connect();
		//$did = $idCount+1;
		$cid=0;
		$query = "insert into customer (cid, fname, lname, address) values('".$cid."', '".$fname."', '".$lname."', '".$addr."')";
		
		echo $query;
		
		$stid = oci_parse($conn, $query);
		oci_execute($stid);		
		if(oci_error($stid)!=false){echo oci_error($stid)['message'];}else{echo '<div class="alert alert-note alert-dismissible fade in" role="alert"><p>Customer Successfully Added</p></div>';}
		oci_free_statement($stid);
		oci_close($conn);
				
}//end add customer


function editDonPro($fname, $lname, $addr, $email){
	
	$b_fnameCheck=false;$b_lnameCheck=false;$b_addrCheck=false;$b_emailCheck=false;
	$b_isEmail=false;
	$san_email = filter_var($email, FILTER_SANITIZE_EMAIL);
	$val_email = filter_var($san_email, FILTER_VALIDATE_EMAIL);
	if($email == $val_email)$b_isEmail=true;
	
	echo '<br><form><div class="form-group" style="margin:0 10px 0 10px;">
		<div class="row"><div class="col-sm-6">
			<label for="fname" class="control-label">First Name</label>';
			if($fname==''){echo '<input type="text" class="form-control" id="fname" style="width:100%;">
			<p style="color:#A94442;font-size:14px;">Please enter a first name</p>';}else{$b_fnameCheck=true;echo '<input value="'.$fname.'" type="text" class="form-control" id="fname" style="width:100%;">';}
		echo'</div>
		<div class="col-sm-6">
			<label for="lname">Last Name</label>';
			if($lname==''){echo '<input type="text" class="form-control" id="lname" style="width:100%;">
			<p style="color:#A94442;font-size:14px;">Please enter a last name</p>';}else{$b_lnameCheck=true;echo '<input value="'.$lname.'" type="text" class="form-control" id="lname" style="width:100%;">';}
		echo'</div></div><br>
		<div class="row"><div class="col-sm-6">
			<label for="address">Address</label>';
			if($addr==''){echo '<input type="text" class="form-control" id="address" style="width:100%;"><p style="color:#A94442;font-size:14px;">Please enter a valid address</p>';}else{$b_addrCheck=true;echo '<input value="'.$addr.'" type="text" class="form-control" id="address" style="width:100%;">';}
		echo'</div><div class="col-sm-6">
			<label for="email">Email</label>';
			if($email=='' || $b_isEmail==false){echo '<input type="text" class="form-control" id="email" style="width:100%;"><p style="color:#A94442;font-size:14px;">Please enter a valid email address</p>';}else{$b_emailCheck=true;echo '<input value="'.$email.'" type="text" class="form-control" id="email" style="width:100%;">';}
		echo'</div></div></div></form>';
		echo '<br><div class="text-right"><button onClick="editPro()" class="btn btn-default editProfile" type="button" style="display:none;">Edit Profile</button><div id="changeBtn"><button class="btn btn-default" id="cancelEdit" type="button" onClick="editPro()">Cancel</button><button onClick="subEditDon()" class="btn btn-default" id="submitEdit" type="button">Submit</button></div><form method="POST" action="printReceipts.php?" style="display:inline;"><input type="number" name="id" value="'.$donId.'" style="display:none;"/><input style="display:none;" type="submit" class="btn btn-default editProfile" id="printReceiptBtn" value="View and Print Receipt" name="receiptBtn"/></form>
		</div>';	
}


function subEditDon($id, $fname, $lname, $address, $email){

	$conn = connect();
/* 	$query = 'UPDATE donor SET fname=":fn_bv", lname=":ln_bv", address=":ad_bv", email=":em_bv" WHERE did=":id_bv"'; */
	$query ="UPDATE donor SET fname='".$fname."', lname='".$lname."', address='".$address."', email='".$email."' WHERE did='".$id."'";

		/*
if(oci_bind_by_name($stid, ":id_bv", $id)==false)echo 'error in bind1';
		if(oci_bind_by_name($stid, ":fn_bv", $fname)==false)echo 'error in bind2';
		if(oci_bind_by_name($stid, ":ln_bv", $lname)==false)echo 'error in bind3';
		if(oci_bind_by_name($stid, ":ad_bv", $addr)==false)echo 'error in bind4';
		if(oci_bind_by_name($stid, ":em_bv", $email)==false)echo 'error in bind5';
*/
	
	$stid = oci_parse($conn, $query);
	$clear = oci_execute($stid);
	
	if(oci_error($stid)!=false){
		echo oci_error($stid)['message'];
	}else{
		echo 'Donor Successfully Updated';
	}
}//end subEditDon




function addDonPro($fname, $lname, $addr, $email){
	$b_fnameCheck=false;$b_lnameCheck=false;$b_addrCheck=false;$b_emailCheck=false;
	$b_isEmail=false;
	$san_email = filter_var($email, FILTER_SANITIZE_EMAIL);
	$val_email = filter_var($san_email, FILTER_VALIDATE_EMAIL);
	if($email == $val_email)$b_isEmail=true;
	
	echo '<br><form><div class="form-group" style="margin:0 10px 0 10px;">
		<div class="row"><div class="col-sm-6">
			<label for="fname" class="control-label">First Name</label>';
			if($fname==''){echo '<input type="text" class="form-control" id="fname" style="width:100%;">
			<p style="color:#A94442;font-size:14px;">Please enter a first name</p>';}else{$b_fnameCheck=true;echo '<input value="'.$fname.'" type="text" class="form-control" id="fname" style="width:100%;">';}
		echo'</div>
		<div class="col-sm-6">
			<label for="lname">Last Name</label>';
			if($lname==''){echo '<input type="text" class="form-control" id="lname" style="width:100%;">
			<p style="color:#A94442;font-size:14px;">Please enter a last name</p>';}else{$b_lnameCheck=true;echo '<input value="'.$lname.'" type="text" class="form-control" id="lname" style="width:100%;">';}
		echo'</div></div><br>
		<div class="row"><div class="col-sm-6">
			<label for="address">Address</label>';
			if($addr==''){echo '<input type="text" class="form-control" id="address" style="width:100%;"><p style="color:#A94442;font-size:14px;">Please enter a valid address</p>';}else{$b_addrCheck=true;echo '<input value="'.$addr.'" type="text" class="form-control" id="address" style="width:100%;">';}
		echo'</div><div class="col-sm-6">
			<label for="email">Email</label>';
			if($email=='' || $b_isEmail==false){echo '<input type="text" class="form-control" id="email" style="width:100%;"><p style="color:#A94442;font-size:14px;">Please enter a valid email address</p>';}else{$b_emailCheck=true;echo '<input value="'.$email.'" type="text" class="form-control" id="email" style="width:100%;">';}
		echo'</div></div></div></form>';
		if($b_fnameCheck==true&&$b_lnameCheck==true&&$b_addrCheck==true&&$b_emailCheck==true){echo '<br><div class="text-right"><button onClick="cancelAddDon()" class="btn btn-default" id="cancelDonBtn" type="button">Cancel</button><button onClick="alert()" class="btn btn-default" id="addDonBtn" type="button">Add New Donor</button></div>';
		echo '<div class="alert alert-note alert-dismissible fade in" role="alert">
<p>Are you sure this information is correct?</p>
<p><button class="btn btn-default" aria-label="Close" data-dismiss="alert" type="button">
No</button>
<button onClick="sureAddDon()" class="btn btn-primary" type="button">Yes</button>
</p></div>';
		}else{
		echo '<br><div class="text-right"><button onClick="cancelAddDon()" class="btn btn-default" id="cancelDonBtn" type="button">Cancel</button><button onClick="addDonor()" class="btn btn-default" id="addDonBtn" type="button">Add New Donor</button></div>';}

}



function addCusPro($fname, $lname, $addr, $aff){
	$b_fnameCheck=false;$b_lnameCheck=false;$b_addrCheck=false;$b_affCheck=false;
	
	echo '<br><form><div class="form-group" style="margin:0 10px 0 10px;">
		<div class="row"><div class="col-sm-6">
			<label for="fname" class="control-label">First Name</label>';
			if($fname==''){echo '<input type="text" class="form-control" id="fname" style="width:100%;">
			<p style="color:#A94442;font-size:14px;">Please enter a first name</p>';}else{$b_fnameCheck=true;echo '<input value="'.$fname.'" type="text" class="form-control" id="fname" style="width:100%;">';}
		echo'</div>
		<div class="col-sm-6">
			<label for="lname">Last Name</label>';
			if($lname==''){echo '<input type="text" class="form-control" id="lname" style="width:100%;">
			<p style="color:#A94442;font-size:14px;">Please enter a last name</p>';}else{$b_lnameCheck=true;echo '<input value="'.$lname.'" type="text" class="form-control" id="lname" style="width:100%;">';}
		echo'</div></div><br>
		<div class="row"><div class="col-sm-6">
			<label for="address">Address</label>';
			if($addr==''){echo '<input type="text" class="form-control" id="address" style="width:100%;"><p style="color:#A94442;font-size:14px;">Please enter a valid address</p>';}else{$b_addrCheck=true;echo '<input value="'.$addr.'" type="text" class="form-control" id="address" style="width:100%;">';}
		echo'</div><div class="col-sm-6">
			<label for="aff">Affiliated with</label>';
			if($aff==''){echo '<input type="text" class="form-control" id="email" style="width:100%;"><p style="color:#A94442;font-size:14px;">No affiliation was entered</p>';}else{$b_affCheck=true;echo '<input value="'.$aff.'" type="text" class="form-control" id="aff" style="width:100%;">';}
		echo'</div></div>
			<br><div class="row"><div class="col-sm-6">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title">Dependents</h3>
			  </div>
			  <div class="panel-body">
			  	<a href="" id="addDepend">Add a dependent</a>
			  	</div>
			  	</div>
			</div>
			<div class="col-sm-6">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title">History</h3>
			  </div>
			  <div class="panel-body">Customer\'s history will display here</div>
			  	</div>
			</div></div></div></form>';
		if($b_fnameCheck==true&&$b_lnameCheck==true&&$b_addrCheck==true){echo '<br><div class="text-right"><button onClick="cancelAddCus()" class="btn btn-default" id="cancelCusBtn" type="button">Cancel</button><button onClick="alert()" class="btn btn-default" id="addCusBtn" type="button">Add New Customer</button></div>';
		echo '<div class="alert alert-note alert-dismissible fade in" role="alert">
<p>Are you sure this information is correct?</p>
<p><button class="btn btn-default" aria-label="Close" data-dismiss="alert" type="button">
No</button>
<button onClick="sureAddCus()" class="btn btn-primary" type="button">Yes</button>
</p></div>';
		}else{
		echo '<br><div class="text-right"><button onClick="cancelAddCus()" class="btn btn-default" id="cancelCusBtn" type="button">Cancel</button><button onClick="addCust()" class="btn btn-default" id="addCusBtn" type="button">Add New Customer</button></div>';}

}



	
	function getCustHistory($cusId){
		$conn = connect();
		$query = 'select * from customer_history where cid = :cusId_bv';
		
		$stid = oci_parse($conn, $query);
		oci_bind_by_name( $stid, ":cusId_bv", $cusId );
		oci_execute( $stid );
		//echo '<p>executed</p>';
		$return = "";
		//loop through results || should only be one result though
		//find a different way to get result without looping????
		while ( ( $row = oci_fetch_array( $stid, OCI_BOTH ) ) != false ) {
			$return = $return . '<tr><td>'. substr($row['CATEGORY'], 0, 3).'-'. $row['DETAILS'] .'</td><td>' . $row['QUANTITY'] . '</td><td>' . $row['TIME'] . '</td></tr>';
		}
		return $return;
	}
	function getCustDepend($cusId){
		$conn = connect();
		$query = 'select * from dependants where cid = :cusId_bv';
		
		$stid = oci_parse($conn, $query);
		oci_bind_by_name( $stid, ":cusId_bv", $cusId );
		oci_execute( $stid );
		//echo '<p>executed</p>';
		$return = "";
		//loop through results || should only be one result though
		//find a different way to get result without looping????
		while ( ( $row = oci_fetch_array( $stid, OCI_BOTH ) ) != false ) {
		if($row['GENDER']==1){
		$MF='F';}else{
		$MF='M';}
			$return = $return . '<tr><td>'. $row['NAME'].'</td><td>'.$row['AGE'] .'</td><td>' . $MF . '</td></tr>';
		}
		return $return;
	}

///////////////////////////////////////////////////////////////////
	function isLoggedIn( $thisconn ) {
		
		if ( isset( $_SESSION['LoggedIn'] ) && !empty( $_SESSION['LoggedIn'] ) ) {
			
			// u is for user
			$s_Username = base64_decode( $_SESSION['LoggedIn']['u'] );
			// p is for password
			$s_Password = base64_decode( $_SESSION['LoggedIn']['p'] );
			
			$b_LoggedIn = login( $s_Username, $s_Password, $thisconn );
			
			if ( $b_LoggedIn === true ) {
				
				// f is set for "Flag" to tell if the user is logged in;
				return;
			} else {
				unset( $_SESSION['LoggedIn'] );
			}
		}
		//die( "YOUR NOT LOGGED IN!!!" );
		header( 'Location:loginPage.php' );
	}
	
	function login($username, $password, $thisconn){
	
		$query = "SELECT * FROM sysuser WHERE username = :EIDBV";
	/* 	$password = md5($password); */
	
		$stid = oci_parse( $thisconn, $query );
		oci_bind_by_name( $stid, ":EIDBV", $username );
		oci_execute( $stid );
		//echo '<p>executed</p>';
	
		//loop through results || should only be one result though
		//find a different way to get result without looping????
		while ( ( $row = oci_fetch_array( $stid, OCI_BOTH ) ) != false ) {
			// Use the uppercase column names for the associative array indices
			//echo '<p>looking at query</p>';
			
			if( trim( (string)$row['PASS'] ) == trim( (string)$password ) ){
				//echo $password;
				//echo '<p>login correct!#%@$%</p>';
				$s_Username = base64_encode( $username );
				$s_Password = base64_encode( $password );
				$b_LoggedIn = 'true';
				$n_Admin = $row['ADMIN'];
				
				$_SESSION['LoggedIn']['u'] = $s_Username;
				$_SESSION['LoggedIn']['p'] = $s_Password;
				$_SESSION['LoggedIn']['f'] = $b_LoggedIn;
				$_SESSION['LoggedIn']['a'] = $n_Admin;
	/* 			echo '<meta http-equiv="refresh" content="0;URL=\'./addItems.php\'" />'; */
				return true;
			}
		}
		return false;
	}//login function
	
	function logOut(){
		session_reset();
		
	}
	
	function isAdmin(){
		if(isset ($_SESSION['LoggedIn']['a']) && $_SESSION['LoggedIn']['a'] == 1)
			return true;
		return false;
	}
	
	//Makes a standard connection to the database and returns the pointer.
	function connect(){
		// Create connection to Oracle
		$conn = oci_connect(DBUSER, DBPASSWORD, DBHOST);

		if (!$conn) {
			$m = oci_error();
			echo $m['message']. "\n";
			exit;
		}
		else {
			//echo "connected";
		}
		return $conn;
	}
	
	//prints an option HTML for each donor found in the database
	//  Form: <option value= [DonorId]> [Donor's name] </option>
	function getDonors(){
		// Get connection object
		$conn = connect();

		$query = 'select * from donor order by DID ';
		
		//echo "$query";
		$stid = oci_parse($conn, $query);

		//echo "parsed";
		$clear = oci_execute($stid);
		//echo "Queried";
		
		//Put query into select options
		while ( ($row = oci_fetch_array($stid, OCI_BOTH) ) != false) {
			echo "<option value=\"" . $row['DID'] . "\">" . $row['FNAME'] . ' ' . $row['LNAME'] . "</option>"; 
		/* Option values are added by looping through the array */ 
		}
	}
	
	//prints an option HTML for each Category found in the database
	//  Form: <option value= [Category]> [Category]</option>
	function getCategories(){
		// Get connection object
		$conn = connect();

		//Query Database
		$query = 'select unique category from item order by category';
		//echo $query;
		$stid = oci_parse($conn, $query);
		//echo "parsed";
		$clear = oci_execute($stid);
		//echo "Queried";
						

		//Put query into select options
		while ( ($row = oci_fetch_array($stid, OCI_BOTH) ) != false) {
			echo "<option value=\"" . $row['CATEGORY'] . "\">" . $row['CATEGORY'] . "</option>"; 
			/* Option values are added by looping through the array */ 
		}
	}
	
	//prints an option HTML for each Item found in the database that maches the Category given
	//  Form: <option value= [Item Id]> [Item name]</option>
	function getItemsIn($category){
		//$category = $_GET['category'];
		echo "<option value = \"NA\">Select</option>";
		$conn = connect();
						
		//Query Database
		if(strcmp($category, "All") == 0){
			$query = 'select  * from item order by category, details';
		}
		else if($category != false){
			$query = 'select  * from item where category = :EIDBV order by category, details';
		}
		else{
			$query = 'select  * from item order by category, details';
		}
						
		//echo $query;
		$stid = oci_parse($conn, $query);
		oci_bind_by_name($stid, ":EIDBV", $category);
		//echo "parsed";
		$clear = oci_execute($stid);
		//echo "Queried";
						

		//Put query into select options
		while ( ($row = oci_fetch_array($stid, OCI_BOTH) ) != false) {
			echo "<option value=\"" . $row['IID'] . "\">" .substr($row['CATEGORY'], 0, 3).'- '. $row['DETAILS'] . "</option>"; 
			/* Option values are added by looping through the array */ 
		}
	}

	function setPrice($itemId, $newPrice){
		$conn = connect();
		$query = 'update item set VALUE = :value_bv where IID = :itemId_bv';
		echo $query;
		$stid = oci_parse($conn, $query);
		echo 'parsed';
		if(!oci_bind_by_name($stid, ":value_bv", $newPrice))
			echo 'fail in bind 1';
		if(!oci_bind_by_name($stid, ":itemId_bv", $itemId))
			echo 'fail in bind 2';
		echo "bind success";
		$clear = oci_execute($stid);
	}
	
	//Increments the inventory and updates the donates table 
	function incrementInventory($itemId, $qty, $donorId){
		//No category selected
		if(strcmp($itemId, "NA") == 0){
			echo "No item was selected";
			exit;
		}
	
		if($qty < 1){
			echo "please specify an amount greater than zero";
			exit;
		}
		
		if($donorId == null){
			echo "please select a donor";
			exit;
		}
		
		$conn = connect();
		
		//Define query
		$query = 'update item set quantity = quantity + :increase_bv where iid = :itemId_bv';
	
						
		//echo ($query);
		$stid = oci_parse($conn, $query);
	
		if(oci_bind_by_name($stid, ":increase_bv", $qty) == false)
			echo 'error in binding1';
	
		if(oci_bind_by_name($stid, ":itemId_bv", $itemId) == false)
			echo 'error in binding2';
	
	
	
		//echo "parsed";
		//var_dump($stid);
		$clear = oci_execute($stid);
		$e = oci_error($stid);
		echo($e['message']);
	
		if($clear == true){
			//echo '<p>successful!!</p>';
			oci_commit($stid);
		}
		else{
			echo 'error attempting to update the database';
		}
		//echo "Queried";
		oci_free_statement($stid);
	
		$query = 'insert into donates (did, iid, quantity, userid) values (:donorid_bv, :itemid_bv, :increase_bv, :user_bv)'; 
		$stid = oci_parse($conn, $query);
		
		$username = base64_decode($_SESSION['LoggedIn']['u']);
		if($username == null){
			echo "sysuser id is null";
			exit;
		}
		//echo $username;
		if(oci_bind_by_name($stid, ":donorid_bv", $donorId) == false)
			echo 'error in bind3';
		if(oci_bind_by_name($stid, ":itemid_bv", $itemId) == false)
			echo 'error in bind4';
		if(oci_bind_by_name($stid, ":increase_bv", $qty) == false)
			echo 'error in bind5';
		if(oci_bind_by_name($stid, ":user_bv", $username) == false)
			echo 'error in bind6';
	
		$clear = oci_execute($stid);
		$e = oci_error($stid);
		echo($e['message']);
	
		if(clear == true)
			echo 'success';
	
		else
			echo 'error attempting to update the database';

		oci_free_statement($stid);
		oci_close($conn);
	}
	
	//Adds a new item type, updates the donates table, if increase is set it will update the inventory as well
	function addNewItemType($donorId, $category, $newCat, $details, $increase, $value){
		//New category selected
		if(strcmp($category, "newCat") == 0){
			$category = $newCat;
		}
	
		//No item field value
		if(strcmp($details, "") == 0){
			echo 'item field blank';
			exit;
		}
	
		if($increase < 0){
			echo 'Quantity cannot be less than zero';
			exit;
		}
		
		if($value < 0){
			echo 'Value cannot be less than zero';
			exit;
		}
		
		//echo ($category ."". $details ."". $increase);
		//echo "here";
		//include_once 'db_config.php';
		//include("functions.php");
	
		// Create connection to Oracle
		$conn = connect();
	
		//Check to see if the item type already exists
		$query = 'select iid from item where category = :category_bv and details = :details_bv';
		$stid = oci_parse($conn, $query);
		if(oci_bind_by_name($stid, ":category_bv", $category) == false)
			echo 'binding error on category';
		if(oci_bind_by_name($stid, ":details_bv", $details) == false)
			echo 'binding error on details';	
	
		oci_execute($stid);
	
		while ( ($row = oci_fetch_array($stid, OCI_BOTH) ) != false) {
			echo "Item type already exists in Inventory";
			exit;
		}
		oci_free_statement($stid);
	
		//Define query
		$query = 'insert into item (category, details, value, quantity) values (:category_bv, :details_bv, :value_bv, :increase_bv)';
		//echo ($query);
		$stid = oci_parse($conn, $query);
		//echo "prebind $increase , $category , $details , $value";
		if(oci_bind_by_name($stid, ":increase_bv", $increase) == false)
			echo 'binding error on quantity';
	
		if(oci_bind_by_name($stid, ":category_bv", $category) == false)
			echo 'binding error on category';
	
		if(oci_bind_by_name($stid, ":details_bv", $details) == false)
			echo 'binding error on details';	
	
		if(oci_bind_by_name($stid, ":value_bv", $value) == false)
			echo 'binding error on value';
	
	
		//echo "parsed";
		//var_dump($stid);
		$clear = oci_execute($stid);
		$e = oci_error($stid);
		echo($e['message']);
	
		if($clear == true){
			//echo '<p>successful!!</p>';
			oci_commit($stid);
		}
		else{
			echo 'error attempting to update the database';
		}
		//echo "Queried";
		oci_free_statement($stid);
		oci_close($conn);
	
		if($increase == 0){
			echo 'success';
			exit;
		}
	
		$conn = connect();
	
		$query = 'select iid from item where details = :details_bv and category = :cat_bv';
		$stid = oci_parse($conn, $query);
		if(oci_bind_by_name($stid, ":cat_bv", $category) == false)
			echo 'binding error on category';
		if(oci_bind_by_name($stid, ":details_bv", $details) == false)
			echo 'binding error on details';
		oci_execute($stid);
		$itemId = 0;
		while ( ($row = oci_fetch_array($stid, OCI_BOTH) ) != false) {
			$itemId = $row['IID'];
		}
		oci_free_statement($stid);
	
		$query = 'insert into donates (did, iid, quantity, userid) values (:donorid_bv, :itemid_bv, :increase_bv, :user_bv)'; 
		$stid = oci_parse($conn, $query);
		
		$username = base64_decode($_SESSION['LoggedIn']['u']);
		if($username == null){
			echo "sysuser id is null";
			exit;
		}
		//echo "prebind $donorId , $itemId , $increase";
		if(oci_bind_by_name($stid, ":donorid_bv", $donorId) == false)
			echo 'error in bind3';
		if(oci_bind_by_name($stid, ":itemid_bv", $itemId) == false)
			echo 'error in bind4';
		if(oci_bind_by_name($stid, ":increase_bv", $increase) == false)
			echo 'error in bind5';
		if(oci_bind_by_name($stid, ":user_bv", $username) == false)
			echo 'error in bind6';
	
		$clear = oci_execute($stid);
		$e = oci_error($stid);
		echo($e['message']);
	
		if($clear == true)
			echo 'success';

		else
			echo 'error attempting to update the database';
	
		oci_free_statement($stid);
		oci_close($conn);
	}
	
	function getCustomersLike($text){
		$query = 'select * from customer';
		$conn = connect();
		
		if(strcmp($text, "") != 0)
			$query = 'select * from customer where fname like :text_bv% or lname like :text_bv% or address like :text_bv%';

		$stid = oci_parse($conn, $query);

		if(strcmp($text, "") != 0)
			if(oci_bind_by_name($stid, ":text_bv", $text) == false)
				echo 'error in bind text';

		oci_execute($stid);

		while ( ($row = oci_fetch_array($stid, OCI_BOTH) ) != false) {
			echo '<li class="list-group-item" id="' . $row['CID'] . '">' . $row['LNAME'] . ', ' . $row['FNAME'] . ' - ' . $row['ADDRESS'] . '</li>';
		}
	}
	
	function getItemList($category, $searchText){
		$conn = connect();
		$query = '';
		
		if($searchText != false)
			$searchText = strtoupper ($searchText) . '%';
		//Query Database
		if(strcmp($category, "All") == 0){
			if($searchText !=false)
				$query = 'select  * from item where upper(details) like :search_bv order by category, details';
			else
				$query = 'select  * from item order by category, details';
		}
		else if($category != false){
			if($searchText !=false)
				$query = 'select  * from item where category = :EIDBV and upper(details) like :search_bv order by category, details';
			else
				$query =  'select  * from item where category = :EIDBV order by category, details';
		}
		else{
			$query = 'select  * from item order by category, details';
		}
		$stid = oci_parse($conn, $query);
		oci_bind_by_name($stid, ":EIDBV", $category);
		oci_bind_by_name($stid, ":search_bv", $searchText);
		//echo "parsed";
		$clear = oci_execute($stid);
		//echo "Queried";
						
		echo oci_error($stid)['message'];
		//Put query into select options
		while ( ($row = oci_fetch_array($stid, OCI_BOTH) ) != false) {
			echo "<a id=\"items" . $row['IID'] . "\" class=\"list-group-item\">" .substr($row['CATEGORY'], 0, 3).'- '. $row['DETAILS'] . "</a>"; 
			/* Option values are added by looping through the array */ 
		}
	}
	
	function checkout($customerId, $itemId, $qty){
		$conn = connect();
		$query = "insert into checksout (cid, iid, username, quantity) values (:cid_bv, :iid_bv, :user_bv, :quantity_bv)";
		$stid = oci_parse($conn, $query);
		
		oci_bind_by_name($stid, ":cid_bv", $customerId);
		oci_bind_by_name($stid, ":iid_bv", $itemId);
		$username = base64_decode($_SESSION['LoggedIn']['u']);
		oci_bind_by_name($stid, ":user_bv", $username);
		oci_bind_by_name($stid, ":quantity_bv", $qty);
		
		oci_execute($stid);
		
		echo oci_error($stid)['message'];
		
		oci_free_statement($stid);
		
		$query = 'update item set quantity = quantity - :dec_bv where iid = :itemId_bv';
		$stid = oci_parse($conn, $query);
		oci_bind_by_name($stid, ":dec_bv", $qty);
		oci_bind_by_name($stid, ":itemId_bv", $itemId);
		
		oci_execute($stid);
		echo oci_error($stid)['message'];
		
		oci_free_statement($stid);
		oci_close($conn);
		
		echo 'success';
	}
	
	function printReceipt ($donorId, $startDate){
		// yyyy-mm-dd
		$year = substr($startDate, 0, 4);
		$month = substr($startDate, 5, 2);
		$day = substr($startDate, 8, 2);
		if(checkdate($month, $day, $year) == false){
			echo 'invalid date';
			exit;
		}
		$conn = connect();
		// $query = 'select sum(quantity) AS total, details from DONATED_ITEMS_VIEW where did = :donorid_bv group by category, details';
		$query = "select sum(quantity) AS total, category, details, sum(totalval) as totalval from DONATED_ITEMS_VIEW where did = :donorid_bv and time > to_date(:start_bv, 'yyyy-mm-dd') group by category, details";
		
		$stid = oci_parse($conn, $query);
		oci_bind_by_name($stid, ':donorid_bv', $donorId);
		oci_bind_by_name($stid, ':start_bv', $startDate);
		
		oci_execute($stid);
		echo oci_error($stid)['message'];
		
		$subtotal = 0;
		
		echo '------------------------------------------------<table>
				<tbody>';
		while ( ($row = oci_fetch_array($stid, OCI_BOTH) ) != false) {
			echo '<tr><td>' . $row['CATEGORY'] . " - " . $row['DETAILS'] ."</td><td>|</td><td style=\"text-align:right\">" . $row['TOTAL'] . '</td><td>|</td><td style="text-align:right">$ ' . $row['TOTALVAL'] . '</td></tr>';
			$subtotal += $row['TOTALVAL'];
		}
		echo "	<tr>
					<td>-------</td><td>|</td>
					<td>-------</td><td>|</td>
					<td>-------</td>
				</tr>
			  </tbody><tfoot>
				<tr>
					<td>Grand total:</td><td>|</td>
					<td>-------</td><td>|</td>
					<td style=\"text-align:right\"> $ $subtotal</td>
				</tr>
			  </tfoot></table>------------------------------------------------";
	}
	
	
	
	
	
	
	
	
	
	
	
	
?>