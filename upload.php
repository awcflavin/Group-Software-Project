<?php
session_start();
include "setup.php";
$course=$_POST["course"];
$module=$_POST["module"];
$season=$_POST["season"];
$year=$_POST["year"];
$server = "127.0.0.1";
$database = "mydb";
$username = "root";
$password = "Bluey1999";
$college="UCC";
printf($course);
printf($module);
printf($season);
printf($year);
#$_SESSION["ID"];
#$filename=$_SESSION["ID"];
#$_SESSION["Test"]="hello";
#echo $_SESSION["ID"];
//mkdir("test", 0700);
#echo $filename;
#echo $_POST["last_name"];
$college="UCC";
if (!file_exists("uploads/".$college."/".$course."/".$module)) {
    mkdir("uploads/".$college."/".$course."/".$module, 0777, true);
}
$target_dir = "uploads/".$college."/".$course."/".$module."/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    $uploadOk = 1;

}


// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}


// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
/*
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "pdf" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}*/
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir.$year."_".$season."."."pdf")) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}



// Create connection
$conn = setup_connect();
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO Papers (College, Course,Module, Season, Year)
VALUES ('$college','$course', '$module', '$season', '$year');";

$result_id = mysqli_query ($conn, $sql)
or die ("Cannot execute query". $conn -> error);


?>
