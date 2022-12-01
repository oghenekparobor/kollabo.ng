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
				<h3>Manage Tasks</h3>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs" class="dark">
					<ul>
						<li><a href="#">Home</a></li>
						<li><a href="dashboard.php">Dashboard</a></li>
						<li>Manage Tasks</li>
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
							<h3><i class="icon-material-outline-assignment"></i> My Tasks</h3>
						</div>

						<div class="content">
							<ul class="dashboard-box-list">

							<?php 
							$sql = "SELECT * FROM tasks WHERE user_id = '$id' AND bid_status = 'active' ORDER BY DATE(created) DESC";
							$rs_result = mysqli_query ($con, $sql); //run the query 
							while ($row = mysqli_fetch_assoc($rs_result)) {
								$tid = $row['id'];
								$title= $row['title'];
								$type = $row['type'];
								$category = $row['category'];
								$min_salary = $row['min_salary'];
								$max_salary = $row['max_salary'];
								$location = $row['location'];
								$created = $row['created'];

								$created = date('D d M Y', strtotime($created));

								$total = "SELECT * FROM bidder WHERE employer_id = '$id' AND task_id = '$tid' "; 
								$totalres=mysqli_query($con,$total);
								$totalcount = mysqli_num_rows($totalres);
																			
								echo "
								<li>
									<div class='job-listing width-adjustment'>

										<div class='job-listing-details'>

											<div class='job-listing-description'>
												<h3 class='job-listing-title'><a href='single-task-page.php?taskid=$tid'>$title</a> <span class='dashboard-status-button yellow'>Expiring</span></h3>

												<div class='job-listing-footer'>
													<ul>
														<li><i class='icon-material-outline-access-time'></i> $created</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
									
									<ul class='dashboard-task-info'>
										<li><strong>$totalcount</strong><span>Bids</span></li>
										<li><strong>₦$min_salary - ₦$max_salary</strong><span>$type</span></li>
									</ul>

									<div class='buttons-to-right always-visible'>
										<a href='dashboard-manage-bidders.php?task_id=$tid' class='button ripple-effect'><i class='icon-material-outline-supervisor-account'></i> Manage Bidders <span class='button-info'>$totalcount</span></a>
										<a href='cancelbid.php?task_id=$tid' class='button gray ripple-effect ico' title='Cancel Bid' data-tippy-placement='top'><i class='icon-feather-trash-2'></i></a>
									</div>
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