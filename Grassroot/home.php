<?php require "header.php";
	$user =  base64_decode( $_SESSION['LoggedIn']['u'] );
	$adminRigts = isAdmin();
?>
<div class="container">
	<h1><u>Welcome <?php echo "$user";?>, to EAS</u></h1>
</div>
		
<div class="jumbotron container">
	<div class="center-block container">
		<?php
			if($adminRigts === true)
				echo '<p>Logged in as an administrator</p>';
			else 
				echo '<p>Logged in as a basic user</p>';
		?>
	</div>
</div>
<?php require "footer.html";?>