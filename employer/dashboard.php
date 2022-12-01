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
<title>Kollabo </title>
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
				<h3>Howdy, <?php echo $firstname; ?> </h3>
				<span>We are glad to see you!</span>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs" class="dark">
					<ul>
						<li><a href="#">Home</a></li>
						<li>Dashboard</li>
					</ul>
				</nav>
			</div>
	
			<!-- Fun Facts Container -->
			<div class="fun-facts-container">
				<div class="fun-fact" data-fun-fact-color="#36bd78">
					<div class="fun-fact-text">
						<span>Total Tasks</span>
						<h4><?php
								$tasks = "SELECT * FROM tasks WHERE user_id = '$id' "; 
								$taskres=mysqli_query($con,$tasks);
								$taskcount = mysqli_num_rows($taskres); 
								echo $taskcount;
								?></h4>
					</div>
					<div class="fun-fact-icon"><i class="icon-material-outline-gavel"></i></div>
				</div>
				<div class="fun-fact" data-fun-fact-color="#efa80f">
					<div class="fun-fact-text">
						<span>Active Bids</span>
						<h4><?php
								$tasks = "SELECT * FROM tasks WHERE user_id = '$id' AND bid_status = 'active' "; 
								$taskres=mysqli_query($con,$tasks);
								$taskcount = mysqli_num_rows($taskres); 
								echo $taskcount;
								?></h4>
					</div>
					<div class="fun-fact-icon"><i class="icon-material-outline-rate-review"></i></div>
				</div>

				<!-- Last one has to be hidden below 1600px, sorry :( -->
				<div class="fun-fact" data-fun-fact-color="#2a41e6">
					<div class="fun-fact-text">
						<span>This Month Views</span>
						<h4><?php
						$da = date('F');
						$count = "SELECT * FROM job_view WHERE user_id = '$id' AND MONTHNAME(created) = '$da' ";
						echo mysqli_num_rows(mysqli_query($con, $count));
						?></h4>
					</div>
					<div class="fun-fact-icon"><i class="icon-feather-trending-up"></i></div>
				</div>
			</div>
			
			<!-- Row -->
			<div class="row">

				<div class="col-xl-8">
					<!-- Dashboard Box -->
					<div class="dashboard-box main-box-in-row">
						<div class="headline">
							<h3><i class="icon-feather-bar-chart-2"></i> Your Job Views</h3>
							<div class="sort-by">
								<select class="selectpicker hide-tick">
									<option>Last 6 Months</option>
									<!-- <option>This Year</option>
									<option>This Month</option> -->
								</select>
							</div>
						</div>
						<div class="content">
							<!-- Chart -->
							<div class="chart">
								<canvas id="chart" width="100" height="45"></canvas>
							</div>
						</div>
					</div>
					<!-- Dashboard Box / End -->
				</div>
				<div class="col-xl-4">

					<!-- Dashboard Box -->
					<!-- If you want adjust height of two boxes 
						 add to the lower box 'main-box-in-row' 
						 and 'child-box-in-row' to the higher box -->
					<div class="dashboard-box child-box-in-row"> 
						<div class="headline">
							<h3><i class="icon-material-outline-note-add"></i> Notes</h3>
						</div>	

						<div class="content with-padding">
							<!-- Note -->
							<?php 
							$sql = "SELECT * FROM notes WHERE user_id = '$id' ORDER BY DATE(created) DESC";
							$rs_result = mysqli_query ($con, $sql); //run the query 
							while ($row = mysqli_fetch_assoc($rs_result)) {
								$nid = $row['id'];
								$priority= $row['priority'];
								$note = $row['note'];

								if ($priority == 'low') {
									$priority = "<span class='note-priority low'>Low Priority</span>";
								} else if ($priority == 'medium') {
									$priority = "<span class='note-priority medium'>Medium Priority</span>";
								} else {
									$priority = "<span class='note-priority high'>High Priority</span>";
								}
																			
								echo "
								<div class='dashboard-note'>
									<p>$note</p>
									<div class='note-footer'>
										$priority
										<div class='note-buttons'>
											<a href='deletenote.php?note_id=$nid' title='Remove' data-tippy-placement='top'><i class='icon-feather-trash-2'></i></a>
										</div>
									</div>
								</div>";
							}
							?>
							<!-- Note -->
						</div>
							<div class="add-note-button">
								<a href="#small-dialog" class="popup-with-zoom-anim button full-width button-sliding-icon">Add Note <i class="icon-material-outline-arrow-right-alt"></i></a>
							</div>
					</div>
					<!-- Dashboard Box / End -->
				</div>
			</div>
			<!-- Row / End -->

			<!-- Row -->
			<div class="row">

				<!-- Dashboard Box -->
				<div class="col-xl-6">
					<div class="dashboard-box">
						<div class="headline">
							<h3><i class="icon-material-baseline-notifications-none"></i> Notifications</h3>
							<button class="mark-as-read ripple-effect-dark" data-tippy-placement="left" title="Mark all as read">
									<i class="icon-feather-check-square"></i>
							</button>
						</div>
						<div class="content">
							<ul class="dashboard-box-list">
							<?php 
							$sql = "SELECT * FROM notification WHERE user_id = '$id' AND read_status = 'new' ORDER BY DATE(created) DESC";
							$rs_result = mysqli_query ($con, $sql); //run the query 
							while ($row = mysqli_fetch_assoc($rs_result)) {
								$nid = $row['id'];
								$notification= $row['notification'];
								$read_status = $row['read_status'];
								$type = $row['type'];

								echo "
								<li>
									<span class='notification-icon'><i class='icon-material-outline-group'></i></span>
									<span class='notification-text'>
										$notification
									</span>
									<div class='buttons-to-right'>
										<a href='markasread.php?notification_id=$nid' class='button ripple-effect ico' title='Mark as read' data-tippy-placement='left'><i class='icon-feather-check-square'></i></a>
									</div>
								</li>
								";
							}
							?>
							</ul>
						</div>
					</div>
				</div>

				<!-- Dashboard Box -->
				<div class="col-xl-6">
					<div class="dashboard-box">
						<div class="headline">
							<h3><i class="icon-material-outline-assignment"></i> Orders</h3>
						</div>
						<div class="content">
							<ul class="dashboard-box-list">
							<?php 
							$sql = "SELECT * FROM orders WHERE employer_id = '$id' ORDER BY id DESC";
							$rs_result = mysqli_query ($con, $sql); //run the query 
							while ($row = mysqli_fetch_assoc($rs_result)) {
								$oid = $row['id'];
								$taskid= $row['my_task_id'];
								$orderref = $row['order_ref'];
								$status = $row['status'];
								$created = $row['created'];
								$created = date('D d M Y', strtotime($created));

								$sql = "SELECT * FROM mytask WHERE id = '$taskid' LIMIT 1";
								$result = mysqli_query($con, $sql);
								$user = mysqli_fetch_assoc($result);
								$tid = $user['task_id'];
								$budget = $user['budget'];

								$button;
								$bt;

								if ($status == 'paid') {
									$bt = "<li><span class='paid'>Paid</span></li>";
									$button = "<a href='invoice.php?invoice_id=$oid' class='button gray'>View Invoice</a>";
								} else {
									$bt = "<li><span class='unpaid'>Unpaid</span></li>";
									$button = "<a href='checkout.php?order_id=$oid' class='button'>Finish Payment</a>";
								}

								echo "
								<li>
									<div class='invoice-list-item'>
									<strong></strong>
										<ul>
											$bt
											<li>Order: #$orderref</li>
											<li>Date: $created</li>
										</ul>
									</div>
									<div class='buttons-to-right'>
										$button
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


<!-- Apply for a job popup
================================================== -->
<div id="small-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

	<!--Tabs -->
	<div class="sign-in-form">

		<ul class="popup-tabs-nav">
			<li><a href="#tab">Add Note</a></li>
		</ul>

		<div class="popup-tabs-container">

			<!-- Tab -->
			<div class="popup-tab-content" id="tab">
				
				<!-- Welcome Text -->
				<div class="welcome-text">
					<h3>Do Not Forget 😎</h3>
				</div>
					
				<!-- Form -->
				<form method="post" id="add-note" action="features.php">

					<select name="priority" class="selectpicker with-border default margin-bottom-20" data-size="7" title="Priority">
						<option value="low">Low Priority</option>
						<option value="medium">Medium Priority</option>
						<option value="high">High Priority</option>
					</select>

					<input type="hidden" value="<?php echo $id; ?>" name="user_id"/>

					<textarea name="note" cols="10" placeholder="Note" class="with-border"></textarea>

					<button name="add_note" class="button full-width button-sliding-icon" type="submit" form="add-note">Add Note <i class="icon-material-outline-arrow-right-alt"></i></button>

				</form>

			</div>

		</div>
	</div>
</div>
<!-- Apply for a job popup / End -->


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

<!-- Chart.js // documentation: http://www.chartjs.org/docs/latest/ -->
<script src="../js/chart.min.js"></script>
<script>
	Chart.defaults.global.defaultFontFamily = "Nunito";
	Chart.defaults.global.defaultFontColor = '#888';
	Chart.defaults.global.defaultFontSize = '14';

	var ctx = document.getElementById('chart').getContext('2d');

	var chart = new Chart(ctx, {
		type: 'line',

		// The data for our dataset
		data: {
		<?php
		for ($i = 1; $i <= 6; $i++) 
		{
		   $months[] = date("F", strtotime( date( 'Y-m' )." -$i months"));
		}
		?>
			labels: ["<?php echo $months[0]; ?>", "<?php echo $months[1]; ?>", "<?php echo $months[2]; ?>", "<?php echo $months[3]; ?>", "<?php echo $months[4]; ?>", "<?php echo $months[5]; ?>"],
			// Information about the dataset
	   		datasets: [{
				label: "Views",
				backgroundColor: "rgba(42,65,232,0.08)",
				borderColor: "#2a41e8",
				borderWidth: "3",
				data: [
					<?php
					$count = "SELECT * FROM job_view WHERE user_id = '$id' AND MONTHNAME(created) = '$months[0]' ";
					echo mysqli_num_rows(mysqli_query($con, $count));
					?>,
					<?php
					$count = "SELECT * FROM job_view WHERE user_id = '$id' AND MONTHNAME(created) = '$months[1]' ";
					echo mysqli_num_rows(mysqli_query($con, $count));
					?>,
					<?php
					$count = "SELECT * FROM job_view WHERE user_id = '$id' AND MONTHNAME(created) = '$months[2]' ";
					echo mysqli_num_rows(mysqli_query($con, $count));
					?>,
					<?php
					$count = "SELECT * FROM job_view WHERE user_id = '$id' AND MONTHNAME(created) = '$months[3]' ";
					echo mysqli_num_rows(mysqli_query($con, $count));
					?>,
					<?php
					$count = "SELECT * FROM job_view WHERE user_id = '$id' AND MONTHNAME(created) = '$months[4]' ";
					echo mysqli_num_rows(mysqli_query($con, $count));
					?>,
					<?php
					$count = "SELECT * FROM job_view WHERE user_id = '$id' AND MONTHNAME(created) = '$months[5]' ";
					echo mysqli_num_rows(mysqli_query($con, $count));
					?>],
				pointRadius: 5,
				pointHoverRadius:5,
				pointHitRadius: 10,
				pointBackgroundColor: "#fff",
				pointHoverBackgroundColor: "#fff",
				pointBorderWidth: "2",
			}]
		},

		// Configuration options
		options: {

		    layout: {
		      padding: 10,
		  	},

			legend: { display: false },
			title:  { display: false },

			scales: {
				yAxes: [{
					scaleLabel: {
						display: false
					},
					gridLines: {
						 borderDash: [6, 10],
						 color: "#d8d8d8",
						 lineWidth: 1,
	            	},
				}],
				xAxes: [{
					scaleLabel: { display: false },  
					gridLines:  { display: false },
				}],
			},

		    tooltips: {
		      backgroundColor: '#333',
		      titleFontSize: 13,
		      titleFontColor: '#fff',
		      bodyFontColor: '#fff',
		      bodyFontSize: 13,
		      displayColors: false,
		      xPadding: 10,
		      yPadding: 10,
		      intersect: false
		    }
		},


});

</script>

</body>

</html>
