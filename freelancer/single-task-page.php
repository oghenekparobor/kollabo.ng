<?php
include('install.php');

if(!isset($_SESSION['user_id'])) {
	header("Location: ../login.php");
} else {
	$id = $_SESSION['user_id'];

	$sql = "SELECT * FROM freelancer WHERE user_id = '$id' LIMIT 1";
	$result = mysqli_query($con, $sql);
	$user = mysqli_fetch_assoc($result);

	$firstname = $user['firstname'];
	$lastname = $user['lastname'];
	$picture = $user['picture'];

	if (!isset($_GET['taskid'])) {
		header("Location: dashboard.php");
	} else {
		$taskid = $_GET['taskid'];

		$tas = "SELECT * FROM tasks WHERE id = '$taskid' LIMIT 1";
		$tasres = mysqli_query($con, $tas);
		$task = mysqli_fetch_assoc($tasres);
		$title = $task['title'];
		$type = $task['type'];
		$category = $task['category'];
		$min = $task['min_salary'];
		$max = $task['max_salary'];
		$tags = $task['tags'];
		$location = $task['location'];
		$description = $task['description'];
		$file = $task['files'];
		$userid = $task['user_id'];

		$user = "SELECT * FROM employer WHERE user_id = '$userid' LIMIT 1";
		$userres = mysqli_query($con, $user);
		$employer = mysqli_fetch_assoc($userres);
		$efirstname = $employer['firstname'];
		$elastname = $employer['lastname'];

		$cat = "SELECT * FROM category WHERE id = '$category' LIMIT 1";
		$catres = mysqli_query($con, $cat);
		$category = mysqli_fetch_assoc($catres);
		$cate = $category['category'];

		$c1 = "INSERT INTO `job_view` (`id`, `user_id`, `viewer_id`, `created`) VALUES (NULL, '$userid', '$id', current_timestamp())";
		mysqli_query($con, $c1);

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
<body>

<!-- Wrapper -->
<div id="wrapper">

<!-- Header Container
================================================== -->
<?php include('header.php'); ?>
<!-- Header Container / End -->



<!-- Titlebar
================================================== -->
<div class="single-page-header" data-background-image="../images/single-task.jpg">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="single-page-header-inner">
					<div class="left-side">
						<div class="header-image"><a href="single-company-profile.html"><img src="../images/browse-companies-02.png" alt=""></a></div>
						<div class="header-details">
							<h3><?php echo $title; ?></h3>
							<h5><?php echo $efirstname." ".$elastname; ?></h5>
							<ul>
								<li><a href=""><i class="icon-feather-grid"></i> <?php echo $cate; ?></a></li>
								<li><div class="star-rating" data-rating="5.0"></div></li>
								<li><img class="flag" src="../images/flags/de.svg" alt=""> <?php echo $location; ?></li>
								<li><div class="verified-badge-with-title">Verified</div></li>
							</ul>
						</div>
					</div>
					<div class="right-side">	
						<div class="salary-box">
							<div class="salary-type">Project Budget</div>
							<div class="salary-amount">₦<?php echo $min; ?> - ₦<?php echo $max; ?></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Page Content
================================================== -->
<div class="container">
	<div class="row">
		
		<!-- Content -->
		<div class="col-xl-8 col-lg-8 content-right-offset">
			
			<!-- Description -->
			<div class="single-page-section">
				<h3 class="margin-bottom-25">Project Description</h3>
				<p><?php echo $description; ?></p>
			</div>

			<!-- Atachments -->
			<div class="single-page-section">
				<h3>Attachments</h3>
				<div class="attachments-container">
					<a href="../images/employer/tasks/<?php echo $file; ?>" class="attachment-box ripple-effect"><span>Project Brief</span><i><?php echo pathinfo($file, PATHINFO_EXTENSION); ?></i></a>
				</div>
			</div>

			<!-- Skills -->
			<div class="single-page-section">
				<h3>Skills Required</h3>
				<div class="task-tags">
				<?php
				$tag = explode(",", $tags);
				for($i=0; $i < count($tag); $i++){
					echo "<span>$tag[$i]</span> &nbsp;";
				}
				?>
				</div>
			</div>
			<div class="clearfix"></div>
			
			<!-- Freelancers Bidding -->
			<div class="boxed-list margin-bottom-60">
				<div class="boxed-list-headline">
					<h3><i class="icon-material-outline-group"></i> Freelancers Bidding</h3>
				</div>
				<ul class="boxed-list-ul">
				<?php 
							$sql = "SELECT * FROM bidder WHERE task_id = '$taskid' ORDER BY DATE(created) DESC";
							$rs_result = mysqli_query ($con, $sql); //run the query 
							while ($row = mysqli_fetch_assoc($rs_result)) {
								$bid = $row['id'];
								$freelancer = $row['freelancer_id'];
								$price = $row['price'];
								$duration = $row['duration'];

								$t = "SELECT * FROM freelancer WHERE user_id = '$freelancer' LIMIT 1";
								$tr = mysqli_query($con, $t);
								$task = mysqli_fetch_assoc($tr);
								$first = $task['firstname'];
								$last = $task['lastname'];
								$pic = $task['picture'];
								$nation = $task['nationality'];

								echo "
					<li>
						<div class='bid'>
							<!-- Avatar -->
							<div class='bids-avatar'>
								<div class='freelancer-avatar'>
									<div class='verified-badge'></div>
									<a href='single-freelancer-profile.php?freelancer=$freelancer'><img src='../images/freelancer/profile/$pic' alt=''></a>
								</div>
							</div>
							
							<!-- Content -->
							<div class='bids-content'>
								<!-- Name -->
								<div class='freelancer-name'>
									<h4><a href='single-freelancer-profile.php?freelancer=$freelancer'>$first $last <img class='flag' src='../images/flags/gb.svg' alt='' title='$nation' data-tippy-placement='top'></a></h4>
									<div class='star-rating' data-rating='4.9'></div>
								</div>
							</div>
							
							<!-- Bid -->
							<div class='bids-bid'>
								<div class='bid-rate'>
									<div class='rate'>₦$price</div>
									<span>in $duration days</span>
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
		

		<!-- Sidebar -->
		<div class="col-xl-4 col-lg-4">
			<div class="sidebar-container">

				<!-- <div class="countdown green margin-bottom-35">6 days, 23 hours left</div> -->

				<div class="sidebar-widget">
					<div class="bidding-widget">
						<div class="bidding-headline"><h3>Bid on this job!</h3></div>
						<div class="bidding-inner">

							<!-- Headline -->
							<span class="bidding-detail">Set your <strong>minimal rate</strong></span>

							<!-- Price Slider -->
							<div class="bidding-value">₦<span id="biddingVal"></span></div>
							<input class="bidding-slider" type="text" id="bidding" data-slider-handle="custom" data-slider-currency="₦" data-slider-min="<?php echo $min; ?>" data-slider-max="<?php echo $max; ?>" data-slider-value="auto" data-slider-step="5" data-slider-tooltip="hide" />
							
							<!-- Headline -->
							<span class="bidding-detail margin-top-30">Set your <strong>delivery time</strong></span>

							<!-- Fields -->
							<div class="bidding-fields">
								<div class="bidding-field">
									<!-- Quantity Buttons -->
									<div class="qtyButtons">
										<div class="qtyDec"></div>
										<input type="text" name="qtyInput" id="duration" value="1">
										<div class="qtyInc"></div>
									</div>
								</div>
								<div class="bidding-field">
									<select class="selectpicker default">
										<option selected>Days</option>
									</select>
								</div>
							</div>

							<!-- Button -->
							<button id="snackbar-place-bid" class="button ripple-effect move-on-hover full-width margin-top-30"><span>Place a Bid</span></button>

						</div>
						<!-- <div class="bidding-signup">Don't have an account? <a href="#sign-in-dialog" class="register-tab sign-in popup-with-zoom-anim">Sign Up</a></div> -->
					</div>
				</div>

				<!-- Sidebar Widget -->
				<div class="sidebar-widget">
					<h3>Bookmark or Share</h3>

					<!-- Bookmark Button -->
					<?php
					$bookmark = "SELECT * FROM bookmark_freelancer WHERE user_id = '$id' "; 
					$bookmarkres = mysqli_query($con,$bookmark);
					$bookmarkcount = mysqli_num_rows($bookmarkres);
					
					$check;
					$text;
					if ($bookmarkcount > 0) {
						$check = "checked";
						$text = "Bookmarked";
					} else {
						$check = "";
						$text = "Bookmark";
					}
					echo "
					<div class='switches-list'>
						<div class='switch-container'>
							<label class='switch'><input type='checkbox' id='bookmark_it' $check><span class='switch-button'></span> $text</label>
						</div>
					</div><br><br>";
					?>

					<!-- Copy URL -->
					<div class="copy-url">
						<input id="copy-url" type="text" value="" class="with-border">
						<button class="copy-url-button ripple-effect" data-clipboard-target="#copy-url" title="Copy to Clipboard" data-tippy-placement="top"><i class="icon-material-outline-file-copy"></i></button>
					</div>

					<!-- Share Buttons -->
					<div class="share-buttons margin-top-25">
						<div class="share-buttons-trigger"><i class="icon-feather-share-2"></i></div>
						<div class="share-buttons-content">
							<span>Interesting? <strong>Share It!</strong></span>
							<ul class="share-buttons-icons">
								<li><a href="#" data-button-color="#3b5998" title="Share on Facebook" data-tippy-placement="top"><i class="icon-brand-facebook-f"></i></a></li>
								<li><a href="#" data-button-color="#1da1f2" title="Share on Twitter" data-tippy-placement="top"><i class="icon-brand-twitter"></i></a></li>
								<li><a href="#" data-button-color="#dd4b39" title="Share on Google Plus" data-tippy-placement="top"><i class="icon-brand-google-plus-g"></i></a></li>
								<li><a href="#" data-button-color="#0077b5" title="Share on LinkedIn" data-tippy-placement="top"><i class="icon-brand-linkedin-in"></i></a></li>
							</ul>
						</div>
					</div>
				</div>

			</div>
		</div>

	</div>
</div>


<!-- Spacer -->
<div class="margin-top-15"></div>
<!-- Spacer / End-->

<!-- Footer
================================================== -->
<?php include('../footer.php'); ?>
<!-- Footer / End -->

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

// Snackbar for "place a bid" button
$('#snackbar-place-bid').click(function() { 
	var price = document.getElementById('bidding').value;
	var duration = document.getElementById('duration').value;

	$.ajax({
    	url: 'placebid.php',
		type: "POST",
		data: {
			'employer_id': <?php echo $userid; ?>,
			'freelancer_id': <?php echo $id; ?>,
			'task_id': <?php echo $taskid; ?>,
			'price': price,
			'duration': duration
		},
    	success: function (response) {
      		if (response == 'BID_EXIST') {
				Snackbar.show({
					text: 'Your bid already exist!',
				}); 
			} else if (response == 'BID_PLACED') {
				Snackbar.show({
					text: 'Your bid has been placed!',
				});
				location.reload();
			} else if (response == 'BID_ERROR') {
				Snackbar.show({
					text: 'Error placing bid!',
				});
			}
    	}
  	});
}); 

$('#bookmark_it').click(function() { 
	$.ajax({
    	url: 'add_remove_bookmark.php',
		type: "POST",
		data: {
			'freelancer_id': <?php echo $id; ?>,
			'task_id': <?php echo $taskid; ?>,
		},
    	success: function (response) {
      		if (response) {
				Snackbar.show({
					text: 'Added to bookmark!',
				}); 
			} else {
				Snackbar.show({
					text: 'Removed from bookmark!',
				});
			}
    	}
  	});
}); 


// Snackbar for copy to clipboard button
$('.copy-url-button').click(function() { 
	Snackbar.show({
		text: 'Copied to clipboard!',
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