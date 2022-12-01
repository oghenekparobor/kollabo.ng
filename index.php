<?php
session_start(); 
require("admin/database/connect.php");
$db = new DbConnect();
$con = $db->connect();

$date = date('D/M/Y h:i:s a');
$index = "current";

?>

<!doctype html>
<html lang="en">
<head>

<!-- Basic Page Needs
================================================== -->
<title>Kollabo | Home</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
================================================== -->
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/colors/blue.css">

<style>
	@media only screen and (max-device-width: 480px) { 
		#logo_img {
            padding: 20px;
        }
	}
</style>

</head>
<body>

<!-- Wrapper -->
<div id="wrapper" class="wrapper-with-transparent-header">

<!-- Header Container
================================================== -->
<header id="header-container" class="fullwidth transparent-header">

	<!-- Header -->
	<div id="header">
		<div class="container">
			
			<!-- Left Side Content -->
			<div class="left-side">
				
				<!-- Logo -->
				<div id="logo">
					<a href="index.php"><img src="images/logo2.png" id="logo_img" data-sticky-logo="images/logo.png" data-transparent-logo="images/logo.png" alt=""></a>
				</div>

				<!-- Main Navigation -->
				<nav id="navigation">
					<ul id="responsive">

						<li><a href="index.php" style="color: #278556;">Home</a></li>

						<li><a href="about.php">About Us</a></li>

						<li><a href="contact.php">Contact Us</a></li>

					</ul>
				</nav>
				<div class="clearfix"></div>
				<!-- Main Navigation / End -->
				
			</div>

			<div class="right-side">
			<nav id="navigation">
					<ul id="responsive">

						<li><a href="login.php">Login</a></li>
						
						<li><a href="register.php">Register</a></li>

					</ul>
				</nav>
			</div>
			<!-- Left Side Content / End -->

			<div class="right-side">

				<!-- Mobile Navigation Button -->
				<span class="mmenu-trigger">
					<button class="hamburger hamburger--collapse" type="button">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</button>
				</span>

			</div>
			<!-- Right Side Content / End -->

		</div>
	</div>
	<!-- Header / End -->

</header>
<div class="clearfix"></div>
<!-- Header Container / End -->



<!-- Intro Banner
================================================== -->
<div class="intro-banner dark-overlay" data-background-image="images/home-background-02.jpg">

	<!-- Transparent Header Spacer -->
	<div class="transparent-header-spacer"></div>

	<div class="container">
		
		<!-- Intro Headline -->
		<div class="row">
			<div class="col-md-12">
				<div class="banner-headline">
					<h3>
						<strong>Hire experts freelancers for any job, any time.</strong>
						<br>
						<span>Huge community of producers, directors, singers, and mixers ready for your project.</span>
					</h3>
				</div>
			</div>
		</div>
		
		<!-- Search Bar -->
		<div class="row">
			<div class="col-md-12">
				<div class="intro-banner-search-form margin-top-95">

					<!-- Search Field -->
					<div class="intro-search-field with-autocomplete">
						<label for="autocomplete-input" class="field-title ripple-effect">Where?</label>
						<div class="input-with-icon">
							<input id="autocomplete-input" type="text" placeholder="Job location">
							<i class="icon-material-outline-location-on"></i>
						</div>
					</div>

					<!-- Search Field -->
					<div class="intro-search-field">
						<label for ="intro-keywords" class="field-title ripple-effect">What you need done?</label>
						<input id="intro-keywords" type="text" placeholder="e.g. create a beat for me">
					</div>

					<!-- Search Field -->
					<div class="intro-search-field">
						<select class="selectpicker default" multiple data-selected-text-format="count" data-size="7" title="All Categories" >
						<?php 
							$sql = "SELECT * FROM category ORDER BY DATE(created) ASC";
							$rs_result = mysqli_query ($con, $sql);
											while ($row = mysqli_fetch_assoc($rs_result)) {
												$id = $row['id'];
												$category= $row['category'];

												echo "<option value='$category'>$category </option>";
											}
						?>
						</select>
					</div>

					<!-- Button -->
					<div class="intro-search-button">
						<form action="freelancer/tasks-list.php" method="post">
							<button class="button ripple-effect" onclick="">Search</button>
						</form>
					</div>
				</div>
			</div>
		</div>

		<!-- Stats -->
		<div class="row">
			<div class="col-md-12">
				<ul class="intro-stats margin-top-45 hide-under-992px">
					<li>
						<strong class="counter"><?php
								$tasks = "SELECT * FROM tasks WHERE bid_status = 'inactive' "; 
								$taskres=mysqli_query($con,$tasks);
								$taskcount = mysqli_num_rows($taskres); 
								echo $taskcount;
								?></strong>
						<span>Jobs Posted</span>
					</li>
					<li>
						<strong class="counter"><?php
								$tasks = "SELECT * FROM users WHERE acct_type = 'freelancer' "; 
								$taskres=mysqli_query($con,$tasks);
								$taskcount = mysqli_num_rows($taskres); 
								echo $taskcount;
								?></strong>
						<span>Freelancers</span>
					</li>
				</ul>
			</div>
		</div>

	</div>
