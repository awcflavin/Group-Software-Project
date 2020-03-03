<?php
session_start();
include "setup.php";
include "security.php";
$conn_id = setup_connect()
  or die("cannot connect to server");

$college = $_SESSION["college"];
$course = $_GET["course"];
$postid = $_GET["id"];
$commentid = $_GET["post_id"];
$replyid = $_GET["comment_id"];
$upvote = $_GET["upvote"]
$downvote = $_GET["downvote"]


$sql1_up = "UPDATE posts SET vote = 'vote +1' WHERE id = '$postid'";
$sql1_down = "UPDATE posts SET vote = 'vote - 1' WHERE id = '$postid'";

$sql2_up = "UPDATE comments SET vote = 'vote +1' WHERE post_id = '$commentid'";
$sql2_down = "UPDATE comments SET vote = 'vote +1' WHERE post_id = '$commentid'";

$sql3_up = "UPDATE replies SET vote = 'vote +1' WHERE coomment_id = '$replyid'";
$sql3_down = "UPDATE replies SET vote = 'vote -1' WHERE coomment_id = '$replyid'";


if(isset($_POST['upvote'])){
    $result_id = mysqli_query($conn_id, $sql1_up);
		or die("Cannot execute query");
}

if(isset($_POST['downvote'])){
    $result_id = mysqli_query($conn_id, $sql1_down);
		or die("Cannot execute query");
}



$conn_id->close();

?>