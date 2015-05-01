<?php
//need session_start at the top of every page
session_start();
include_once 'db_config.php';
include_once 'functions.php';
//require 'Retired Functions/Test.php';

$conn = oci_connect(DBUSER, DBPASSWORD, DBHOST);

if (!$conn) {
	$m = oci_error();
	echo $m['message'], "\n";
	exit;
} else {
	if( isset( $_POST['uname'] ) ) {
		// the value inside the brackets comes from the name attribute of the input field. (just like submit above)
		$username = $_POST['uname'];
		$passwd = md5( $_POST['passwd'] );
		$b_LoginResponse = login($username, $passwd, $conn);
		$b_hasError = false;
		if ( $b_LoginResponse === true ) {
		
			header( 'Location:home.php' );
			
		}else if( $b_LoginResponse === false){
		
			$b_hasError = true;

		}
	}
}
if($b_hasError == true){$s_error = "Incorrect username or password";}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>Login Page</title>	
	
	<link rel="stylesheet" type="text/css" href="./css/bootstrap.css">
   	<link rel="stylesheet" type="text/css" href="./css/bootstrap-responsive.css">
   	<link rel="stylesheet" type="text/css" href="./css/custom.css">   	
   	
   	<style>
   	.form-horizontal {
   		background: none repeat scroll 0 0 #f5f5f5;
	    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.13);
	    font-weight: 400;
	    margin-left: 0;
	    margin-top: 20px;
	    overflow: hidden;
	    padding: 26px 24px 46px;
	    border-radius: 6px;
    }
   	</style>
</head>
<body>
	<div class="container" style="margin:auto;width:320px;">
		<img src="./images/gRootLogo.png" alt="Grassroot Givers Logo" class="img-responsive" style="margin-top:20px !important;margin-left:-15px;margin:auto;background-color:rgba(255, 255, 255, 0.5);border-radius:100px;">
		<div>
			<form class="form-horizontal" method="post">
				<div class="form-group has-feedback has-feedback-left">
					<input type="text" class="form-control" id="uname" name="uname" placeholder="Username"/>
					<i class="form-control-feedback glyphicon glyphicon-user"></i>
				</div>
				<div class="form-group has-feedback has-feedback-left">
					<input type="password" class="form-control" id="passwd" name="passwd" placeholder="Password"/>
					<i class="form-control-feedback glyphicon glyphicon-lock"></i>
				</div>
				<?php if($b_hasError==true){ ?><p class="help" style="color: #A94442;"><?php echo $s_error; ?></p><?php } ?>
				<button type="submit" class="btn btn-success" id="logIn" name="logIn" style="margin:auto;width:100%;">Log In</button>
				<br>
				<span style="float:right;margin:auto;overflow:hidden;padding:15px 15px 0;text-align:center;width:100%;margin-bottom:-25px !important;">Do not wait for leaders; do it alone, person to person <br>-Mother Teresa</span>
			</form>
		</div>
	</div><!--End container-->
</body>
</html>
