<!DOCTYPE html>
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<header>
    <h1>Exam Solutions</h1>
    <ul>
        <li><a href="index.html">Login</a></li>
        <li><a href="signup.html">Sign Up</a></li>
    </ul>
</header>
<main>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("setup.php");
   $conn_id = setup_connect()
 or die ("cannot connect to server");

$output = "";
$pword = $_POST['pword'];

$email = $_POST['email'];
$hashpword = hash('sha224', $pword);

$mysqli_stmt = $conn_id->prepare("SELECT email, pword FROM users WHERE email = ? AND pword = ?;");
$mysqli_stmt->bind_param("ss", $email, $hashpword);

$mysqli_stmt->execute();
$result = $mysqli_stmt->get_result();
$row = $result->fetch_assoc();

if ($hashpword == $row['pword']) {
    $output .= "<p>Login Successful</p>";
}
else {
    $output .= "<p>Login Unsuccessful</p>";
}

echo $output;
?>
</main>
</body>
