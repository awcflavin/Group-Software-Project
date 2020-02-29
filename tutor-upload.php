<?php
session_start();
include "setup.php";
include "tutor-security.php";
$conn_id = setup_connect()
 or die ("cannot connect to server");

$college=$_SESSION["college"];



$sql = "SELECT DISTINCT Course FROM Papers where College='$college'";



$result_id = mysqli_query ($conn_id, $sql)
or die ("Cannot execute query");
# read & display results of query, then clean up
# DATA_PRINT_LOOP

$coursestr="";



while ($row = mysqli_fetch_assoc ($result_id)){
	$coursestr.="<div class='col-md-4'>
						<div class='single-defination'>
							<h4 class='mb-20'>";
     $coursestr.=   $row["Course"];

     $coursestr.="</h4>
			
						</div>
					</div>";
    }

$conn_id->close();
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
                <h2><?php printf($college); ?> Portal Uploader</h2>
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


	<!-- Start Sample Area -->

	<!-- End Sample Area -->
	<!-- Start Button -->
	
	<!-- End Button -->
	<!-- Start Align Area -->
	<div class="whole-wrap">
		<div class="container">
		
			
			<div class="section-top-border">
				<div class="row">
					<?php
					
					?>
					
          <div class='col-md-4'>
            <div class='single-defination'>
              <h4 class='mb-20'></h4>
      

            <h3>Contribute an exam paper</h3>
            <h6>Please select a file</h6>

            <form action="upload.php" method="post" enctype="multipart/form-data">


<select  name="course" id="course">
  <option value="Computer Science" selected="Computer Science">Computer Science</option>
  <option value="Business Information Systems">Business Information Systems</option>
  <option value="Law">Law</option>
</select>

<select name="module" id="s">
  <option value="CS3505" selected="selected">CS3505</option>
  <option value="CS3518">CS3518</option>
  <option value="CS2506">CS2506</option>
</select>

              <select name="year" id="year">
  <option value="2020" selected="selected">2020</option>
  <option value="2019">2019</option>
  <option value="2018">2018</option>
  <option value="2017">2017</option>
    <option value="2016">2016</option>
  <option value="2015">2015</option>
  <option value="2014">2014</option>
  <option value="2013">2013</option>
    <option value="2012">2012</option>
  <option value="2011">2011</option>
  <option value="2010">2010</option>
  <option value="2009">2009</option>
</select>

<select  name="season" id="season">
  <option value="Summer" selected="selected">Summer</option>
  <option value="Winter">Winter</option>
  <option value="Autumn">Autumn</option>
</select>
    <input type="file" class="text-center center-block file-upload" name="fileToUpload" id="fileToUpload">
<br>
    <input type="submit" name="submit">
</div></div><!--/col-3-->
                    </form>










            </div>
          </div>





				</div>
			</div>
			
			
			</div>
		</div>
	</div>
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