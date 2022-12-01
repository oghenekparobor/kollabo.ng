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
					<div class="dashboard-box">

						<!-- Headline -->
						<div class="headline">
							<h3><i class="icon-material-outline-face"></i> Bookmarked Freelancers</h3>
						</div>

						<div class="content">
							<ul class="dashboard-box-list">

							<?php 
							$sql = "SELECT * FROM bookmark_employer WHERE user_id = '$id' ORDER BY id DESC";
							$rs_result = mysqli_query ($con, $sql); //run the query 
							while ($row = mysqli_fetch_assoc($rs_result)) {
								$bid = $row['id'];
								$freelance= $row['freelance'];

								$sql = "SELECT * FROM freelancer WHERE user_id = '$freelance' LIMIT 1";
								$result = mysqli_query($con, $sql);
								$user = mysqli_fetch_assoc($result);

								$ffirstname = $user['firstname'];
								$flastname = $user['lastname'];
								$nation = $user['nationality'];
								$tagline = $user['tagline'];
								$verified = $user['verified'];
								$picture = $user['picture'];
								$verify;

								if ($verified == 'true'){
									$verify = "<div class='verified-badge'></div>";
								} else {
									$verify = "";
								}
																			
								echo "

								<li>
									<!-- Overview -->
									<div class='freelancer-overview'>
										<div class='freelancer-overview-inner'>

											<!-- Avatar -->
											<div class='freelancer-avatar'>
												$verify
												<a href='single-freelancer-profile.php?freelancer=$freelance'><img src='../images/freelancer/profile/$picture' alt=''></a>
											</div>

											<!-- Name -->
											<div class='freelancer-name'>
												<h4><a href='single-freelancer-profile.php?freelancer=$freelance'>$ffirstname $flastname <img class='flag' src=''../images/flags/de.svg' alt='' title='$nation' data-tippy-placement='top'></a></h4>
												<span>$tagline</span>
												<!-- Rating -->
												<div class='freelancer-rating'>
													<div class='star-rating' data-rating='4.2'></div>
												</div>
											</div>
										</div>
									</div>

									<!-- Buttons -->
									<div class='buttons-to-right'>
										<a href='deletebookmark.php?bookmark_id=$bid' class='button red ripple-effect ico' title='Remove' data-tippy-placement='left'><i class='icon-feather-trash-2'></i></a>
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