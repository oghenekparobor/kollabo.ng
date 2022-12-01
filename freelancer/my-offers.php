<?php
include('install.php');

if(!isset($_SESSION['user_id'])) {
	header("Location: ../index.php");
} else {
	$id = $_SESSION['user_id'];

	$sql = "SELECT * FROM freelancer WHERE user_id = '$id' LIMIT 1";
	$result = mysqli_query($con, $sql);
	$user = mysqli_fetch_assoc($result);

	$firstname = $user['firstname'];
	$lastname = $user['lastname'];
	$picture = $user['picture'];
	$email = $user['email'];
	$nationality = $user['nationality'];
	$introduction = $user['introduction'];
	$twostep = $user['twostep'];

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
				<h3>Manage Offers</h3>
				<span class="margin-top-7">Offers directly from Clients</span>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs" class="dark">
					<ul>
						<li><a href="#">Home</a></li>
						<li><a href="dashboard.php">Dashboard</a></li>
						<li>My Offers</li>
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
							<h3><i class="icon-feather-mail"></i> <?php
								$tasks = "SELECT * FROM make_offer WHERE freelancer_id = '$id' AND acceptance_status IS NULL "; 
								$taskres=mysqli_query($con,$tasks);
								$taskcount = mysqli_num_rows($taskres); 
								echo $taskcount;
								?> Offers</h3>
						</div>

						<div class="content">
							<ul class="dashboard-box-list">

							<?php 
							$sql = "SELECT * FROM make_offer WHERE freelancer_id = '$id' AND acceptance_status IS NULL ORDER BY id DESC";
							$rs_result = mysqli_query ($con, $sql); //run the query 
							while ($row = mysqli_fetch_assoc($rs_result)) {
								$oid = $row['id'];
								$employer= $row['employer_id'];
								$message = $row['message'];
								$attachment = $row['attachment'];
								$created = $row['created'];

								$created = date('D d M Y', strtotime($created));

								$sql = "SELECT * FROM employer WHERE user_id = '$employer' LIMIT 1";
								$result = mysqli_query($con, $sql);
								$user = mysqli_fetch_assoc($result);
								$first = $user['firstname'];
								$last = $user['lastname'];
								$pic = $user['picture'];
								$location = $user['nationality'];
								$mail = $user['email'];

								echo "

								<li>
									<div class='freelancer-overview manage-candidates'>
										<div class='freelancer-overview-inner'>

											<div class='freelancer-avatar'>
												<div class='verified-badge'></div>
												<a href=''><img src='../images/employer/profile/$pic' alt=''></a>
											</div>

											<div class='freelancer-name'>
												<h4><a href=''>$first $last <img class='flag' src='../images/flags/au.svg' alt='' title='$location' data-tippy-placement='top'></a></h4>

												<span class='freelancer-detail-item'><a href=''><i class='icon-feather-mail'></i> <span class=''>$mail</span></a></span>
												<span class='freelancer-detail-item'><i class='icon-feather-phone'></i> (+234) 123-456-789</span>

												<div class='accordion-body__contents'>
													$message
												</div>

												<div class='buttons-to-right always-visible margin-top-25 margin-bottom-5'>
													<a href='accept_offer.php?offer_id=$oid' class='button ripple-effect'><i class='icon-feather-file-text'></i> Accept Offer</a>
													<a href='../images/employer/offers/$attachment' class='button dark ripple-effect'><i class='icon-feather-file-text'></i> Download Attachment</a>
													<a href='#small-dialog-$oid' class='popup-with-zoom-anim button dark ripple-effect'><i class='icon-feather-mail'></i> Send Message</a>
													<a href='decline_offer.php?offer_id=$oid' class='button gray ripple-effect ico' title='Decline Offer' data-tippy-placement='top'><i class='icon-feather-trash-2'></i></a>
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
							$sql = "SELECT * FROM make_offer WHERE freelancer_id = '$id' AND acceptance_status IS NULL ORDER BY DATE(created) DESC";
							$rs_result = mysqli_query ($con, $sql); //run the query 
							while ($row = mysqli_fetch_assoc($rs_result)) {
								$oid = $row['id'];
								$employer= $row['employer_id'];
								$message = $row['message'];
								$attachment = $row['attachment'];
								$created = $row['created'];

								$created = date('D d M Y', strtotime($created));

								$sql = "SELECT * FROM employer WHERE user_id = '$employer' LIMIT 1";
								$result = mysqli_query($con, $sql);
								$user = mysqli_fetch_assoc($result);
								$first = $user['firstname'];
								$last = $user['lastname'];
								$pic = $user['picture'];
								$location = $user['nationality'];
								$mail = $user['email'];

								echo "
<div id='small-dialog-$oid' class='zoom-anim-dialog mfp-hide dialog-with-tabs'>

	<div class='sign-in-form'>

		<ul class='popup-tabs-nav'>
			<li><a href='#tab'>Send Message</a></li>
		</ul>

		<div class='popup-tabs-container'>

			<div class='popup-tab-content' id='tab'>
				
				<div class='welcome-text'>
					<h3>Direct Message To Sindy</h3>
				</div>
					
				<form method='post' action='features.php' id='send-pm'>
					<input type='hidden' name='freelancer_id' value='$id' />
					<input type='hidden' name='employer_id' value='$employer' />
					<input type='hidden' name='offer' value='$message' />
					<textarea name='textarea' cols='10' placeholder='Message' class='with-border' required></textarea>
				
				<button class='button full-width button-sliding-icon ripple-effect' name='send_message' type='submit' form='send-pm'>Send <i class='icon-material-outline-arrow-right-alt'></i></button>
				
				</form>

			</div>

		</div>
	</div>
</div>
";
							}
							?>
<!-- Send Direct Message Popup / End -->


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

</body>

</html>