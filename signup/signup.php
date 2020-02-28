<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("setup.php");
$conn_id = setup_connect()
    or die("cannot connect to server");
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
if (!$uppercase || !$lowercase || !$number || $pwordlen < 8 || $pwordlen > 16) {
    $output .= "<p>Invalid Password: Passwords must be between 8 and 16 characters long and contain an uppercase letter, lowercase letter, and a digit</p>";
}

//Check if the passwords match
if ($pword != $pword1) {
    $output .= "<p>Passwords do not match</p>";
}

//Check if the email is valid
if ($uni == "University College Cork") {
    if ($accType == "student") {
        $studentEmailUCC = preg_match('/^[0-9]{1,9}@umail.ucc.ie$/', $email);
        if (!$studentEmailUCC) {
            $output .= "<p>Invalid student E-mail for University College Cork</p>";
        }
    } else {
        $tutorEmailUCC = preg_match('/^[0-9A-Za-z]{1,20}[@](?:[0-9A-Za-z]{1,20}.ucc.ie|ucc.ie)$/', $email);
        if (!$tutorEmailUCC) {
            $output .= "<p>Invalid staff E-mail for University College Cork</p>";
        }
    }
}

if ($output == "") {
    $mysqli_stmt = $conn_id->prepare("INSERT INTO users(fname, lname, pword, accType, uni, email) VALUES (?, ?, ?, ?, ?, ?);");
    $hashpword = hash('sha224', $pword);
    $mysqli_stmt->bind_param("ssssss", $fname, $lname, $hashpword, $accType, $uni, $email);
    mysqli_stmt_execute($mysqli_stmt);
    $output .= "<p>Account creation successful</p>";
    $_SESSION["college"] = $uni;
    $_SESSION["user"] = $email;
    $_SESSION["pword"] = $hashpword;
    $_SESSION["accType"] = $accType;
    if ($accType == "tutor") {
        header("Location: ../tutor-upload.php");
    } else if ($accType == "student") {
        header("Location: ../courses.php");
    } else {
        echo "fail";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">
    <link rel="stylesheet" href="css/home_button.css" />
    <nav class="navbar navbar-expand-lg navbar-light">

        <div class="container">
            <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                <ul class="nav navbar-nav menu_nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="../index.html"><i class="fa fa-home"></i> Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Title Page-->
    <title>Au Register Forms by Colorlib</title>

    <!-- Icons font CSS-->
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i"
        rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/main.css" rel="stylesheet" media="all">
</head>

<body>
    <div class="page-wrapper bg-gra-03 p-t-45 p-b-50">
        <div class="wrapper wrapper--w790">
            <div class="card card-5">
                <div class="card-heading">
                    <h2 class="title">Event Registration Form</h2>
                </div>
                <div class="card-body">
                    <?php
                        echo  $output ;
                    ?>
                    <form action="signup.php" method="POST">
                        <div class="form-row m-b-55">
                            <div class="name">Name</div>
                            <div class="value">
                                <div class="row row-space">
                                    <div class="col-2">
                                        <div class="input-group-desc">
                                            <input class="input--style-5" type="text" name="fname" required>
                                            <label class="label--desc">first name</label>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="input-group-desc">
                                            <input class="input--style-5" type="text" name="lname" required>
                                            <label class="label--desc">last name</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>





                        <div class="form-row">
                            <div class="name">University</div>
                            <div class="value">
                                <div class="input-group">
                                    <div class="rs-select2 js-select-simple select--no-search">
                                        <select name="uni" required>
                                            <option disabled="disabled" selected="selected">Choose option</option>
                                            <option>University College Cork</option>
                                            <option>University College Limerick</option>
                                            <option>University College Galway</option>
                                        </select>
                                        <div class="select-dropdown"></div>
                                    </div>
                                </div>
                            </div>
                        </div>














                        <div class="form-row">
                            <div class="name">Email</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" type="email" name="email" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="name">Password</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" type="Password" name="pword" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="name">Confirm Password</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" type="Password" name="pword1" required>
                                </div>
                            </div>
                        </div>




                        <div class="form-row p-t-20">
                            <label class="label label--block">I am a:</label>
                            <div class="p-t-15">
                                <label class="radio-container m-r-55">Student
                                    <input value="student" type="radio" checked="checked" name="accType">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="radio-container">Tutor
                                    <input value="tutor" type="radio" name="accType">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>





                        <div>
                            <button class="btn btn--radius-2 btn--red" type="submit">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/datepicker/moment.min.js"></script>
    <script src="vendor/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="js/global.js"></script>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<!-- end document-->