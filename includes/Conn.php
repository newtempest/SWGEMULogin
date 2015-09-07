<?php
/**
 * File: includes/Conn.php
 * Subset of the Generic SWGEMU Login System v1.0
 * 
 * by Todd South
 * September 6, 2015
 * 
 * A HTML/PHP script file that provides connection 
 * parameters, hash secret, and salt generation
 * function for the Generic SWGEMU Login System.
 * 
 * Refer to Register.php for DB structure.
 * 
 * fin
 */
 
//Connection string order is: host, user, password, database
//Note table is 'accounts' in the swgemu MySQL DB model.

$con = mysqli_connect("localhost", "swgemu", "123456", "swgemu");

//Place the information in PHP variable formet(s).
$DBHost = "127.0.0.1";
$DBPort = "3306";
$DBName = "swgemu";
$DBUser = "swgemu";
$DBPass = "123456";
//Left it set to distribution secret
$DBSecret = "swgemus4cr37!";

//Generates a 32 character salt
function generateSalt32($max = 32) {
	$baseStr = time() . rand(0, 1000000) . rand(0, 1000000);
	$md5Hash = md5($baseStr);
	if($max < 32){
		$md5Hash = substr($md5Hash, 0, $max);
	}
	return $md5Hash;
}
?>
