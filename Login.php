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

require_once 'includes/Conn.php';
require_once 'includes/Utils.php';

if(isset($_POST['Login']) && isset($_POST['Username'] && isset($_POST['Password']))) {
    $con = getDatabaseConnection(); 
    //Transfer inputs to var.
    $username = $_POST['Username'];
    $password = $_POST['Password'];
    
    //Match query to username row
    if ($stmt = $con->prepare("SELECT account_id, password, salt FROM accounts WHERE username=?")) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc(); 
            $storedPassword = $row['password'];
            $salt = $row['salt'];
            $account_id = $row['account_id'];
    
            if (hashPassword($password, $salt) == $storedPassword) {
                session_start();
                $_SESSION["account_id"] = $account_id;
                header('Location: Account.php');
                exit(0);
            }
        }
    }
    session_start();
    $_SESSION["LoginFail"] = "Yes";
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