</div>


<!-- Content
================================================== -->

<!-- Popular Job Categories -->
<div class="section margin-top-65 margin-bottom-30">
	<div class="container">
		<div class="row">

			<!-- Section Headline -->
			<div class="col-xl-12">
				<div class="section-headline centered margin-top-0 margin-bottom-45">
					<h3>Popular Categories</h3>
				</div>
			</div>

			<?php 
							$sql = "SELECT * FROM category ORDER BY DATE(created) ASC LIMIT 8";
							$rs_result = mysqli_query ($con, $sql);
											while ($row = mysqli_fetch_assoc($rs_result)) {
												$id = $row['id'];
												$category= $row['category'];
												$image = $row['category_image'];

												$cat = "SELECT * FROM tasks WHERE category = '$id' ";
												$catres=mysqli_query($con,$cat);
												$catcount = mysqli_num_rows($catres); 

												echo "
												<div class='col-xl-3 col-md-6'>
												<a href='freelancer/tasks-list.php' class='photo-box small' data-background-image='images/admin/category/$image'>
													<div class='photo-box-content'>
														<h3>$category</h3>
														<span>$catcount</span>
													</div>
												</a>
											</div>";
											}
											?>

		</div>
	</div>
</div>
<!-- Features Cities / End -->



<!-- Features Jobs -->
<div class="section gray margin-top-45 padding-top-65 padding-bottom-75">
	<div class="container">
		<div class="row">
			<div class="col-xl-12">
				
				<!-- Section Headline -->
				<div class="section-headline margin-top-0 margin-bottom-35">
					<h3>Recent Tasks</h3>
					<a href="tasks-list-layout-1.html" class="headline-link">Browse All Tasks</a>
				</div>
				
				<!-- Jobs Container -->
				<div class="tasks-list-container compact-list margin-top-35">
				<?php 
$sql = "SELECT * FROM tasks WHERE bid_status = 'active' ORDER BY DATE(created) DESC LIMIT 6";
$rs_result = mysqli_query ($con, $sql); //run the query 
while ($row = mysqli_fetch_assoc($rs_result)) {
	$bid = $row['id'];
	$title = $row['title'];
	$type = $row['type'];
	$min = $row['min_salary'];
	$max = $row['max_salary'];
	$tags = $row['tags'];
	$location = $row['location'];
	$created = $row['created'];

	$created = date('D d M Y', strtotime($created));
																			
	echo "
					<!-- Task -->
					<a href='freelancer/single-task-page.php?taskid=$bid' class='task-listing'>
						<!-- Job Listing Details -->
						<div class='task-listing-details'>
							<!-- Details -->
							<div class='task-listing-description'>
								<h3 class='task-listing-title'>$title</h3>
								<ul class='task-icons'>
									<li><i class='icon-material-outline-location-on'></i> $location</li>
									<li><i class='icon-material-outline-access-time'></i> $created</li>
								</ul>
								<div class='task-tags margin-top-15'>";

								$tag = explode(",", $tags);
								for ($i=0; $i < count($tag); $i++) {
									echo "<span>$tag[$i]</span>&nbsp;";
								}
								echo "
								</div>
							</div>
						</div>
						<div class='task-listing-bid'>
							<div class='task-listing-bid-inner'>
								<div class='task-offers'>
									<strong>$$min - $$max</strong>
									<span>$type</span>
								</div>
								<form action='freelancer/single-task-page.php?taskid=$bid' method='post' id='fore'>
								<button class='button button-sliding-icon ripple-effect' form='fore'>Bid Now <i class='icon-material-outline-arrow-right-alt'></i></button>
							</div>
						</div>
					</a>
					";
}
?>
				</div>
				<!-- Jobs Container / End -->

			</div>
		</div>
	</div>
</div>
<!-- Featured Jobs / End -->

<!-- Icon Boxes -->
<div class="section padding-top-65 padding-bottom-65">
	<div class="container">
		<div class="row">

			<div class="col-xl-12">
				<!-- Section Headline -->
				<div class="section-headline centered margin-top-0 margin-bottom-5">
					<h3>How It Works?</h3>
				</div>
			</div>
			
			<div class="col-xl-4 col-md-4">
				<!-- Icon Box -->
				<div class="icon-box with-line">
					<!-- Icon -->
					<div class="icon-box-circle">
						<div class="icon-box-circle-inner">
							<i class="icon-line-awesome-lock"></i>
							<div class="icon-box-check"><i class="icon-material-outline-check"></i></div>
						</div>
					</div>
					<h3>Create an Account</h3>
					<!-- <p>Bring to the table win-win survival strategies to ensure proactive domination going forward.</p> -->
				</div>
			</div>

			<div class="col-xl-4 col-md-4">
				<!-- Icon Box -->
				<div class="icon-box with-line">
					<!-- Icon -->
					<div class="icon-box-circle">
						<div class="icon-box-circle-inner">
							<i class="icon-line-awesome-legal"></i>
							<div class="icon-box-check"><i class="icon-material-outline-check"></i></div>
						</div>
					</div>
					<h3>Post a Task</h3>
					<!-- <p>Efficiently unleash cross-media information without. Quickly maximize return on investment.</p> -->
				</div>
			</div>

			<div class="col-xl-4 col-md-4">
				<!-- Icon Box -->
				<div class="icon-box">
					<!-- Icon -->
					<div class="icon-box-circle">
						<div class="icon-box-circle-inner">
							<i class=" icon-line-awesome-trophy"></i>
							<div class="icon-box-check"><i class="icon-material-outline-check"></i></div>
						</div>
					</div>
					<h3>Choose an Expert</h3>
					<!-- <p>Nanotechnology immersion along the information highway will close the loop on focusing solely.</p> -->
				</div>
			</div>

		</div>
	</div>
