<?php
include "setup.php";
include "security.php";

$conn_id = setup_connect()
	or die ("cannot connect to server");

$userID = $_SESSION['id']
$paperID = $_GET['id'];
$uni=$_GET['uni'];
$module =$_GET['module'];
$year=$_GET['year'];
$season=$_GET['season'];

$path = "papers/$uni/$module/$year/$season/$paperID.pdf";

$answers = "<section id='answers'>
				<iframe style='display: none' name='target'></iframe>
				<div id='rightside'>
				<label for='selectQ'>Select a question: </label>
				<select id='selectQ' name='Question'>
					<option value='1'>1</option>";

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
				<p><a href='submit.php?paperID=$paperID'>Submit an Answer</a></p>";

// If the link is accessed without question param set it defaults to question 1
if (isset($_POST['question'])) {
	$question = $_POST['question'];
} else {
	$question = 1;
}

// Gets all the answers by each question, allows answer for selected q to be shown and others to be hidden
for ($x=1; $x<=$noQ; $x++) {

	$query = $conn_id->prepare("SELECT * FROM answers WHERE paperID = ? and question = ?  ORDER BY votes;");
	$query->bind_param("ss", $paperID, $x);
	$query->execute()
		or die("Cannot execute query");
	$result = $query->get_result();

while ($row = mysqli_fetch_assoc($result)) {
	$answerID = $row['id'];
	$posterID = $row['userID'];
	$votes = $row['votes'];
	$timestamp =$row['postTime'];
	$answer=$row['answer'];
	
	// Gets the details of the person who psoted the answer
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
		"<div class='submission question$x'>
			<div class='$details'>
				<p class='fname'>$fname</p>
				<p class='lname'>$lname</p>
				<p class='timestamp'>$timestamp</p>
			</div>
			<div class='voting $voted'>
				<a href='upvote.php?answerID=$answerID&userID=$userID&voted=$voted' class='upvote' target='target' onclick='vote($votes+1, $answerID)'><img src='icons/downvote.svg'></a>
				<p class='votes' id='$answerID'>$votes</p>
				<a href='downvote.php?answerID=$answerID&userID=$userID&voted=$voted' class='downvote' target='target' onclick='vote($votes-1, $answerID)'><img src='icons/upvote.svg'></a>
			</div>
			<div class='answer'>
				<p>$answer</p>
			</div>
		 </div>";
}
}

$answers .= "
	</section></div>";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <link rel="icon" href="img/favicon.png" type="image/png" />
    <title>Elements</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/flaticon.css" />
    <link rel="stylesheet" href="css/themify-icons.css" />
    <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css" />
    <link rel="stylesheet" href="vendors/nice-select/css/nice-select.css" />
    <!-- main css -->
    <link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="styles.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
    			$('#selectQ').change(function() {
        			$('.submission').hide();
        			$('.question' + $(this).val()).show();    
    			});
		});

		function vote(newValue, id) {
			document.getElementById(id).innerHTML = newValue;
		};
	</script>
  </head>

  <body>
    <!--================ Start Header Menu Area =================-->
    <header class="header_area white-header">
      <div class="main_menu">
        <div class="search_input" id="search_input_box">
          <div class="container">
            <form class="d-flex justify-content-between" method="" action="">
              <input
                type="text"
                class="form-control"
                id="search_input"
                placeholder="Search Here"
              />
              <button type="submit" class="btn"></button>
              <span
                class="ti-close"
                id="close_search"
                title="Close Search"
              ></span>
            </form>
          </div>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light">
          <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <a class="navbar-brand" href="index.html">
              <img class="logo-2" src="img/logo2.png" alt="" />
            </a>
            <button
              class="navbar-toggler"
              type="button"
              data-toggle="collapse"
              data-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent"
              aria-expanded="false"
              aria-label="Toggle navigation"
            >
              <span class="icon-bar"></span> <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div
              class="collapse navbar-collapse offset"
              id="navbarSupportedContent"
            >

              <ul class="nav navbar-nav menu_nav ml-auto">
                <li class="nav-item">
                  <a class="nav-link" href="index.html">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="about-us.html">About</a>
                </li>
                <li class="nav-item submenu dropdown active">
                  <a
                    href="#"
                    class="nav-link dropdown-toggle"
                    data-toggle="dropdown"
                    role="button"
                    aria-haspopup="true"
                    aria-expanded="false"
                    >Pages</a
                  >
                  <ul class="dropdown-menu">
                    <li class="nav-item">
                      <a class="nav-link" href="courses.html">Courses</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="course-details.html"
                        >Course Details</a
                      >
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="elements.html">Elements</a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item submenu dropdown">
                  <a
                    href="#"
                    class="nav-link dropdown-toggle"
                    data-toggle="dropdown"
                    role="button"
                    aria-haspopup="true"
                    aria-expanded="false"
                    >Blog</a
                  >
                  <ul class="dropdown-menu">
                    <li class="nav-item">
                      <a class="nav-link" href="blog.html">Blog</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="single-blog.html"
                        >Blog Details</a
                      >
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="contact.html">Contact</a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link search" id="search">
                    <i class="ti-search"></i>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      </div>
    </header>
    <!--================ End Header Menu Area =================-->

    <!--================Home Banner Area =================-->
    <section class="banner_area">
      <div class="banner_inner d-flex align-items-center">
        <div class="overlay"></div>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-6">
              <div class="banner_content text-center">
                <h2><?php printf($uni); ?></h2>
                <div class="page_link">
                  <a href="index.html">Home</a>
                  <a href="elements.html">Elements</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--================End Home Banner Area =================-->
