<?php

require_once("sec.php");

if(!session_id()) {
    sec_session_start();
}

if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    die();
}

?>


<!DOCTYPE html>
<html lang="sv">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="pic/favicon.png">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="css/site.min.css" />
		<title>Messy Labbage</title>
	</head>
	<body>
		<div id="container">
			<div id="messageboard">
		        <input type="hidden" id="CSRFtoken" value="<?php echo $_SESSION['CSRFtoken']; ?>" />
			    <a class="btn btn-danger" id="buttonLogout" href="logout.php">Logout</a>
				<div id="messagearea"></div>
				<p id="numberOfMess">
					Antal meddelanden: <span id="nrOfMessages">0</span>
				</p>
				Name:
				<br />
				<input id="inputName" type="text" name="name" />
				<br />
				Message:
				<br />
				<textarea name="mess" id="inputText" cols="55" rows="6"></textarea>
				<input class="btn btn-primary" type="button" id="buttonSend" value="Write your message" />
				<span class="clear">&nbsp;</span>
			</div>
		</div>

		<script src="js/jquery-1.10.2.min.js"></script>
		<script src="js/site-0.2.min.js"></script>
		<script>
			$(document).ready(function() {
				MessageBoard.getAllMessages();
			});
		</script>
	</body>
</html>