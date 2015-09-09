<?php
/*  Utils.php
    Copyright (C) 2015 Andreas Rammhold

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as
    published by the Free Software Foundation, either version 3 of the
    License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.>
*/
require_once __DIR__.'/Settings.php'

function hashPassword($password, $salt=null, $secret=Settings::DBSECRET) {
	if ($salt != null) 
		return hash('sha256', $secret . $password . $salt);
	else
		return hash('sha1', $password);
}

function generateSalt32($max = Settings::SALT_LENGTH) {
	$rand_bytes = openssl_random_pseudo_bytes(32, TRUE);
	$md5Hash = md5($rand_bytes);
	if($max < 32){
		$md5Hash = substr($md5Hash, 0, $max);
	}
	return $md5Hash;
}
?>