<main>

		<iframe id='paper' src="<?php echo $path; ?>" width=900 height=900></iframe>
		<?php echo $answers; ?>
					

</main>
	<!-- End Align Area -->

	<!--================ Start footer Area  =================-->
    <footer class="footer-area section_gap">
			<div class="container">
			  <div class="row">
				<div class="col-lg-2 col-md-6 single-footer-widget">
				  <h4>Top Products</h4>
				  <ul>
					<li><a href="#">Managed Website</a></li>
					<li><a href="#">Manage Reputation</a></li>
					<li><a href="#">Power Tools</a></li>
					<li><a href="#">Marketing Service</a></li>
				  </ul>
				</div>
				<div class="col-lg-2 col-md-6 single-footer-widget">
				  <h4>Quick Links</h4>
				  <ul>
					<li><a href="#">Jobs</a></li>
					<li><a href="#">Brand Assets</a></li>
					<li><a href="#">Investor Relations</a></li>
					<li><a href="#">Terms of Service</a></li>
				  </ul>
				</div>
				<div class="col-lg-2 col-md-6 single-footer-widget">
				  <h4>Features</h4>
				  <ul>
					<li><a href="#">Jobs</a></li>
					<li><a href="#">Brand Assets</a></li>
					<li><a href="#">Investor Relations</a></li>
					<li><a href="#">Terms of Service</a></li>
				  </ul>
				</div>
				<div class="col-lg-2 col-md-6 single-footer-widget">
				  <h4>Resources</h4>
				  <ul>
					<li><a href="#">Guides</a></li>
					<li><a href="#">Research</a></li>
					<li><a href="#">Experts</a></li>
					<li><a href="#">Agencies</a></li>
				  </ul>
				</div>
				<div class="col-lg-4 col-md-6 single-footer-widget">
				  <h4>Newsletter</h4>
				  <p>You can trust us. we only send promo offers,</p>
				  <div class="form-wrap" id="mc_embed_signup">
					<form
					  target="_blank"
					  action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01"
					  method="get"
					  class="form-inline"
					>
					  <input
						class="form-control"
						name="EMAIL"
						placeholder="Your Email Address"
						onfocus="this.placeholder = ''"
						onblur="this.placeholder = 'Your Email Address'"
						required=""
						type="email"
					  />
					  <button class="click-btn btn btn-default">
						<span>subscribe</span>
					  </button>
					  <div style="position: absolute; left: -5000px;">
						<input
						  name="b_36c4fd991d266f23781ded980_aefe40901a"
						  tabindex="-1"
						  value=""
						  type="text"
						/>
					  </div>
	  
					  <div class="info"></div>
					</form>
				  </div>
				</div>
			  </div>
			  <div class="row footer-bottom d-flex justify-content-between">
				<p class="col-lg-8 col-sm-12 footer-text m-0 text-white">
				  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="ti-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
				</p>
				<div class="col-lg-4 col-sm-12 footer-social">
				  <a href="#"><i class="ti-facebook"></i></a>
				  <a href="#"><i class="ti-twitter"></i></a>
				  <a href="#"><i class="ti-dribbble"></i></a>
				  <a href="#"><i class="ti-linkedin"></i></a>
				</div>
			  </div>
			</div>
		  </footer>
		  <!--================ End footer Area  =================-->
	  
		  <!-- Optional JavaScript -->
		  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
		  <script src="js/jquery-3.2.1.min.js"></script>
		  <script src="js/popper.js"></script>
		  <script src="js/bootstrap.min.js"></script>
		  <script src="vendors/nice-select/js/jquery.nice-select.min.js"></script>
		  <script src="vendors/owl-carousel/owl.carousel.min.js"></script>
		  <script src="js/owl-carousel-thumb.min.js"></script>
		  <script src="js/jquery.ajaxchimp.min.js"></script>
		  <script src="js/mail-script.js"></script>
		  <!--gmaps Js-->
		  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
		  <script src="js/gmaps.min.js"></script>
		  <script src="js/theme.js"></script>
		</body>
	  </html>
