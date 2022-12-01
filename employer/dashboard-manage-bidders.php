<?php
include('install.php');

if(!isset($_SESSION['user_id'])) {
	header("Location: ../index.php");
} else {
	$id = $_SESSION['user_id'];
	$accttype = $_SESSION['account_type'];

	$sql = "SELECT * FROM employer WHERE user_id = '$id' LIMIT 1";
	$result = mysqli_query($con, $sql);
	$user = mysqli_fetch_assoc($result);

	$firstname = $user['firstname'];
	$lastname = $user['lastname'];
	$email = $user['email'];
	$picture = $user['picture'];

	if (!isset($_GET['task_id'])) {
		header("Location: active-bids.php");
	} else {
		$taskid = $_GET['task_id'];

		$task = "SELECT * FROM tasks WHERE id = '$taskid' LIMIT 1";
		$task = mysqli_query($con, $task);
		$task = mysqli_fetch_assoc($task);
		$title = $task['title'];
		
		$bidders = "SELECT * FROM bidder WHERE task_id = '$taskid' AND employer_id = '$id' "; 
		$bidders=mysqli_query($con,$bidders);
		$bidders = mysqli_num_rows($bidders);

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
<div class="clearfix"></div>
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
				<h3>Manage Bidders</h3>
				<span class="margin-top-7">Bids for <a href="#"><?php echo $title; ?></a></span>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs" class="dark">
					<ul>
						<li><a href="#">Home</a></li>
						<li><a href="dashboard.php">Dashboard</a></li>
						<li>Manage Bidders</li>
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
							<h3><i class="icon-material-outline-supervisor-account"></i> <?php echo $bidders; ?> Bidders</h3>
							<div class="sort-by">
								<select class="selectpicker hide-tick">
									<option>Highest First</option>
									<option>Lowest First</option>
									<option>Random</option>
								</select>
							</div>
						</div>

						<div class="content">
							<ul class="dashboard-box-list">

							<?php 
							$sql = "SELECT * FROM bidder WHERE task_id = '$taskid' ORDER BY DATE(created) DESC";
							$rs_result = mysqli_query ($con, $sql); //run the query 
							while ($row = mysqli_fetch_assoc($rs_result)) {
								$bid = $row['id'];
								$employer = $row['employer_id'];
								$freelancer = $row['freelancer_id'];
								$price = $row['price'];								
								$duration = $row['duration'];
								
								$freelance = "SELECT * FROM freelancer WHERE user_id = '$freelancer' LIMIT 1";
								$freelance = mysqli_query($con, $freelance);
								$freelance = mysqli_fetch_assoc($freelance);
								$ffirstname = $freelance['firstname'];
								$flastname = $freelance['lastname'];
								$pic = $freelance['picture'];
								$nation = $freelance['nationality'];
								$femail = $freelance['email'];
								$fid = $freelance['id'];
																			
								echo "
								<li>
									<!-- Overview -->
									<div class='freelancer-overview manage-candidates'>
										<div class='freelancer-overview-inner'>

											<!-- Avatar -->
											<div class='freelancer-avatar'>
												<div class='verified-badge'></div>
												<a href=''><img src='../images/freelancer/profile/$pic' alt=''></a>
											</div>

											<!-- Name -->
											<div class='freelancer-name'>
												<h4><a href='single-freelancer-profile.php?freelancer=$freelancer'>$ffirstname $flastname <img class='flag' src='../images/flags/de.svg' alt='' title='$nation' data-tippy-placement='top'></a></h4>

												<!-- Details -->
												<span class='freelancer-detail-item'><a href=''><i class='icon-feather-mail'></i> <span class='__cf_email__' data-cfemail='$femail'>$femail</span></a></span>

												<!-- Rating -->
												<div class='freelancer-rating'>
													<div class='star-rating' data-rating='5.0'></div>
												</div>

												<!-- Bid Details -->
												<ul class='dashboard-task-info bid-info'>
													<li><strong>₦$price</strong><span>Fixed Price</span></li>
													<li><strong>$duration Days</strong><span>Delivery Time</span></li>
												</ul>

												<!-- Buttons -->
												<div class='buttons-to-right always-visible margin-top-25 margin-bottom-0'>
													<a href='#small-dialog-$bid' class='popup-with-zoom-anim button ripple-effect'><i class='icon-material-outline-check'></i> Accept Offer</a>
													<a href='#message-dialog-$bid' class='popup-with-zoom-anim button dark ripple-effect'><i class='icon-feather-mail'></i> Send Message</a>
												</div>
											</div>
										</div>
									</div>
								</li>
								";
							}
							?>

							</ul>
						</div>
					</div>
				</div>

			</div>
			<!-- Row / End -->

			<!-- Footer -->
			<?php include('footer.php'); ?>
			<!-- Footer / End -->

		</div>
	</div>
	<!-- Dashboard Content / End -->

</div>
<!-- Dashboard Container / End -->

</div>
<!-- Wrapper / End -->

<?php 
$sql = "SELECT * FROM bidder WHERE task_id = '$taskid' ORDER BY DATE(created) DESC";
$rs_result = mysqli_query ($con, $sql); //run the query 
while ($row = mysqli_fetch_assoc($rs_result)) {
	$bid = $row['id'];
	$employer = $row['employer_id'];
	$freelancer = $row['freelancer_id'];
	$price = $row['price'];								
	$duration = $row['duration'];
								
	$freelance = "SELECT * FROM freelancer WHERE user_id = '$freelancer' LIMIT 1";
	$freelance = mysqli_query($con, $freelance);
	$freelance = mysqli_fetch_assoc($freelance);
	$ffirstname = $freelance['firstname'];
	$flastname = $freelance['lastname'];
	$nation = $freelance['nationality'];
	$femail = $freelance['email'];
	$fid = $freelance['id'];
																			
	echo "
<div id='small-dialog-$bid' class='zoom-anim-dialog mfp-hide dialog-with-tabs'>
	<!--Tabs -->
	<div class='sign-in-form'>

		<ul class='popup-tabs-nav'>
			<li><a href='#tab1'>Accept Offer</a></li>
		</ul>

		<div class='popup-tabs-container'>
			<!-- Tab -->
			<div class='popup-tab-content' id='tab'>
				<!-- Welcome Text -->
				<div class='welcome-text'>
					<h3>Accept Offer From $ffirstname $flastname</h3>
					<div class='bid-acceptance margin-top-15'>
						₦$price
					</div>
				</div>

				<form id='terms' action='features.php' method='POST'>
					<input type='hidden' value='$freelancer' name='freelancer_id' />
					<input type='hidden' value='$employer' name='employer_id' />
					<input type='hidden' value='$price' name='price' />
					<input type='hidden' value='$duration' name='duration' />
					<input type='hidden' value='$taskid' name='task_id' />
					<div class='radio'>
						<input id='accept_radio_1' name='radio' type='radio' required>
						<label for='accept_radio_1'><span class='radio-label'></span> I have read and agree to the Terms and Conditions</label>
					</div>
					<!-- Button -->
					<button name='acceptoffer' class='margin-top-15 button full-width button-sliding-icon ripple-effect' type='submit' form='terms'>Accept <i class='icon-material-outline-arrow-right-alt'></i></button>
				</form>

			</div>

		</div>
	</div>
</div>
";
}
?>
<!-- Bid Acceptance Popup / End -->


<!-- Send Direct Message Popup
================================================== -->
<?php 
$sql = "SELECT * FROM bidder WHERE task_id = '$taskid' ORDER BY DATE(created) DESC";
$rs_result = mysqli_query ($con, $sql); //run the query 
while ($row = mysqli_fetch_assoc($rs_result)) {
	$bid = $row['id'];
	$employer = $row['employer_id'];
	$freelancer = $row['freelancer_id'];
	$price = $row['price'];								
	$duration = $row['duration'];
								
	$freelance = "SELECT * FROM freelancer WHERE user_id = '$freelancer' LIMIT 1";
	$freelance = mysqli_query($con, $freelance);
	$freelance = mysqli_fetch_assoc($freelance);
	$ffirstname = $freelance['firstname'];
	$flastname = $freelance['lastname'];
	$nation = $freelance['nationality'];
	$femail = $freelance['email'];
	$fid = $freelance['id'];
																			
	echo "
<div id='message-dialog-$bid' class='zoom-anim-dialog mfp-hide dialog-with-tabs'>
	<!--Tabs -->
	<div class='sign-in-form'>
		<ul class='popup-tabs-nav'>
			<li><a href='#tab2'>Send Message</a></li>
		</ul>
		<div class='popup-tabs-container'>
			<!-- Tab -->
			<div class='popup-tab-content' id='tab2'>	
				<!-- Welcome Text -->
				<div class='welcome-text'>
					<h3>Direct Message To $ffirstname $flastname</h3>
				</div>	
				<!-- Form -->
				<form method='post' action='features.php' id='send-pm' >
					<input type='hidden' value='$freelancer' name='freelancer_id' />
					<input type='hidden' value='$id' name='employer_id' />
					<textarea cols='10' name='message' placeholder='Message' class='with-border' required></textarea>
					<!-- Button -->
					<button name='send_message' class='button full-width button-sliding-icon ripple-effect' type='submit' form='send-pm'>Send <i class='icon-material-outline-arrow-right-alt'></i></button>
				</form>
			</div>
		</div>
	</div>
</div>
";
}
?>

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

<script>
// Snackbar for user status switcher
$('#snackbar-user-status').click(function() { 
	$.ajax({
    			url:"online_status.php",
        		type:"post",
				data: {
					'user_id' : <?php echo $id; ?>,
				},
    			success: function(response) {
      			if (response == 'INVISIBLE') {
					Snackbar.show({
						text: 'You are now invisible',
						textColor: '#fff',
						backgroundColor: '#383838'
					});
					onlineStatusInterval();
				} else if (response == 'ONLINE') {
					Snackbar.show({
						text: 'Your are now online',
						textColor: '#fff',
						backgroundColor: '#383838'
					});
					onlineStatusInterval();
				} else {
					Snackbar.show({
						text: 'Error',
						duration: 10000,
						textColor: '#fff',
						backgroundColor: '#383838'
					});
					onlineStatusInterval();
				}
    		}
  		}); 
}); 
</script>

<script>
	function onlineStatusInterval() {
		// setInterval(() => {
		$('#online_or_not').load(location.href + ' #online_or_not');
		$('#online_or_not1').load(location.href + ' #online_or_not1');
	// }, 500);
	}
</script>

</body>

</html>