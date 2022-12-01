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
				<h3>Bookmarks</h3>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs" class="dark">
					<ul>
						<li><a href="#">Home</a></li>
						<li><a href="dashboard.php">Dashboard</a></li>
						<li>Bookmarks</li>
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
							<h3><i class="icon-material-outline-business-center"></i> Bookmarked Tasks</h3>
						</div>

						<div class="content">
							<ul class="dashboard-box-list">

							<?php 
							$sql = "SELECT * FROM bookmark_freelancer WHERE user_id = '$id' ORDER BY id DESC";
							$rs_result = mysqli_query ($con, $sql); //run the query 
							while ($row = mysqli_fetch_assoc($rs_result)) {
								$bid = $row['id'];
								$taskid= $row['task_id'];

								$t = "SELECT * FROM tasks WHERE id = '$taskid' LIMIT 1";
								$tr = mysqli_query($con, $t);
								$task = mysqli_fetch_assoc($tr);
								$title = $task['title'];
								$type = $task['type'];
								$userid = $task['user_id'];
								$location = $task['location'];
								$created = $task['created'];

								$created = date('D d M Y', strtotime($created));

								$e = "SELECT * FROM employer WHERE user_id = '$userid' LIMIT 1";
								$er = mysqli_query($con, $e);
								$employer = mysqli_fetch_assoc($er);
								$efirstname = $employer['firstname'];
								$elastname = $employer['lastname'];

								echo "
								<li>
									<div class='job-listing'>

										<div class='job-listing-details'>

											<a href='single-task-page.php?taskid=$taskid' class='job-listing-company-logo'>
												<img src='../images/browse-companies-02.png' alt=''>
											</a>

											<div class='job-listing-description'>
												<h3 class='job-listing-title'><a href='single-task-page.php?taskid=$taskid'>$title</a></h3>

												<div class='job-listing-footer'>
													<ul>
														<li><i class='icon-feather-user'></i> $efirstname $elastname</li>
														<li><i class='icon-material-outline-location-on'></i>$location</li>
														<li><i class='icon-material-outline-business-center'></i>$type</li>
														<li><i class='icon-material-outline-access-time'></i>$created</li>
													</ul>
												</div>
											</div>
										</div>
									</div>

									<div class='buttons-to-right'>
										<a href='deletebookmark.php?bookmark_id=$bid' class='button red ripple-effect ico' title='Remove' data-tippy-placement='left'><i class='icon-feather-trash-2'></i></a>
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

<script>
	$('#check_active_plan').click(function() {
			$.ajax({
    			url:"getactiveplan.php",
        		type:"post",
				data: {
					'freelancer_id' : <?php echo $id; ?>,
				},
    			success: function(response) {
      			if (response == 'NO_ACTIVE_PLAN') {
					Snackbar.show({
						text: 'Sorry! You have no active plan',
						duration: 10000,
						textColor: '#fff',
						backgroundColor: '#383838'
					});
				} else if (response == 'PLAN_ACTIVE') {
					Snackbar.show({
						text: 'Your plan is still active',
						duration: 10000,
						textColor: '#fff',
						backgroundColor: '#383838'
					});
				} else if (response == 'PLAN_EXPIRED') {
					Snackbar.show({
						text: 'Your plan has expired',
						duration: 10000,
						textColor: '#fff',
						backgroundColor: '#383838'
					});
				} else {
					Snackbar.show({
						text: 'Error',
						duration: 10000,
						textColor: '#fff',
						backgroundColor: '#383838'
					});
				}
    		}
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