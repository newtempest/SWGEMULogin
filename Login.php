<?php
/**
 * File: Login.php
 * Subset of the Generic SWGEMU Login System v1.0
 * 
 * by Todd South
 * September 6, 2015
 * 
 * A HTML/PHP script file that logs into the MySQL
 * accounts database table used by the SWGEMU 
 * Core3 server for user management within MySQL.
 * 
 * Refer to Register.php for DB structure.
 * 
 * fin
 */
    session_start();
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');
    session_regenerate_id(true);
?>
<?php require 'includes/Conn.php'; ?>
<?php
	if(isset($_POST['Login'])) {
		
		session_start();
		//Transfer inputs to var.
		$Username = $_POST['Username'];
		$PW = $_POST['Password'];
		
		//Match query to username row
		$result = $con->query("select * from accounts where username='$Username'");
		
		//Execute
		$row = $result->fetch_array(MYSQLI_BOTH);
		
		//Grab stored password hash
		$hashFromDB = $row['password'];
		
		//Grab stored salt
		$Salt32 = $row['salt'];
		
		//Combine into comparison hash
		$hashme = $DBSecret . $PW . $Salt32;

		//Hash current password to compare
		$currentHash = hash('sha256', $hashme);

		//Stored hash match current from password input?		
		if ($hashFromDB === $currentHash) {
		//yes
		session_start();
		
		$_SESSION["account_id"] = $row['account_id'];
		
		header('Location: Account.php');
		}else{
			session_start();
			$_SESSION["LoginFail"] = "Yes";
		}
	}
?>
<!doctype html>
<html>
<head>
<link href="css/Master.css" rel="stylesheet" type="text/css" />
<link href="css/Menu.css" rel="stylesheet" type="text/css" />
<meta charset="utf-8">
<title>Login</title>
</head>

<body>
	<div class="Container">
		<div class="Header"></div>
		<div class="Menu">
			<div id="Menu">
				 <nav>
					<ul class="cssmenu">
						
						<li><a href="Register.php">Register</a></li>	
								
						<li><a href="Login.php">Login</a></li>		
					</ul>
				 </nav>
			</div>
		</div>
		<div class="LeftBody"></div>
		<div class="RightBody">
			<form name="LoginForm" action="" method="post">
				<?php if(isset($_SESSION["LoginFail"])){ ?>
                <div class="FormElement">Login Failed! Please Try Again.</div>
                <?php } ?>
              <div class="FormElement">
                <input name="Username" type="text" required class="TField" id="Username" placeholder="Username"><br><br>
                </div>
                <div class="FormElement">
                <input name="Password" type="password" required class="TField" id="Password" placeholder="Password"><br><br>
                </div>
                <div class="FormElement">
                <input name="Login" type="submit" class="button" id="Login" value="Login">
                </div>
			</form>
		</div>
		<div class="Footer"></div></div>
</body>
</html>
