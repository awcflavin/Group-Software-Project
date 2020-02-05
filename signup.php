<!DOCTYPE html>
<head>
    <title>Create An Account</title>
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

if (isset($_POST['submit'])) {

$uname = $_POST['uname'];
$pword = $_POST['pword'];
$pword1 = $_POST['pword1'];
$uni = $_POST['uni'];
$accType = $_POST['acctype'];
$email = $_POST['email'];

$uppercase = preg_match('@[A-Z]@', $password);
$lowercase = preg_match('@[a-z]@', $password);
$number    = preg_match('@[0-9]@', $password);

$output = "";

define('DB_SERVER', 'localhost:3036');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'rootpassword');
define('DB_DATABASE', 'database');
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

//Check if the username is valid
if(strlen($uname)<=16) {
    $pwdQuery = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $pwdQuery);
    mysqli_stmt_bind_param($stmt, "s", $uname);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if($result) {
        $output += "<p>Username already exists</p>";
    }
}

//Check if the password is valid
if(!$uppercase || !$lowercase || !$number || strlen($password) < 8 || stlen($pword) > 16) {
  $output += "<p>Invalid Password: Passwords must be between 8 and 16 characters long and contain an uppercase letter, lowercase letter, and a digit</p>"
}

//Check if the passwords match
if($pword != $pword1) {
    $output += "<p>Error: Passwords do not match</p>"
}

//Check if the email is valid
if($uni == "University College Cork") {
    if(accType == "student") {
        $studentEmailUCC = preg_match('^[0-9]{1,9}@umail.ucc.ie$', email);
        if(!$studentEmailUCC) {
            $output += "<p>Invalid student E-mail for University College Cork</p>"
        }
    }
    else {
        $tutorEmailUCC = preg_match('^[0-9A-Za-z]{1,20}[@](?:[0-9A-Za-z]{1,20}.ucc.ie|ucc.ie)$');
        if(!tutorEmailUCC) {
            $output += "<p>Invalid staff E-mail for University College Cork</p>"
        }
    }
}

if($output == "") {
    $insertAcc = "INSERT INTO users(username, password, accType, university, email) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertAcc);
    mysqli_stmt_bind_param($stmt, "sssss", $uname, hash('sha224', $pword), $accType, $uni, $email);
    mysqli_stmt_execute($stmt);
    
    $output += "<p>Account creation successful</p>"
}
}
echo $output;
?>
</main>
</body>
