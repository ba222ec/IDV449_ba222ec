<?php

/**
Just som simple scripts for session handling
*/
function sec_session_start() {
        $session_name = 'sec_session_id'; // Set a custom session name
        $secure = false; // Set to true if using https.
        ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies.
        $cookieParams = session_get_cookie_params(); // Gets current cookies params.
        session_set_cookie_params(3600, $cookieParams["path"], $cookieParams["domain"], $secure, false);
        $httponly = true; // This stops javascript being able to access the session id.
        session_name($session_name); // Sets the session name to the one set above.
        session_start(); // Start the php session
        session_regenerate_id(); // regenerated the session, delete the old one.
}

function checkUser() {
	if(!session_id()) {
		sec_session_start();
	}

	if(!isset($_SESSION["user"])) {header('HTTP/1.1 401 Unauthorized'); die("401 Unauthorized");}

	$user = getUser($_SESSION["user"]);
	$un = $user[0]["username"];

	if(isset($_SESSION['login_string'])) {
		if($_SESSION['login_string'] !== hash('sha512', "123456" + $un) ) {
			header('HTTP/1.1 401 Unauthorized'); die("401 Unauthorized");
		}
	}
	else {
		header('HTTP/1.1 401 Unauthorized'); die("401 Unauthorized");
	}
	return true;
}

function isUser($u, $p) {
    $db = null;

	try {
		$db = new PDO("sqlite:db.db");
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOEception $e) {
		die("Ett serverfel inträffade.");
	}

    try {
    	$q = "SELECT id FROM users WHERE username = ? AND password = ?";
        $param = array($u, $p);
	
		$stm = $db->prepare($q);
		$stm->execute($param);
        
		$result = $stm->fetchAll();
		if($result) {
			return true;
		} else {
		    return false;
		};
	}
	catch(PDOException $e) {
		echo("Ett serverfel inträffade.");
		return false;
	}
}

function getUser($user) {
	$db = null;

	try {
		$db = new PDO("sqlite:db.db");
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOEception $e) {
		die("Ett serverfel inträffade.");
	}
	
    try {
    	$q = "SELECT * FROM users WHERE username = ?";
        $param = array($user);
    
		$stm = $db->prepare($q);
		$stm->execute($param);
        
		$result = $stm->fetchAll();
	}
	catch(PDOException $e) {
		echo("Ett serverfel inträffade.");
		return false;
	}

	return $result;
}

function logout() {
	if(!session_id()) {
		sec_session_start();
	}
	session_end();
	header('Location: index.php');
}
