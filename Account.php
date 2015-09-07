<?php
/**
 * File: Account.php
 * Subset of the Generic SWGEMU Login System v1.0
 * 
 * by Todd South
 * September 6, 2015
 * 
 * A HTML/PHP script file that acts as the account
 * portal authorized by logging into the MySQL
 * accounts database table used by the SWGEMU 
 * Core3 server for user management within MySQL.
 * 
 * Refer to Register.php for DB structure.
 * 
 * fin
 */
?>
<?php require 'includes/Conn.php'; ?>
<?php
session_start();
//Is this the indexed session from account_id?
if(isset($_SESSION["account_id"])){
//If not, go to Login.php
}else{
	header('Location: Login.php');
}
	//Get my index
	session_start();
	
	$acct = $_SESSION["account_id"];
	//Match query to account_id row
	$result = $con->query("select * from accounts where account_id='$acct'");
	
	//Execute
	$row = $result->fetch_array(MYSQLI_BOTH);
		

?>

<!doctype html>
<html>
<head>
<link href="css/Master.css" rel="stylesheet" type="text/css" />
<link href="css/Menu.css" rel="stylesheet" type="text/css" />
<meta charset="utf-8">
<title>Account</title>
</head>

<body>
	<div class="Container">
		<div class="Header"></div>
		<div class="Menu">
			<div id="Menu">
				 <nav>
					<ul class="cssmenu">
						
						<li><a href="ChangePW.php">Change Pass</a></li>		
								
						<li><a href="Logout.php">Logout</a></li>		
					</ul>
				 </nav>
			</div>
		</div>
		<div class="LeftBody"></div>
		<div class="RightBody">Your Account<br>
        <!-- Display account information -->
        <!-- <br><?php echo $_SESSION["account_id"]; ?><br><br> -->
		
		<br><?php echo 'Username: ' . $row['username']; ?><br><br>
		
		</div>
		<div class="Footer"></div></div>
</body>
</html>
