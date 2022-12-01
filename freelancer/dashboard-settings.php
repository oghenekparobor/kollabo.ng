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
	$minimal_rate = $user['minimal_hourly_rate'];
	$skills = $user['skills'];
	$attachment = $user['attachment'];
	$contract = $user['contract'];
	$tagline = $user['tagline'];
	$verified = $user['verified'];

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
				<h3>Settings</h3>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs" class="dark">
					<ul>
						<li><a href="#">Home</a></li>
						<li><a href="dashboard.php">Dashboard</a></li>
						<li>Settings</li>
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
							<h3><i class="icon-material-outline-account-circle"></i> My Account</h3>
						</div>

						<div class="content with-padding padding-bottom-0">

						<form action="features.php" method="POST" enctype="multipart/form-data">

							<div class="row">

								<input type="hidden" name="userid" value="<?php echo $id; ?>" />

								<div class="col-auto">
									<div class="avatar-wrapper" data-tippy-placement="bottom" title="Change Avatar">
										<img class="profile-pic" src="../images/freelancer/profile/<?php echo $picture; ?>" alt="" />
										<div class="upload-button"></div>
										<input class="file-upload" name="file" type="file" accept="image/*"/>
									</div>
								</div>

								<div class="col">
									<div class="row">

										<div class="col-xl-6">
											<div class="submit-field">
												<h5>First Name</h5>
												<input type="text" name="firstname" class="with-border" value="<?php echo $firstname; ?>">
											</div>
										</div>

										<div class="col-xl-6">
											<div class="submit-field">
												<h5>Last Name</h5>
												<input type="text" class="with-border" name="lastname" value="<?php echo $lastname; ?>">
											</div>
										</div>

										<div class="col-xl-6">
											<!-- Account Type -->
											<div class="submit-field">
												<h5>Account Type</h5>
												<div class="account-type">
													<div>
														<input type="radio" name="account-type-radio" id="freelancer-radio" class="account-type-radio" checked/>
														<label for="freelancer-radio" class="ripple-effect-dark"><i class="icon-material-outline-account-circle"></i> Freelancer</label>
													</div>
												</div>
											</div>
										</div>

										<div class="col-xl-6">
											<div class="submit-field">
												<h5>Email</h5>
												<input type="text" name="email" class="with-border" value="<?php echo $email; ?>" readonly="">
											</div>
										</div>

									</div>
								</div>
							</div>

						</div>
					</div>
				</div>

				<!-- Dashboard Box -->
				<div class="col-xl-12">
					<div class="dashboard-box">

						<!-- Headline -->
						<div class="headline">
							<h3><i class="icon-material-outline-face"></i> My Profile</h3>
						</div>

						<div class="content">
							<ul class="fields-ul">
							<li>
								<div class="row">
									<div class="col-xl-4">
										<div class="submit-field">
											<div class="bidding-widget">
												<!-- Headline -->
												<span class="bidding-detail">Set your <strong>minimal hourly rate</strong></span>

												<!-- Slider -->
												<div class="bidding-value margin-bottom-10">₦<span id="biddingVal"></span></div>
												<input class="bidding-slider" type="text" name="rate" value="<?php echo $minimal_rate; ?>" data-slider-handle="custom" data-slider-currency="₦" data-slider-min="500" data-slider-max="500000" data-slider-value="<?php echo $minimal_rate; ?>" data-slider-step="10" data-slider-tooltip="hide" />
											</div>
										</div>
									</div>

									<div class="col-xl-4">
										<div class="submit-field">
											<h5>Skills <i class="help-icon" data-tippy-placement="right" title="Add up to 10 skills"></i></h5>

											<!-- Skills List -->
											<div class="keywords-container">
												<div class="keyword-input-container">
													<input type="text" name="skills" id="skill" class="keyword-input with-border" placeholder="e.g. Rapping, Mixing, Auditing"/>
													<a onclick="addSkill()" class="keyword-input-button "><i class="icon-material-outline-add"></i></a>
												</div>
												<div class="keywords-list">
												<?php
												$skill = explode(",", $skills);
												for($i=0; $i < count($skill); $i++){
													echo "<span class='keyword'><span class='keyword-remove' onclick='removeAtIndex($i)'></span><span class='keyword-text'>$skill[$i]</span></span>";
												}
												?>
												</div>
												<div class="clearfix"></div>
											</div>
										</div>
									</div>

									<div class="col-xl-4">
										<div class="submit-field">
											<h5>Attachments</h5>
											
											<!-- Attachments -->
											<div class='attachments-container margin-top-0 margin-bottom-0'>
												<div class='attachment-box ripple-effect'>
													<a href='../images/freelancer/documents/<?php echo $attachment; ?>'><span><?php echo $attachment; ?></span></a>
													<i><?php echo pathinfo($attachment, PATHINFO_EXTENSION); ?></i>
													<p id='remove_attach' class='remove-attachment' data-tippy-placement='top' title='Remove'></p>
												</div>
											</div>
											<div class='clearfix'></div>
											
											<!-- Upload Button -->
											<div class="uploadButton margin-top-0">
												<input class="uploadButton-input" type="file" name="attachment" accept="image/*, application/pdf" id="upload" />
												<label class="uploadButton-button ripple-effect" for="upload">Upload Files</label>
												<span class="uploadButton-file-name">Maximum file size: 10 MB</span>
											</div>

										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="row">
									<div class="col-xl-6">
										<div class="submit-field">
											<h5>Tagline</h5>
											<input type="text" class="with-border" name="tagline" value="<?php echo $tagline; ?>">
										</div>
									</div>

									<div class="col-xl-6">
										<div class="submit-field">
											<h5>Nationality</h5>
											<select class=" with-border" data-size="7" name="location" title="Select Location">
												<option value="Nigeria" selected>Nigeria</option>
											</select>
										</div>
									</div>

									<div class="col-xl-12">
										<div class="submit-field">
											<h5>Introduce Yourself</h5>
											<textarea cols="30" rows="5" name="intro" class="with-border"><?php echo $introduction; ?></textarea>
										</div>
									</div>

								</div>
							</li>
						</ul>
						</div>
					</div>
				</div>

				<!-- Dashboard Box -->
				<div class="col-xl-12">
					<div id="test1" class="dashboard-box">

						<!-- Headline -->
						<div class="headline">
							<h3><i class="icon-material-outline-lock"></i> Password & Security</h3>
						</div>

						<div class="content with-padding">
							<div class="row">
								<div class="col-xl-4">
									<div class="submit-field">
										<h5>Current Password</h5>
										<input type="password" name="pwd" class="with-border">
									</div>
								</div>

								<div class="col-xl-4">
									<div class="submit-field">
										<h5>New Password</h5>
										<input type="password" name="new_pwd" placeholder="Only if password change is desired" class="with-border">
									</div>
								</div>

								<div class="col-xl-4">
									<div class="submit-field">
										<h5>Repeat New Password</h5>
										<input type="password" name="confirm_pwd" placeholder="Only if password change is desired" class="with-border">
									</div>
								</div>

								<div class="col-xl-12">
									<div class="checkbox">
										<input type="checkbox" name="twosteps" id="two-step" <?php if ($twostep == 'no') {
											echo "";
										} else {
											echo "checked";
										}?>>
										<label for="two-step"><span class="checkbox-icon"></span> Enable Two-Step Verification via Email</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<!-- Button -->
				<div class="col-xl-12">
					<button name="account_setting" class="button ripple-effect big margin-top-30">Save Changes</button>
				</div>

