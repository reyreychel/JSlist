<?php
/*
$config['base_url']='127.0.0.1';
//Database
$db['hostname'] = '127.0.0.1';
$db['username'] = 'root';
$db['password'] = '';
$db['database'] = 'list';
$db['dbdriver'] = ' mysql';

 
/* Attempt to connect to MySQL database */
//$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
//if($link === false){
  //  die("ERROR: Could not connect. " . mysqli_connect_error());
//}
/*

	$link = new mysqli($db['hostname'],$db['username'],$db['password'], $db['database']);
		if ($link -> connect_errno) {//check the connection
			print "Failed to connect to MySQL: (" . $mysqli_conn -> connect_errno . ") " . $mysqli_conn -> connect_error;
		}
*/
try{
	$pdo = new PDO("mysql:host=127.0.0.1;dbname=list", "root", "");
		// Set the PDO error mode to exception
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e){
		die("ERROR: Could not connect. " . $e->getMessage());
	}
?>