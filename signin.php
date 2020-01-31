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

$output = "";

define('DB_SERVER', 'localhost:3036');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'rootpassword');
define('DB_DATABASE', 'database');

if (isset($_POST['submit'])) {

$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

$uname = $_POST['uname'];
$pword = hash('sha256', $_POST['pword']);

$loginQuery = "SELECT * FROM users WHERE username = ? AND password = ?";
$stmt = mysqli_prepare($conn, $loginQuery);
mysqli_stmt_bind_param($stmt, "ss", $uname, $pword);
$result = mysqli_stmt_execute($stmt);

if($result) {
    $output += "<p>Login Successful</p>"
}
else {
    $output ++ "<p>Username or Password Incorrect</p>"
}
}
?>
</main>
</body>
