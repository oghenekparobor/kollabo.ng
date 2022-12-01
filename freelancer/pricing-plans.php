<?php
session_start(); 
require("../admin/database/connect.php");
$db = new DbConnect();
$con = $db->connect();
$date = date('D d M Y h:i:s a');

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
<body>

<!-- Wrapper -->
<div id="wrapper">

<!-- Header Container
================================================== -->
<?php include('header.php'); ?>
<!-- Header Container / End -->

<!-- Titlebar
================================================== -->
<div id="titlebar" class="gradient">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2>Pricing Plans</h2>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs" class="dark">
					<ul>
						<li><a href="#">Home</a></li>
						<li><a href="dashboard.php">Dashboard</a></li>
						<li>Pricing Plans</li>
					</ul>
				</nav>

			</div>
		</div>
	</div>
</div>


<!-- Page Content
================================================== -->
<div class="container">
	<div class="row">

		<div class="col-xl-12">

			<!-- Billing Cycle  -->
			<div class="billing-cycle-radios margin-bottom-70">
				<div class="radio billed-monthly-radio">
					<input id="radio-5" name="radio-payment-type" type="radio" checked>
					<label for="radio-5"><span class="radio-label"></span> Billed Monthly</label>
				</div>

				<div class="radio billed-yearly-radio">
					<input id="radio-6" name="radio-payment-type" type="radio">
					<label for="radio-6"><span class="radio-label"></span> Billed Yearly <span class="small-label">Save 10%</span></label>
				</div>
			</div>

			<!-- Pricing Plans Container -->
			<div class="pricing-plans-container">

				<!-- Plan -->
				<div class="pricing-plan">
					<!-- <h3>Basic Plan</h3>
					<p class="margin-top-10">One time fee for one listing or task highlighted in search results.</p>
					<div class="pricing-plan-label billed-monthly-label"><strong>$19</strong>/ monthly</div>
					<div class="pricing-plan-label billed-yearly-label"><strong>$205</strong>/ yearly</div>
					<div class="pricing-plan-features">
						<strong>Features of Basic Plan</strong>
						<ul>
							<li>1 Listing</li>
							<li>30 Days Visibility</li>
							<li>Highlighted in Search Results</li>
						</ul>
					</div>
					<a href="pages-checkout-page.html" class="button full-width margin-top-20">Buy Now</a> -->
				</div>

				<!-- Plan -->
				<?php 
							$sql = "SELECT * FROM subscription ";
							$rs_result = mysqli_query ($con, $sql); //run the query 
							while ($row = mysqli_fetch_assoc($rs_result)) {
								$pid = $row['id'];
								$plans = $row['pricing_plan'];
								$description = $row['plan_description'];
								$features = $row['plan_features'];
								$duration = $row['plan_duration'];
								$discount = $row['discount'];

								$plan = explode(",", $plans);

								echo "<div class='pricing-plan recommended'>
								<h3>Standard Plan</h3>
								<p class='margin-top-10'>$description</p>
								<input type='hidden' id='monthly' value='$plan[0]' />
								<div class='pricing-plan-label billed-monthly-label'><strong>₦$plan[0]</strong>/ monthly</div>
								<input type='hidden' id='yearly' value='$plan[1]' />
								<div class='pricing-plan-label billed-yearly-label'><strong>₦$plan[1]</strong>/ yearly</div>
								<div class='pricing-plan-features'>
									<strong>Features of Standard Plan</strong>
									<ul>";
								$feature = explode(",", $features);
								for($i=0; $i < count($feature); $i++){
									echo "<li>$feature[$i]</li>";
								}
								echo "</ul>
								</div>
								<button id='plan_subscribe' class='button full-width margin-top-20'>Buy Now</button>
							</div>";
										
			}
			?>

				<!-- Plan -->
				<div class="pricing-plan">
					<!-- <h3>Extended Plan</h3>
					<p class="margin-top-10">One time fee for one listing or task highlighted in search results.</p>
					<div class="pricing-plan-label billed-monthly-label"><strong>$99</strong>/ monthly</div>
					<div class="pricing-plan-label billed-yearly-label"><strong>$1069</strong>/ yearly</div>
					<div class="pricing-plan-features">
						<strong>Features of Extended Plan</strong>
						<ul>
							<li>Unlimited Listings Listing</li>
							<li>90 Days Visibility</li>
							<li>Highlighted in Search Results</li>
						</ul>
					</div>
					<a href="pages-checkout-page.html" class="button full-width margin-top-20">Buy Now</a> -->
				</div>
			</div>

		</div>

	</div>
</div>


<div class="margin-top-80"></div>

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
</script>

<script>
$('#plan_subscribe').on('click', function(){

	var duration;
	var amount;
	
	if (document.getElementById('radio-5').checked) {
		amount = document.getElementById('monthly').value;
		duration = 1;
	} else if (document.getElementById('radio-6').checked) {
		amount = document.getElementById('yearly').value;
		duration = 12;
	}

	window.location = 'checkout-page.php';

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