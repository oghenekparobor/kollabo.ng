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
	$picture = $user['picture'];
	$email = $user['email'];
	$nationality = $user['nationality'];
	$introduction = $user['introduction'];
	$twostep = $user['twosteps'];

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
				<h3>Reviews</h3>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs" class="dark">
					<ul>
						<li><a href="#">Home</a></li>
						<li><a href="dashboard.php">Dashboard</a></li>
						<li>Reviews</li>
					</ul>
				</nav>
			</div>
	
			<!-- Row -->
			<div class="row">

				<!-- Dashboard Box -->
				<div class="col-xl-6">
					<div class="dashboard-box margin-top-0">

						<!-- Headline -->
						<div class="headline">
							<h3><i class="icon-material-outline-face"></i> Rate Freelancers</h3>
						</div>

						<div class="content">
							<ul class="dashboard-box-list">

							<?php 
							$sql = "SELECT * FROM mytask WHERE employer_id = '$id' AND finished IS NOT NULL AND feedback IS NULL ORDER BY DATE(created) DESC";
							$rs_result = mysqli_query ($con, $sql); //run the query 
							while ($row = mysqli_fetch_assoc($rs_result)) {
								$mtid = $row['id'];
								$freelancer= $row['freelancer_id'];
								$taskid = $row['task_id'];

								$task = "SELECT * FROM tasks WHERE id = '$taskid' LIMIT 1";
								$taskres = mysqli_query($con, $task);
								$taskget = mysqli_fetch_assoc($taskres);
								$title = $taskget['title'];
																			
								echo "
								<li>
									<div class='boxed-list-item'>
										<!-- Content -->
										<div class='item-content'>
											<h4>$title</h4>
											<span class='company-not-rated margin-bottom-5'>Not Rated</span>
										</div>
									</div>

									<a href='#small-dialog-$mtid' class='popup-with-zoom-anim button ripple-effect margin-top-5 margin-bottom-10'><i class='icon-material-outline-thumb-up'></i> Leave a Review</a>
								</li>";
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


<!-- Leave a Review for Freelancer Popup
================================================== -->
<?php 
$sql = "SELECT * FROM mytask WHERE employer_id = '$id' AND finished IS NOT NULL AND feedback IS NULL ORDER BY DATE(created) DESC";
$rs_result = mysqli_query ($con, $sql); //run the query 
while ($row = mysqli_fetch_assoc($rs_result)) {
	$mtid = $row['id'];
	$freelancer= $row['freelancer_id'];
	$taskid = $row['task_id'];

	$task = "SELECT * FROM tasks WHERE id = '$taskid' LIMIT 1";
	$taskres = mysqli_query($con, $task);
	$taskget = mysqli_fetch_assoc($taskres);
	$title = $taskget['title'];

	$frl = "SELECT * FROM freelancer WHERE user_id = '$freelancer' LIMIT 1";
	$frlres = mysqli_query($con, $frl);
	$lance = mysqli_fetch_assoc($frlres);
	$first = $lance['firstname'];
	$last = $lance['lastname'];
																			
echo "
<div id='small-dialog-$mtid' class='zoom-anim-dialog mfp-hide dialog-with-tabs'>

	<!--Tabs -->
	<div class='sign-in-form'>

		<ul class='popup-tabs-nav'>
		</ul>

		<div class='popup-tabs-container'>

			<!-- Tab -->
			<div class='popup-tab-content' id='tab2'>
				
				<!-- Welcome Text -->
				<div class='welcome-text'>
					<h3>What your feedback?</h3>
					<span>Rate <a href='single-freelancer-profile.php?freelancer=$freelancer'>$first $last</a> for the project <a href='single-task-page.php?taskid=$taskid'>$title</a> </span>
				</div>
					
				<!-- Form -->
				<form method='post' id='leave-review-form' action='features.php'>
					<input type='hidden' value='$freelancer' name='freelancer_id' />
					<input type='hidden' value='$mtid' name='employer_id' />
					<input type='hidden' value='$taskid' name='task_id' />
					<div class='feedback-yes-no'>
						<strong>Your Rating</strong>
						<div class='leave-rating'>
							<input type='radio' name='rating' id='rating-radio-1' value='1' required>
							<label for='rating-radio-1' class='icon-material-outline-star'></label>
							<input type='radio' name='rating' id='rating-radio-2' value='2' required>
							<label for='rating-radio-2' class='icon-material-outline-star'></label>
							<input type='radio' name='rating' id='rating-radio-3' value='3' required>
							<label for='rating-radio-3' class='icon-material-outline-star'></label>
							<input type='radio' name='rating' id='rating-radio-4' value='4' required>
							<label for='rating-radio-4' class='icon-material-outline-star'></label>
							<input type='radio' name='rating' id='rating-radio-5' value='5' required>
							<label for='rating-radio-5' class='icon-material-outline-star'></label>
						</div><div class='clearfix'></div>
					</div>

					<textarea class='with-border' placeholder='Comment' name='message2' id='message2' cols='7' required></textarea>				
				<!-- Button -->
				<button class='button full-width button-sliding-icon ripple-effect' name='leave_feedback' type='submit' form='leave-review-form'>Leave a Review <i class='icon-material-outline-arrow-right-alt'></i></button>

				</form>


			</div>

		</div>
	</div>
</div>
";
}
?>
<!-- Leave a Review Popup / End -->

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