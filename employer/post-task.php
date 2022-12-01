<?php
include('install.php');

if(!isset($_SESSION['user_id'])) {
	header("Location: ../index.php");
} else {

	if (!isset($_GET['to_freelancer'])) {
		header("Location: my-offers.php");
	} else {

		$id = $_SESSION['user_id'];
		$accttype = $_SESSION['account_type'];

		$sql = "SELECT * FROM employer WHERE user_id = '$id' LIMIT 1";
		$result = mysqli_query($con, $sql);
		$user = mysqli_fetch_assoc($result);

		$firstname = $user['firstname'];
		$lastname = $user['lastname'];
		$picture = $user['picture'];
		$email = $user['email'];

		$to_freelancer = $_GET['to_freelancer'];

		$sql1 = "SELECT * FROM freelancer WHERE user_id = '$to_freelancer' LIMIT 1";
		$result1 = mysqli_query($con, $sql1);
		$user1 = mysqli_fetch_assoc($result1);

		$first = $user1['firstname'];
		$last = $user1['lastname'];
		$pic = $user1['picture'];
	}

}
?>

<!doctype html>
<html lang="en">

<head>

<!-- Basic Page Needs
================================================== -->
<title>Kollabo</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
================================================== -->
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/colors/blue.css">

</head>
<body class="gray">

<!-- Wrapper -->
<div id="wrapper">

<!-- Header Container
================================================== -->
<?php include('header.php'); ?>
<!-- Header Container / End -->


<!-- Dashboard Container -->
<div class="dashboard-container">

	<!-- Dashboard Sidebar
	================================================== -->
	<div class="dashboard-sidebar">
		<div class="dashboard-sidebar-inner" data-simplebar>
			<div class="dashboard-nav-container">

				<!-- Responsive Navigation Trigger -->
				<a href="#" class="dashboard-responsive-nav-trigger">
					<span class="hamburger hamburger--collapse" >
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</span>
					<span class="trigger-title">Dashboard</span>
				</a>
				
				<!-- Navigation -->
				<?php include('nav.php'); ?>
				<!-- Navigation / End -->

			</div>
		</div>
	</div>
	<!-- Dashboard Sidebar / End -->


	<!-- Dashboard Content
	================================================== -->
	<div class="dashboard-content-container" data-simplebar>
		<div class="dashboard-content-inner" >
			
			<!-- Dashboard Headline -->
			<div class="dashboard-headline">
				<h3>Post Task to <?php echo $first." ".$last; ?> </h3>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs" class="dark">
					<ul>
						<li><a href="#">Home</a></li>
						<li><a href="dashboard.php">Dashboard</a></li>
						<li>Post Task</li>
					</ul>
				</nav>
			</div>
	
			<!-- Row -->
			<div class="row">

				<!-- Dashboard Box -->
				<div class="col-xl-12">
					<div class="dashboard-box margin-top-0">

						<!-- Headline -->
						<div class="headline">
							<h3><i class="icon-feather-folder-plus"></i> Task Submission Form</h3>
						</div>

						<form action="features.php" method="post" enctype="multipart/form-data">

						<div class="content with-padding padding-bottom-10">
							<div class="row">
							<input class="with-border" name="freelancer" type="hidden" value="<?php echo $to_freelancer; ?>">
							<div class="col-xl-4">
									<div class="submit-field">
										<h5>Project Name</h5>
										<input type="text" class="with-border" name="title" placeholder="e.g. build me a website">
									</div>
								</div>

								<input type="hidden" name="user_id"  value="<?php echo $id; ?>" />

								<div class="col-xl-4">
									<div class="submit-field">
										<h5>Category</h5>
										<select class="selectpicker with-border" data-size="7" name="category" title="Select Category">
										<?php 
										$sql = "SELECT * FROM category ORDER BY DATE(created) ASC";
										$rs_result = mysqli_query ($con, $sql);
											while ($row = mysqli_fetch_assoc($rs_result)) {
												$id = $row['id'];
												$category= $row['category'];

												echo "<option value='$id'>$category </option>";
											}
										?>
										</select>
									</div>
								</div>

								<div class="col-xl-4">
									<div class="submit-field">
										<h5>Location  <i class="help-icon" data-tippy-placement="right" title="Leave blank if it's an online job"></i></h5>
										<div class="input-with-icon">
											<div id="autocomplete-container">
												<input id="autocomplete-input" name="location" class="with-border" type="text" placeholder="Anywhere">
											</div>
											<i class="icon-material-outline-location-on"></i>
										</div>
									</div>
								</div>

								<div class="col-xl-6">
									<div class="submit-field">
										<h5>Budget?</h5>
										<div class="row">
											<div class="col-xl-6">
												<div class="input-with-icon">
													<input class="with-border" name="budget" min="1" step="1" type="number" placeholder="Agreed Budget">
													<i class="currency">NGN</i>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-xl-6">
												<div class="input-with-icon">
													<input class="with-border" name="duration" min="1" step="1" type="number" placeholder="Duration">
													<i class="currency">DAYS</i>
												</div>
											</div>
										</div>
										<div class="feedback-yes-no margin-top-0">
											<div class="radio">
												<input id="radio-1" name="type" value="Fixed Price Project" type="radio" checked>
												<label for="radio-1"><span class="radio-label"></span> Fixed Price Project</label>
											</div>

											<div class="radio">
												<input id="radio-2" name="type" value="Hourly Project" type="radio">
												<label for="radio-2"><span class="radio-label"></span> Hourly Project</label>
											</div>
										</div>
									</div>
								</div>

								<div class="col-xl-6">
									<div class="submit-field">
										<h5>What skills are required? <i class="help-icon" data-tippy-placement="right" title="Separate skills using comma(,)"></i></h5>
										<div class="keywords-container">
											<div class="keyword-input-container">
												<input type="text" class="keyword-input with-border" name="skills" placeholder="Seperate skill using comma"/>
												<!-- <button class="keyword-input-button ripple-effect"><i class="icon-material-outline-add"></i></button> -->
											</div>
											<div class="keywords-list"><!-- keywords go here --></div>
											<div class="clearfix"></div>
										</div>

									</div>
								</div>

								<div class="col-xl-12">
									<div class="submit-field">
										<h5>Describe Your Project</h5>
										<textarea cols="30" rows="5" name="description" class="with-border"></textarea>
										<div class="uploadButton margin-top-30">
											<input class="uploadButton-input" name="file" type="file" accept="image/*, application/pdf, audio/*" id="upload" multiple/>
											<label class="uploadButton-button ripple-effect" for="upload">Upload Files</label>
											<span class="uploadButton-file-name">Audio or documents that might be helpful in describing your project</span>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>

				<div class="col-xl-12">
					<button name="post_task" class="button ripple-effect big margin-top-30"><i class="icon-feather-plus"></i> Post a Task</button>
				</div>

				</form>

			</div>
			<!-- Row / End -->

			<!-- Footer -->
			<div class="dashboard-footer-spacer"></div>
			<div class="small-footer margin-top-15">
				<div class="small-footer-copyrights">
					© 2019 <strong>Hireo</strong>. All Rights Reserved.
				</div>
				<ul class="footer-social-links">
					<li>
						<a href="#" title="Facebook" data-tippy-placement="top">
							<i class="icon-brand-facebook-f"></i>
						</a>
					</li>
					<li>
						<a href="#" title="Twitter" data-tippy-placement="top">
							<i class="icon-brand-twitter"></i>
						</a>
					</li>
					<li>
						<a href="#" title="Google Plus" data-tippy-placement="top">
							<i class="icon-brand-google-plus-g"></i>
						</a>
					</li>
					<li>
						<a href="#" title="LinkedIn" data-tippy-placement="top">
							<i class="icon-brand-linkedin-in"></i>
						</a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<!-- Footer / End -->

		</div>
	</div>
	<!-- Dashboard Content / End -->

