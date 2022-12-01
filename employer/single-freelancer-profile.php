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

	if (!isset($_GET['freelancer'])) {
		header("Location: dashboard.php");
	} else {
		$freelancer = $_GET['freelancer'];

		// increase count by 1
		$c1 = "INSERT INTO `profile_view` (`id`, `user_id`, `viewer_id`, `created`) VALUES (NULL, '$freelancer', '$id', current_timestamp())";
		mysqli_query($con, $c1);

		$lancer = "SELECT * FROM freelancer WHERE user_id = '$freelancer' LIMIT 1";
		$lancerres = mysqli_query($con, $lancer);
		$lanc = mysqli_fetch_assoc($lancerres);

		$lfirstname = $lanc['firstname'];
		$llastname = $lanc['lastname'];
		$fpicture = $lanc['picture'];
		$lemail = $lanc['email'];
		$lintro = $lanc['introduction'];
		$ltagline = $lanc['tagline'];
		$lnation = $lanc['nationality'];
		$lverify = $lanc['verified'];
		$attach = $lanc['attachment'];
		$hourlyrate = $lanc['minimal_hourly_rate'];
		$skills = $lanc['skills'];
		$verified;

		if ($lverify == 'true') {
			$verified = "Verified";
		} else {
			$verified = "";
		}

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
<div class="clearfix"></div>
<!-- Header Container / End -->

<!-- Titlebar
================================================== -->
<div class="single-page-header freelancer-header" data-background-image="../images/single-freelancer.jpg">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="single-page-header-inner">
					<div class="left-side">
						<div class="header-image freelancer-avatar"><img src="../images/freelancer/profile/<?php echo $fpicture; ?>" alt=""></div>
						<div class="header-details">
							<h3><?php echo $lfirstname." ".$llastname; ?> <span><?php echo $ltagline; ?></span></h3>
							<ul>
								<li><div class="star-rating" data-rating="5.0"></div></li>
								<li><img class="flag" src="images/flags/de.svg" alt=""> <?php echo $lnation; ?></li>
								<li><div class="verified-badge-with-title"><?php echo $verified; ?></div></li>
							</ul>
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
			
			<!-- Page Content -->
			<div class="single-page-section">
				<h3 class="margin-bottom-25">About Me</h3>
				<p><?php echo $lintro; ?></p>
			</div>

			<!-- Boxed List -->
			<div class="boxed-list margin-bottom-60">
				<div class="boxed-list-headline">
					<h3><i class="icon-material-outline-thumb-up"></i> Work History and Feedback</h3>
				</div>
				<ul class="boxed-list-ul">
				<?php 
				$page_no;
				if (isset($_GET['page_no']) && $_GET['page_no']!="") {
					$page_no = $_GET['page_no'];
				} else {
					$page_no = 1;
				}
				$total_records_per_page = 5;
				$offset = ($page_no-1) * $total_records_per_page;
				$previous_page = $page_no - 1;
				$next_page = $page_no + 1;
				$adjacents = "2";
			
				$result_count = mysqli_query($con, "SELECT COUNT(*) As total_records FROM `mytask` WHERE freelancer_id = '$freelancer' ");
					$total_records = mysqli_fetch_array($result_count);
					$total_records = $total_records['total_records'];
					$total_no_of_pages = ceil($total_records / $total_records_per_page);
					$second_last = $total_no_of_pages - 1;

							$sql = "SELECT * FROM mytask WHERE freelancer_id = '$freelancer' ORDER BY DATE(created) DESC LIMIT $offset, $total_records_per_page";
							$rs_result = mysqli_query ($con, $sql); //run the query 
							while ($row = mysqli_fetch_assoc($rs_result)) {
								$myid = $row['id'];
								$lancer= $row['freelancer_id'];
								$employer = $row['employer_id'];
								$taskid = $row['task_id'];
								$feedback = $row['feedback'];
								$created = $row['created'];

								$sql1 = "SELECT * FROM tasks WHERE id = '$taskid' LIMIT 1";
								$result1 = mysqli_query($con, $sql1);
								$task = mysqli_fetch_assoc($result1);
								$title = $task['title'];
								$location = $task['location'];
																			
								echo "
					<li>
						<div class='boxed-list-item'>
							<!-- Content -->
							<div class='item-content'>
								<h4>$title <span>$location</span></h4>
								<div class='item-details margin-top-10'>
									<div class='star-rating' data-rating='5.0'></div>
									<div class='detail-item'><i class='icon-material-outline-date-range'></i>$created</div>
								</div>
								<div class='item-description'>
									<p>$feedback</p>
								</div>
							</div>
						</div>
					</li>
					";
							}
							?>
				</ul>

				<!-- Pagination -->
				<div class="clearfix"></div>
				<div class="pagination-container margin-top-40 margin-bottom-10">
					<nav class="pagination">
						<ul>
						<?php
							if ($total_no_of_pages <= 10){   
 								for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
 									if ($counter == $page_no) {
 										echo "<li class='ripple-effect current-page'><a>$counter</a></li>"; 
        							}else{
        								echo "<li><a href='?page_no=$counter&freelancer=$freelancer' class='ripple-effect'>$counter</a></li>";
                					}
        						}
							}
							?>
						</ul>
					</nav>
				</div>
				<div class="clearfix"></div>
				<!-- Pagination / End -->

			</div>
			<!-- Boxed List / End -->

		</div>
		

		<!-- Sidebar -->
		<div class="col-xl-4 col-lg-4">
			<div class="sidebar-container">
				
				<!-- Profile Overview -->
				<div class="profile-overview">
					<div class="overview-item"><strong>₦<?php echo $hourlyrate; ?></strong><span>Hourly Rate</span></div>
					<div class="overview-item"><strong><?php
								$tasks = "SELECT * FROM mytask WHERE freelancer_id = '$freelancer' AND finished IS NOT NULL "; 
								$taskres=mysqli_query($con,$tasks);
								$taskcount = mysqli_num_rows($taskres); 
								echo $taskcount;
								?></strong><span>Tasks Done</span></div>
					<div class="overview-item"><strong>22</strong><span>Rehired</span></div>
				</div>

				<!-- Button -->
				<a href="#small-dialog" class="apply-now-button popup-with-zoom-anim margin-bottom-50">Make an Offer <i class="icon-material-outline-arrow-right-alt"></i></a>

				<!-- Freelancer Indicators -->
				<div class="sidebar-widget">
					<div class="freelancer-indicators">

						<!-- Indicator -->
						<div class="indicator">
						<?php
							$success = "SELECT * FROM mytask WHERE freelancer_id = '$freelancer' AND finished IS NOT NULL "; 
							$successres=mysqli_query($con,$success);
							$successcount = mysqli_num_rows($successres);
							
							$total = "SELECT * FROM mytask WHERE freelancer_id = '$freelancer' "; 
							$totalres=mysqli_query($con,$total);
							$totalcount = mysqli_num_rows($totalres);

							$calc;
							if ($totalcount < 1){
								$calc = 0;
							} else {
								$calc = ($successcount / $totalcount) * 100;
								$calc = number_format($calc, 0);
							}

							echo "
							<strong>$calc%</strong>
							<div class='indicator-bar' data-indicator-percentage='$calc'><span></span></div>
							<span>Job Success</span>";
							?>
						</div>

						<!-- Indicator -->
						<!-- <div class="indicator">
							<strong>100%</strong>
							<div class="indicator-bar" data-indicator-percentage="100"><span></span></div>
							<span>Recommendation</span>
						</div> -->
						
						<!-- Indicator -->
						<div class="indicator">
						<?php							
							$success = "SELECT * FROM mytask WHERE freelancer_id = '$freelancer' AND DATE(finished) <= DATE(delivery) "; 
							$successres=mysqli_query($con,$success);
							$successcount = mysqli_num_rows($successres);
							
							$total = "SELECT * FROM mytask WHERE freelancer_id = '$freelancer' "; 
							$totalres=mysqli_query($con,$total);
							$totalcount = mysqli_num_rows($totalres);

							$calc;
							if ($totalcount < 1) {
								$calc = 0;
							} else {
								$calc = ($successcount / $totalcount) * 100;
								$calc = number_format($calc, 0);
							}

							echo "
							<strong>$calc%</strong>
							<div class='indicator-bar' data-indicator-percentage='$calc'><span></span></div>
							<span>On Time</span>";
							?>
						</div>	
											
						<!-- Indicator -->
						<!-- <div class="indicator">
						<?php
							$taskid;
							$sql = "SELECT * FROM mytask WHERE freelancer_id = '$freelancer' ORDER BY DATE(created) DESC";
							$rs_result = mysqli_query ($con, $sql); //run the query 
							while ($row = mysqli_fetch_assoc($rs_result)) {
								$taskid = $row['task_id'];
							}

							$sal = "SELECT * FROM tasks WHERE id = '$taskid' LIMIT 1";
							$salres = mysqli_query($con, $sal);
							$salary = mysqli_fetch_assoc($salres);
							$min = $salary['min_salary'];
							$max = $salary['max_salary'];

							$success = "SELECT * FROM mytask WHERE freelancer_id = '$freelancer' AND budget > $min AND budget < $max "; 
							$successres=mysqli_query($con,$success);
							$successcount = mysqli_num_rows($successres);
							
							$total = "SELECT * FROM mytask WHERE freelancer_id = '$freelancer' "; 
							$totalres=mysqli_query($con,$total);
							$totalcount = mysqli_num_rows($totalres);

							$calc = ($successcount / $totalcount) * 100;

							echo "
							<strong>$calc%</strong>
							<div class='indicator-bar' data-indicator-percentage='$calc'><span></span></div>
							<span>On Budget</span>";
							?>
						</div> -->
					</div>
				</div>
				
				<!-- Widget -->
				<div class="sidebar-widget">
					<h3>Social Profiles</h3>
					<div class="freelancer-socials margin-top-25">
						<ul>
							<li><a href="#" title="Dribbble" data-tippy-placement="top"><i class="icon-brand-dribbble"></i></a></li>
							<li><a href="#" title="Twitter" data-tippy-placement="top"><i class="icon-brand-twitter"></i></a></li>
							<li><a href="#" title="Behance" data-tippy-placement="top"><i class="icon-brand-behance"></i></a></li>
							<li><a href="#" title="GitHub" data-tippy-placement="top"><i class="icon-brand-github"></i></a></li>
						
						</ul>
					</div>
				</div>

				<!-- Widget -->
				<div class="sidebar-widget">
					<h3>Skills</h3>
					<div class="task-tags">
						<?php
							$skill = explode(",", $skills);
							for($i=0; $i < count($skill); $i++){
								echo "<span>$skill[$i]</span> &nbsp;";
							}
						?>
					</div>
				</div>

				<!-- Widget -->
				<div class="sidebar-widget">
					<h3>Attachments</h3>
					<div class="attachments-container">
						<a href="../images/freelancer/documents/<?php echo $attach; ?>" class="attachment-box ripple-effect"><span><?php echo $attach; ?></span><i><?php echo pathinfo($attach, PATHINFO_EXTENSION); ?></i></a>
					</div>
				</div>

				<!-- Sidebar Widget -->
				<div class="sidebar-widget">
					<h3>Bookmark or Share</h3>

					<!-- Bookmark Button -->
					<?php
					$bookmark = "SELECT * FROM bookmark_employer WHERE user_id = '$id' AND freelance = '$freelancer' "; 
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


