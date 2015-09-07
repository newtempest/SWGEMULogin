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
require_once 'includes/Conn.php';
session_start();
//Is this the indexed session from account_id?
if(!isset($_SESSION["account_id"])){
    header('Location: Login.php');
} else {
    $con = getDatabaseConnection();
    $account_id = $_SESSION["account_id"];
    //Match query to account_id row
    if ($stmt = $con->prepare("SELECT username FROM accounts WHERE account_id=?")) {
        $stmt->bind_param("i", $account_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
         $row = $result->fetch_assoc();
        } else {
            session_unset();
            header("Location: Login.php");
            exit(0); 
        }
    }
}
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