</form>

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

$('#remove_attach').click(function (){
	$.ajax({
		url : 'remove_attachment.php',
		type : 'post',
		data : {
			'freelancer_id' : <?php echo $id; ?>
		},
		success : function(response) {
			if (response == 'DELETED') {
				Snackbar.show({
					text: 'Attachment removed',
					textColor: '#fff',
					backgroundColor: '#383838'
				});
			}
		}
	});
});
</script>

<script>
	function removeAtIndex(index) {
		$.ajax({
    			url:"remove_skill_at.php",
        		type:"post",
				data: {
					'freelancer_id' : <?php echo $id; ?>,
					'index' : index
				},
    			success: function(response) {
      			if (response) {
					Snackbar.show({
						text: 'Skill removed',
						textColor: '#fff',
						backgroundColor: '#383838'
					});
				} else {
					Snackbar.show({
						text: 'Error',
						textColor: '#fff',
						backgroundColor: '#383838'
					});
				}
    		}
  		});
	}
</script>

<script>
	function addSkill() {
		$.ajax({
    			url:"add_skill.php",
        		type:"post",
				data: {
					'freelancer_id' : <?php echo $id; ?>,
					'skill' : document.getElementById('skill').value
				},
    			success: function(response) {
      			if (response) {
					Snackbar.show({
						text: 'Skill added',
						textColor: '#fff',
						backgroundColor: '#383838'
					});
				} else {
					Snackbar.show({
						text: 'Error',
						textColor: '#fff',
						backgroundColor: '#383838'
					});
				}
    		}
  		});
	}
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

<!-- Google Autocomplete -->
<script>
	function initAutocomplete() {
		 var options = {
		  types: ['(cities)'],
		  // componentRestrictions: {country: "us"}
		 };

		 var input = document.getElementById('autocomplete-input');
		 var autocomplete = new google.maps.places.Autocomplete(input, options);

		if ($('.submit-field')[0]) {
		    setTimeout(function(){ 
		        $(".pac-container").prependTo("#autocomplete-container");
		    }, 300);
		}
	}
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

<!-- Google API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAaoOT9ioUE4SA8h-anaFyU4K63a7H-7bc&amp;libraries=places&amp;callback=initAutocomplete"></script>


</body>

</html>