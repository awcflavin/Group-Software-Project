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
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("setup.php");
   $conn_id = setup_connect()
 or die ("cannot connect to server");

//if (isset($_POST['submit'])) {

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$pword = $_POST['pword'];
$pword1 = $_POST['pword1'];
$uni = $_POST['uni'];
$accType = $_POST['accType'];
$email = $_POST['email'];

$uppercase = preg_match('@[A-Z]@', $pword);
$lowercase = preg_match('@[a-z]@', $pword);
$number    = preg_match('@[0-9]@', $pword);

$output = "";

$pwordlen = strlen($pword);
//Check if the password is valid
if(!$uppercase || !$lowercase || !$number || $pwordlen < 8 || $pwordlen > 16) {
  $output .= "<p>Invalid Password: Passwords must be between 8 and 16 characters long and contain an uppercase letter, lowercase letter, and a digit</p>";
}

//Check if the passwords match
if($pword != $pword1) {
    $output .= "<p>Error: Passwords do not match</p>";
}

//Check if the email is valid
if($uni == "University College Cork") {
    if($accType == "student") {
        $studentEmailUCC = preg_match('/^[0-9]{1,9}@umail.ucc.ie$/', $email);
        if(!$studentEmailUCC) {
            $output .= "<p>Invalid student E-mail for University College Cork</p>";
        }
    }
    else {
        $tutorEmailUCC = preg_match('/^[0-9A-Za-z]{1,20}[@](?:[0-9A-Za-z]{1,20}.ucc.ie|ucc.ie)$/', $email);
        if(!$tutorEmailUCC) {
            $output .= "<p>Invalid staff E-mail for University College Cork</p>";
        }
    }
}

if($output == "") {
    $mysqli_stmt = $conn_id->prepare("INSERT INTO users(fname, lname, pword, accType, uni, email) VALUES (?, ?, ?, ?, ?, ?);");
    $hashpword = hash('sha224', $pword);
    $mysqli_stmt->bind_param("ssssss", $fname, $lname, $hashpword, $accType, $uni, $email);
    mysqli_stmt_execute($mysqli_stmt);  
    $output .= "<p>Account creation successful</p>";
    $_SESSION["college"]=$uni;
    $_SESSION["user"]=$email;
    $_SESSION["pword"]=$hashpword;
    $_SESSION["accType"]=$accType;
    if($accType=="tutor"){
        header("Location: ../tutor-upload.php");
    }
    else if($accType=="student"){
        header("Location: ../courses.php");

    }
    else{
        echo "fail";
    }

}
echo $output;
?>
</main>
</body>
