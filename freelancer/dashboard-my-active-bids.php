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
				<h3>My Active Bids</h3>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs" class="dark">
					<ul>
						<li><a href="#">Home</a></li>
						<li><a href="dashboard.php">Dashboard</a></li>
						<li>My Active Bids</li>
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
							<h3><i class="icon-material-outline-gavel"></i> Bids List</h3>
						</div>

						<div class="content">
							<ul class="dashboard-box-list">

							<?php 
				$sql = "SELECT * FROM bidder WHERE freelancer_id = '$id' ";
				$rs_result = mysqli_query ($con, $sql); //run the query 
				while ($row = mysqli_fetch_assoc($rs_result)) {
					$bid = $row['id'];
					$employer_id = $row['employer_id'];
					$freelancer_id = $row['freelancer_id'];
					$task_id = $row['task_id'];
					$budget = $row['price'];
					$duration = $row['duration'];

					$ta = "SELECT * FROM tasks WHERE id = '$task_id' LIMIT 1";
					$tares = mysqli_query($con, $ta);
					$task = mysqli_fetch_assoc($tares);
					$title = $task['title'];
					$type = $task['type'];
																			
					echo "
								<li>
									<div class='job-listing width-adjustment'>

										<div class='job-listing-details'>

											<div class='job-listing-description'>
												<h3 class='job-listing-title'><a href='single-task-page.php?taskid=$task_id'>$title</a></h3>
											</div>
										</div>
									</div>
									
									<ul class='dashboard-task-info'>
										<li><strong>₦$budget</strong><span>$type</span></li>
										<li><strong>$duration Days</strong><span>Delivery Time</span></li>
									</ul>

									<div class='buttons-to-right always-visible'>
										<a href='#small-dialog-$bid' class='popup-with-zoom-anim button dark ripple-effect ico' title='Edit Bid' data-tippy-placement='top'><i class='icon-feather-edit'></i></a>
										<a href='cancelbid.php?bidder_id=$bid' class='button red ripple-effect ico' title='Cancel Bid' data-tippy-placement='top'><i class='icon-feather-trash-2'></i></a>
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


<!-- Edit Bid Popup
================================================== -->
<?php 
				$sql = "SELECT * FROM bidder WHERE freelancer_id = '$id' ";
				$rs_result = mysqli_query ($con, $sql); //run the query 
				while ($row = mysqli_fetch_assoc($rs_result)) {
					$bid = $row['id'];
					$employer_id = $row['employer_id'];
					$freelancer_id = $row['freelancer_id'];
					$task_id = $row['task_id'];
					$budget = $row['price'];
					$duration = $row['duration'];

					$ta = "SELECT * FROM tasks WHERE id = '$task_id' LIMIT 1";
					$tares = mysqli_query($con, $ta);
					$task = mysqli_fetch_assoc($tares);
					$title = $task['title'];
					$type = $task['type'];
					$min = $task['min_salary'];
					$max = $task['max_salary'];
																			
					echo "
<div id='small-dialog-$bid' class='zoom-anim-dialog mfp-hide dialog-with-tabs'>

	<div class='sign-in-form'>

		<ul class='popup-tabs-nav'>
			<li><a href='#tab'>Edit Bid</a></li>
		</ul>

		<div class='popup-tabs-container'>

			<div class='popup-tab-content' id='tab'>
					<div class='bidding-widget'>

						<span class='bidding-detail'>Set your <strong>minimal hourly rate</strong></span>

						<div class='bidding-value'>₦<span id='biddingVal'></span></div>
						<input class='bidding-slider' name='price' id='price' type='text' value='$budget' data-slider-handle='custom' data-slider-currency='₦' data-slider-min='$min' data-slider-max='$max' data-slider-value='$budget' data-slider-step='5' data-slider-tooltip='hide' />
						
						<input type='hidden' name='bid_id' id='bid_id' value='$bid' />
						<span class='bidding-detail margin-top-30'>Set your <strong>delivery time</strong></span>

						<div class='bidding-fields'>
							<div class='bidding-field'>
								<!-- Quantity Buttons -->
								<div class='qtyButtons with-border'>
									<div class='qtyDec'></div>
									<input type='text' name='duration' id='duration' value='$duration'>
									<div class='qtyInc'></div>
								</div>
							</div>
							<div class='bidding-field'>
								<select class='selectpicker default with-border'>
									<option selected>Days</option>
								</select>
							</div>
						</div>
				</div>
				
				<!-- Button -->
				<button id='snackbar-edit-bid' class='button full-width button-sliding-icon ripple-effect' type='submit'>Save Changes <i class='icon-material-outline-arrow-right-alt'></i></button>
			</div>

		</div>
	</div>
</div>
";
				}
				?>
<!-- Edit Bid Popup / End -->

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
$('#snackbar-edit-bid').click(function() { 
	var price = document.getElementById('price').value;
	var duration = document.getElementById('duration').value;
	var bid = document.getElementById('bid_id').value;

	$.ajax({
    	url: 'editbid.php',
		type: "POST",
		data: {
			'bid_id': bid,
			'price': price,
			'duration': duration
		},
    	success: function (response) {
      		if (response == 'BID_EDITED') {
				Snackbar.show({
					text: 'Your bid has been edited!',
				}); 
				location.reload();
			} else if (response == 'BID_EDIT_ERROR') {
				Snackbar.show({
					text: 'Error editing bid!',
				});
			}
    	}
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