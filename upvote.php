<?php
include "setup.php";
include "security.php";

$conn_id = setup_connect()
	or die ("cannot connect to server");

$answerID=$_GET['answerID'];
$userID=$_GET['userID'];
$voted=$_GET['voted'];

if ($voted = "no") {
	
	$query = $conn_id->prepare("INSERT INTO votes (userID, answerID, vote) VALUES (?, ?, 1);");
	$query->bind_param("ss", $userID, $answerID);
	$query->execute()
		or die("Cannot execute query");

	$query = $conn_id->prepare("UPDATE answers SET votes = votes + 1 WHERE id = ?;");
	$query->bind_param("s", $answerID);
	$query->execute()
		or die("Cannot execute query");

} elseif ($voted = "down") {
	$query = $conn_id->prepare("UPDATE votes SET vote = 1 WHERE userID = ? AND answerID = ?);");
	$query->bind_param("ss", $userID, $answerID);
	$query->execute()
		or die("Cannot execute query");
	
	$query = $conn_id->prepare("UPDATE answers SET votes = votes + 1 WHERE id = ?;");
	$query->bind_param("s", $answerID);
	$query->execute()
		or die("Cannot execute query");
}

?>
	
