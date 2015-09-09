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

require_once __DIR__.'/Settings.php'
function getDatabaseConnection() {
	$con = new mysqli(Settings::DB_HOST, Settings::DB_USER, Settings::DB_PASS, Settings::DB_NAME, Settings::DB_PORT);
	return $con;
}
?>
