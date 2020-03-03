<?php
include "setup.php";
//include "security.php";

$conn_id = setup_connect()
	or die ("cannot connect to server");
$userID =1;
//$userID = $_SESSION['id']
$paperID = $_GET['id'];
$uni=$_GET['uni'];
$module =$_GET['module'];
$year=$_GET['year'];
$season=$_GET['season'];

$path = "papers/$uni/$module/$year/$season/$paperID.pdf";

$answers = "<section id='answers'>
				<iframe style='display: none;' name='target'></iframe>
				<form action='view.php?ID=$paperID&uni=$uni&module=$module&year=$year&season=$season' method='post'>
					<label for='selectQ'>Select a question: </label>
					<select id='selectQ' name='Question' form='viewQuestionNumber.php'>
						<option value=1 selected>1</option>";

// Query the papers table to check the number of questions in this paper and populates a drop down list based on this number
$query = $conn_id->prepare("SELECT questions FROM papers WHERE id = ?;");
$query->bind_param("s", $paperID);
$query->execute()
	or die("Cannot execute query");
$qs=$query->get_result();

while ($row = mysqli_fetch_assoc($qs)) {
	$noQ = $row['questions'];
	for ($i = 2; $i <= $noQ; $i++) {
		$answers .=
						"<option value='$i'>$i</option>";
	}
}

$answers .=
					"</select>
				</form>";

if (isset($_POST['question'])) {
	$question = $_POST['question'];
} else {
	$question = 1;
}

// Gets all the answers by each question, allows answer for selected q to be shown and others to be hidden
for ($i=1; i++; i<=$noQ) {

	$query = $conn_id->prepare("SELECT * FROM answers WHERE paperID = ? and question = ?  ORDER BY votes;");
	$query->bind_param("ss", $paperID, $i);
	$query->execute()
		or die("Cannot execute query");
	$result = $query->get_result();

while ($row = mysqli_fetch_assoc($result)) {
	$answerID = $row['id'];
	$posterID = $row['userID'];
	$votes = $row['votes'];
	$timestamp =$row['postTime'];
	$answer=$row['answer'];
	
	$query1 = "SELECT fname, lname, accType FROM users WHERE ID = $posterID;";
	$result1 = mysqli_query($conn_id, $query1)
		or die("Cannot execute query");
	
	while ($row = mysqli_fetch_assoc($result1)) {
		$fname=$row['fname'];
		$lname=$row['lname'];
		$accType=$row['accType'];
	}
	
	// Queries the votes database to check if this user has already voted on this answer
	$query2 = $conn_id->prepare("SELECT vote FROM votes WHERE userID=? AND answerID=?;");
	$query2->bind_param("ss", $userID, $answerID);
	$query2->execute()
		or die("Cannot execute query");
	$result2 = $query2->get_result();

	// If the user has voted on this answer, upvoted is set to up if they have upvoted, down if downvoted, no if didnt vote
	if (mysqli_num_rows($result2)>0) {
		$row = mysqli_fetch_assoc($result2);
		$voteValue=$row['vote'];
		if ($voteValue >1) {
			$voted="up";
		} else {
			$voted="down";
		}
	} else {
		$voted="noVote";
	}
	
	// Checks the account type of the person who submitted the answer to highlight tutor answers
	if ($accType=='tutor') {
		$details="tutorDetails";
	} else {
		$details="studentDetails";
	}

	$answers .=
		"<div class='submission, question$i>
			<div class='$details'>
				<p class='fname'>$fname</p>
				<p class='lname'>$lname</p>
				<p class='timestamp'>$timestamp</p>
			</div>
			<div class='voting $voted'>
				<a href='upvote.php/?answerID=$answerID&userID=$userID&voted=$voted' class='upvote' target='target'><img src='/icons/upvote.svg'></a
				<p class='votes' id='$answerID'>$votes</p>
				<a href='downvote.php/?answerID=$answerID&userID=$userID&voted=$voted' class='downvote' target='target'><img src='/icons/downvote.svg'></a>
			</div>
			<div class='answer'>
				<p>$answer</p>
			</div>
		 </div>";
}
}

$answers .= "</section>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Required meta tags -->statecontent
	<meta charset="utf-8" />
	<meta
    	name="viewport"
    	content="width=device-width, initial-scale=1, shrink-to-fit=no"
	/>
	<link rel="icon" href="img/favicon.png" type="image/png" />
	<link rel="stylesheet" type="text/css" href="styles.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#selectQ').change(function() {
        			$('.submission').hide();
        			$('.' + $(this).val()).show();    
    			});
		});
	</script>
	<title>Exam Paper View</title>
</head>
<body>
	<iframe id='paper' src="<?php echo $path; ?>" width=900 height=900></iframe>
	<?php echo $answers; ?>
</body>
