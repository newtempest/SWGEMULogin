<?php
/**
 * File: Register.php
 * Subset of the Generic SWGEMU Login System v1.0
 * 
 * by Todd South
 * September 6, 2015
 * 
 * A HTML/PHP script file that registers a username and
 * password into a database table used by the SWGEMU
 * Core3 server for user management within MySQL
 * (using MySQLi).
 * 
 * MySQL database expectations are:
 * 
 * DB: swgemu
 * TABLE: accounts
 * FIELDS:
 *    account_id  int(10) unsigned primary_key auto_increment
 *    username    varchar(32)
 *    password    varchar(255)
 *    station_id  int(10) unsigned
 *    created     timestamp CURRENT_TIMESTAMP
 *    active      tinyint(1) default 1
 *    admin_level tinyint(1) default 0
 *    salt        varchar(32)
 * 
 * To keep this simple, the relevant contents of the 
 * /home/swgemu/run/conf/config.lua file should be copied
 * into ./includes/Conn.php (lines 53-58).
 * 
 * Be sure to format for PHP. Using the Fast-Track VM,
 * that information would translate to:
 * 
 * <?php
 * $DBHost = "127.0.0.1";
 * $DBPort = "3306";
 * $DBName = "swgemu";
 * $DBUser = "swgemu";
 * $DBPass = "123456";
 * $DBSecret = "swgemus3cr37!";
 * ?>
 * 
 * fin
 */

	//Destroy any sessions
    session_start();
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');
    session_regenerate_id(true);
?>
<?php require 'includes/Conn.php'; ?>
<?php
		//Test two input passwords to match.
		if ($_POST["Password"] == $_POST["Confirm_Password"]) {

			//Hit the Register button? Then register the user
			if(isset($_POST['Register'])) {
			//Start session.
			session_start();
			//Transfer inputs to var.
			$Username = $_POST['Username'];
			$PW = $_POST['Password'];
			//Generate a random Station ID
			$StationID = mt_rand();
			//Generate a 32 character salt.
			$Salt32 = generateSalt32();
			//Combine DBSecret.PW.Salt32
			$hashme = $DBSecret.$PW.$Salt32;
			//Create hashed password to store
			$StorePassword = hash('sha256', $hashme);

			//Create connection string and execute query
			$sql = $con->query("INSERT INTO accounts (username, password, station_id, salt)Values('{$Username}', '{$StorePassword}', '{$StationID}', '{$Salt32}')");

			//Go to the Login page to allow user to login
			header('Location: Login.php');
			}

	} else {
	// Failed two input passwords. failed :(
	session_start();
	$_SESSION["RegisterFail"] = "Yes";
}
?>

<!doctype html>
<html>
<head>
<link href="css/Master.css" rel="stylesheet" type="text/css" />
<link href="css/Menu.css" rel="stylesheet" type="text/css" />
<!-- <script type="text/javascript" src="./js/change.js"></script> -->
<meta charset="utf-8">
<title>Register</title>
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
			<form action="Register.php" method="post" name="RegisterForm" id="RegisterForm" onsubmit="return checkForm(this);>
                <div class="FormElement"><input name="Username" required class="TField" id="field_username" placeholder="Username" title="Username must not be blank and contain only letters, numbers and underscores" type="text" pattern="\w+" >&nbsp;</div>&nbsp;<br>
                <div class="FormElement"><input name="Password" type="password" required class="TField" placeholder="Password" id="Password" title="Password must contain at least 8 characters, including UPPER/lowercase and numbers. Both password entries must match." pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" onchange="
  this.setCustomValidity(this.validity.patternMismatch ? this.title : '');
  if(this.checkValidity()) form.Confirm_Password.pattern = this.value;
"></div>&nbsp;<br>
				<div class="FormElement"><input name="Confirm_Password" type="password" required class="TField" id="Confirm_Password" title="Please enter to confirm the same Password as above." pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Repeat Password" onchange="
  this.setCustomValidity(this.validity.patternMismatch ? this.title : ''); "></div><br><br>
<!--
                <div><p><img id="captcha" src="/captcha.php" width="160" height="45" border="1" alt="CAPTCHA">
					<small><a href="#" onclick="document.getElementById('captcha').src = './captcha.php?' + Math.random(); document.getElementById('captcha_code').value = ''; return false;">refresh</a></small></p> <p><input id="captcha_code" type="text" name="captcha" size="6" maxlength="5" onkeyup="this.value = this.value.replace(/[^\d]+/g, '');"><small>copy the digits from the image into this box</small></p></div>
-->                
				<div class="FormElement"><input name="Register" type="submit" class="button" id="Change" value="Register"></div>
			</form>
		</div>
		<div class="Footer"></div>
	</div>
</body>
</html>

