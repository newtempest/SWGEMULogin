<?php
/**
 * File: Logout.php
 * Subset of the Generic SWGEMU Login System v1.0
 * 
 * by Todd South
 * September 6, 2015
 * 
 * A HTML/PHP script file that acts as the logout
 * function for the Generic SWGEMU Login System.
 * 
 * Refer to Register.php for DB structure.
 * 
 * fin
 */
?>
<?php
    //Destroy any sessions
	session_start();
    unset($_SESSION["UserID"]);
	session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');
    session_regenerate_id(true);
?>

<!doctype html>
<html>
<head>
<link href="css/Master.css" rel="stylesheet" type="text/css" />
<link href="css/Menu.css" rel="stylesheet" type="text/css" />
<meta charset="utf-8">
<title>Logout</title>
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
		<div class="RightBody">You have logged out!</div>
		<div class="Footer"></div></div>
</body>
</html>
