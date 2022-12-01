<?php
include('install.php');

if(!isset($_SESSION['user_id'])) {
	header("Location: ../index.php");
} else {
	$id = $_SESSION['user_id'];

	$sql = "SELECT * FROM employer WHERE user_id = '$id' LIMIT 1";
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

		</div>
		

		<!-- Sidebar -->
		<div class="col-xl-4 col-lg-4">
			<div class="sidebar-container">

				<!-- Sidebar Widget -->
				<div class="sidebar-widget">
					<h3>Share</h3>

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

// Snackbar for copy to clipboard button
$('.copy-url-button').click(function() { 
	Snackbar.show({
		text: 'Copied to clipboard!',
	}); 
}); 
</script>

</body>

</html>