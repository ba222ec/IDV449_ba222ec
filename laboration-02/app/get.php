<?php

require_once("sec.php");

$CSRFtoken = $_POST["CSRFtoken"] != null ? $_POST["CSRFtoken"] : "";



// add check for login user
if($_POST['function'] == 'getAllMessages') {
    if (checkUser($CSRFtoken)) {
        echo(json_encode(getAllMessages()));
    }    
}
elseif($_POST['function'] == 'getNewMessages') {
    
    $timestamp = $_POST['timestamp'];
    $again = true;
    $turns = 0;

    if ($timestamp != null && checkUser($CSRFtoken)) {
        while ($again && $turns <= 50) {
            $result = getNewMessages($timestamp);
            
            if ($result) {
                echo(json_encode($result));
                $again = false;
            } else {
                $turns += 1;
                usleep(500000);
            }
        }
    }
}

function getAllMessages() {
    $db = null;
    
	try {
	    $db = new PDO("sqlite:data/db.db");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
	    $q = "SELECT * FROM messages";
		$stm = $db->prepare($q);
		$stm->execute();
		$result = $stm->fetchAll();
        
        $db = null;
        
        if($result) {
            return $result;
        } else {
            return false;
        }

	} catch(PDOException $e) {
	    $db = null;
		echo("Ett serverfel inträffade.");
		return false;
	}
}

function getNewMessages($timestamp) {
    $db = null;
    
    try {
        $db = new PDO("sqlite:data/db.db");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $q = "SELECT * FROM messages WHERE timestamp > ?";
        $param = array($timestamp);
        $stm = $db->prepare($q);
        $stm->execute($param);
        $result = $stm->fetchAll();

        $db = null;

        if($result) {
            return $result;
        } else {
            return false;
        }

    } catch(PDOException $e) {
        $db = null;
        die("Ett serverfel inträffade.");
    }
}