<!-- Make an Offer Popup
================================================== -->
<div id="small-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

	<!--Tabs -->
	<div class="sign-in-form">

		<ul class="popup-tabs-nav">
			<li><a href="#tab">Make an Offer</a></li>
		</ul>

		<div class="popup-tabs-container">

			<!-- Tab -->
			<div class="popup-tab-content" id="tab">
				
				<!-- Welcome Text -->
				<div class="welcome-text">
					<h3>Discuss your project with <?php echo $lfirstname; ?></h3>
				</div>
					
				<!-- Form -->
				<form method="post" action="features.php" enctype="multipart/form-data" id="makeoffer">

					<div class="input-with-icon-left">
						<i class="icon-material-outline-account-circle"></i>
						<input type="text" class="input-text with-border" name="name" id="name" placeholder="First and Last Name" value="<?php echo $firstname." ".$lastname ; ?>" readonly=""/>
					</div>

					<div class="input-with-icon-left">
						<i class="icon-material-baseline-mail-outline"></i>
						<input type="text" class="input-text with-border" name="emailaddress" id="emailaddress" placeholder="Email Address" value="<?php echo $email; ?>" readonly=""/>
					</div>

					<textarea name="textarea" cols="10" placeholder="Message" class="with-border"></textarea>

					<div class="uploadButton margin-top-25">
						<input type="hidden" value="<?php echo $id; ?>" name="user_id" />
						<input type="hidden" value="<?php echo $freelancer; ?>" name="freelancer_id" />
						<input class="uploadButton-input" name="file" type="file" accept="image/*, application/pdf, audio/*" id="upload" multiple/>
						<label class="uploadButton-button ripple-effect" for="upload">Add Attachments</label>
						<span class="uploadButton-file-name">Allowed file types: mp3, pdf, png, jpg <br> Max. files size: 50 MB.</span>
					</div>

				</form>
				
				<!-- Button -->
				<button name="make_offer" class="button margin-top-35 full-width button-sliding-icon ripple-effect" type="submit" form="makeoffer">Make an Offer <i class="icon-material-outline-arrow-right-alt"></i></button>

			</div>

		</div>
	</div>
</div>
<!-- Make an Offer Popup / End -->



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

$('#bookmark_it').click(function() { 
	$.ajax({
    	url: 'add_remove_bookmark.php',
		type: "POST",
		data: {
			'employer_id': <?php echo $id; ?>,
			'freelance': <?php echo $freelancer; ?>,
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

// Snackbar for "place a bid" button
$('#snackbar-place-bid').click(function() { 
	Snackbar.show({
		text: 'Your bid has been placed!',
	}); 
}); 


// Snackbar for copy to clipboard button
$('.copy-url-button').click(function() { 
	Snackbar.show({
		text: 'Copied to clipboard!',
	}); 
}); 
</script>

</body>

</html>