</div>
<!-- Icon Boxes / End -->


<!-- Testimonials -->
<div class="section gray padding-top-65 padding-bottom-55">
	
	<div class="container">
		<div class="row">
			<div class="col-xl-12">
				<!-- Section Headline -->
				<div class="section-headline centered margin-top-0 margin-bottom-5">
					<h3>Testimonials</h3>
				</div>
			</div>
		</div>
	</div>

	<!-- Categories Carousel -->
	<div class="fullwidth-carousel-container margin-top-20">
		<div class="testimonial-carousel testimonials">

		<?php 
							$sql = "SELECT * FROM testimonial RAND";
							$rs_result = mysqli_query ($con, $sql); //run the query 
							while ($row = mysqli_fetch_assoc($rs_result)) {
								$tid = $row['id'];
								$user= $row['users'];
								$name= $row['name'];
								$testimony= $row['testimony'];
																			
								echo "
			<div class='fw-carousel-review'>
				<div class='testimonial-box'>
					<div class='testimonial-author'>
						<h4>$name</h4>
						 <span>$user</span>
					</div>
					<div class='testimonial'>$testimony</div>
				</div>
			</div>
			";
		}
		?>
			
		</div>
	</div>
	<!-- Categories Carousel / End -->

</div>
<!-- Testimonials / End -->


<!-- Counters -->
<div class="section padding-top-70 padding-bottom-75">
	<div class="container">
		<div class="row">

			<div class="col-xl-12">
				<div class="counters-container">
					
					<!-- Counter -->
					<div class="single-counter">
						<i class="icon-line-awesome-suitcase"></i>
						<div class="counter-inner">
							<h3><span class="counter"><?php
								$tasks = "SELECT * FROM tasks "; 
								$taskres=mysqli_query($con,$tasks);
								$taskcount = mysqli_num_rows($taskres); 
								echo $taskcount;
								?></span></h3>
							<span class="counter-title">Jobs Posted</span>
						</div>
					</div>

					<!-- Counter -->
					<div class="single-counter">
						<i class="icon-line-awesome-user"></i>
						<div class="counter-inner">
							<h3><span class="counter"><?php
								$users = "SELECT * FROM users "; 
								$userres=mysqli_query($con,$users);
								$usercount = mysqli_num_rows($userres); 
								echo $usercount;
								?></span></h3>
							<span class="counter-title">Active Members</span>
						</div>
					</div>

					<!-- Counter -->
					<div class="single-counter">
						<i class="icon-line-awesome-trophy"></i>
						<div class="counter-inner">
							<h3><span class="counter">99</span>%</h3>
							<span class="counter-title">Satisfaction Rate</span>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
<!-- Counters / End -->


<!-- Footer
================================================== -->
	<?php include('footer.php'); ?>
</div>
<!-- Wrapper / End -->


<!-- Scripts
================================================== -->
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/jquery-migrate-3.1.0.min.html"></script>
<script src="js/mmenu.min.js"></script>
<script src="js/tippy.all.min.js"></script>
<script src="js/simplebar.min.js"></script>
<script src="js/bootstrap-slider.min.js"></script>
<script src="js/bootstrap-select.min.js"></script>
<script src="js/snackbar.js"></script>
<script src="js/clipboard.min.js"></script>
<script src="js/counterup.min.js"></script>
<script src="js/magnific-popup.min.js"></script>
<script src="js/slick.min.js"></script>
<script src="js/custom.js"></script>

<!-- Snackbar // documentation: https://www.polonel.com/snackbar/ -->
<script>
// Snackbar for user status switcher
$('#snackbar-user-status label').click(function() { 
	Snackbar.show({
		text: 'Your status has been changed!',
		pos: 'bottom-center',
		showAction: false,
		actionText: "Dismiss",
		duration: 3000,
		textColor: '#fff',
		backgroundColor: '#383838'
	}); 
}); 
</script>

<!-- Leaflet // Docs: https://leafletjs.com/ -->
<script src="js/leaflet.min.js"></script>

<!-- Leaflet Geocoder + Search Autocomplete // Docs: https://github.com/perliedman/leaflet-control-geocoder -->
<script src="js/leaflet-autocomplete.js"></script>
<script src="js/leaflet-control-geocoder.js"></script>

</body>

</html>