</div>
<!-- Dashboard Container / End -->

</div>
<!-- Wrapper / End -->


<!-- Scripts
================================================== -->
<script src="../js/jquery-3.4.1.min.js"></script>
<script src="../js/jquery-migrate-3.1.0.min.html"></script>
<script src="../js/mmenu.min.js"></script>
<script src="../js/tippy.all.min.js"></script>
<script src="../js/simplebar.min.js"></script>
<script src="../js/bootstrap-slider.min.js"></script>
<script src="../js/bootstrap-select.min.js"></script>
<script src="../js/snackbar.js"></script>
<script src="../js/clipboard.min.js"></script>
<script src="../js/counterup.min.js"></script>
<script src="../js/magnific-popup.min.js"></script>
<script src="../js/slick.min.js"></script>
<script src="../js/custom.js"></script>

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


<!-- Google Autocomplete -->
<script>
	function initAutocomplete() {
		 var options = {
		  types: ['(cities)'],
		  // componentRestrictions: {country: "us"}
		 };

		 var input = document.getElementById('autocomplete-input');
		 var autocomplete = new google.maps.places.Autocomplete(input, options);

		if ($('.submit-field')[0]) {
		    setTimeout(function(){ 
		        $(".pac-container").prependTo("#autocomplete-container");
		    }, 300);
		}
	}
</script>

<!-- Google API & Maps -->
<!-- Geting an API Key: https://developers.google.com/maps/documentation/javascript/get-api-key -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAaoOT9ioUE4SA8h-anaFyU4K63a7H-7bc&amp;libraries=places"></script>


</body>

</html>