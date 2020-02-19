<?php
include_once("setup.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$conn_id = setup_connect()
or die ("cannot connect to server");

$hashpword = $_SESSION['pword'];

$email = $_SESSION['user'];
$mysqli_stmt = $conn_id->prepare("SELECT email, pword FROM users WHERE email = ? AND pword = ?;");
$mysqli_stmt->bind_param("ss", $email, $hashpword);

$mysqli_stmt->execute();
$result = $mysqli_stmt->get_result();
$row = $result->fetch_assoc();

if ($hashpword != $row['pword']) {
    header("Location: index.html"); 
    //$output .= "<p>Login Successful</p>";
}


?>