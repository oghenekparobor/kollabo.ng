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

	$sql1 = "SELECT * FROM subscription ";
	$rs_result = mysqli_query ($con, $sql1); //run the query 
	$row = mysqli_fetch_assoc($rs_result);
	$pid = $row['id'];
	$plans = $row['pricing_plan'];
	$description = $row['plan_description'];
	$features = $row['plan_features'];
	$duration = $row['plan_duration'];
	$discount = $row['discount'];

	$plan = explode(",", $plans);

	$discount1 = 0;
	$discount2 = 0;

	if ($discount == 0) {
		$discount1 = $plan[0];
		$discount2 = $plan[1];
	} else {
		$discount1 = $plan[0] - (($discount / 100) * $plan[0]);
		$discount2 = $plan[1] - (($discount / 100) * $plan[1]);
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
<script src="https://js.paystack.co/v2/inline.js"></script>
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

				<h2>Checkout</h2>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs" class="dark">
					<ul>
						<li><a href="dashboard.php">Home</a></li>
						<li><a href="pricing-plans.php">Pricing Plans</a></li>
						<li>Checkout</li>
					</ul>
				</nav>

			</div>
		</div>
	</div>
</div>


<!-- Content
================================================== -->
<!-- Container -->
<div class="container">
	<div class="row">
		<div class="col-xl-8 col-lg-8 content-right-offset">
			

			<!-- Hedaline -->
			<h3>Billing Cycle</h3>

			<!-- Billing Cycle Radios  -->
			<div class="billing-cycle margin-top-25">

				<!-- Radio -->
				<div class="radio">
					<input id="radio_5" name="radio-payment-type" type="radio">
					<label for="radio_5">
						<span class="radio-label"></span>
						Billed Monthly
						<span class="billing-cycle-details">
							<span class="regular-price-tag">₦<?php echo $discount1; ?> / month</span>
							<span class="regular-price-tag line-through"><?php echo $plan[0]; ?> / month</span>
						</span>
					</label>
				</div>
			
				<!-- Radio -->
				<div class="radio">
					<input id="radio_6" name="radio-payment-type" type="radio">
					<label for="radio_6"><span class="radio-label"></span>
						Billed Yearly
						<span class="billing-cycle-details">
							<span class="discounted-price-tag">₦<?php echo $discount2; ?> / year</span>
							<span class="regular-price-tag line-through"><?php echo $plan[1]; ?> / yearly</span>
						</span>
					</label>
				</div>
			</div>
			

			<!-- Hedline -->
			<h3 class="margin-top-50">Payment Method</h3>

			<!-- Payment Methods Accordion -->
			<div class="payment margin-top-30">

				<div class="payment-tab payment-tab-active">
					<div class="payment-tab-trigger">
						<input checked id="paypal" name="cardType" type="radio" value="paypal">
						<label for="paypal">Paystack</label>
						<img class="payment-logo paypal" src="../../../i.imgur.com/ApBxkXU.png" alt="">
					</div>

					<div class="payment-tab-content">
						<p>You will be redirected to Paystack to complete payment.</p>
					</div>
				</div>

			</div>
			<!-- Payment Methods Accordion / End -->
		
			<button id="make_payment" class="button big ripple-effect margin-top-40 margin-bottom-65">Proceed Payment</button>
		</div>


		<!-- Summary -->
		<div class="col-xl-4 col-lg-4 margin-top-0 margin-bottom-60">
			
			<!-- Summary -->
			<div class="boxed-widget summary margin-top-0">
				<div class="boxed-widget-headline">
					<h3>Summary</h3>
				</div>
				<div class="boxed-widget-inner">
					<ul>
						<li>Standard Plan <span id="plan_price"></span></li>
						<li>VAT (7.5%) <span id="vat"></span></li>
						<li class="total-costs">Final Price <span id="final_price"></span></li>
					</ul>
				</div>
			</div>
			<!-- Summary / End -->

			<!-- Checkbox -->
			<div class="checkbox margin-top-30">
				<input type="checkbox" id="two-step">
				<label for="two-step"><span class="checkbox-icon"></span>  I agree to the <a href="#">Terms and Conditions</a> and the <a href="#">Automatic Renewal Terms</a></label>
			</div>
		</div>

	</div>
</div>
<!-- Container / End -->

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
	var duration;
	var amount;
	var symbol = "₦";
	var vat;

	$('#radio_5').on('click', function(){
		amount = <?php echo $discount1 ?>;
		vat = (7.5 / 100) * amount;

		document.getElementById('plan_price').innerHTML = symbol + <?php echo $discount1 ?>;
		document.getElementById('vat').innerHTML = symbol + vat;
		document.getElementById('final_price').innerHTML = symbol + (vat + amount);
		duration = 1;
	});

	$('#radio_6').on('click', function(){
		amount = <?php echo $discount2 ?>;
		vat = (7.5 / 100) * amount;

		document.getElementById('plan_price').innerHTML = symbol + <?php echo $discount2 ?>;
		document.getElementById('vat').innerHTML = symbol + vat;
		document.getElementById('final_price').innerHTML = symbol + (vat + amount);
		duration = 12;
	});

	$('#make_payment').on('click', function(){
		if (document.getElementById('two-step').checked) {
			if (amount == null) {
				alert('You have not selected a plan');
			} else {
				var popup = PaystackPop.setup({
            		key: 'pk_live_80647d9a057a757d20c5998645c2c4ba5ecb4714',
            		email: '<?php echo $email; ?>',
    				amount: (amount + vat) * 100,
            		currency: 'NGN',
            		onClose: function() {},
            		callback: function (response_ref) {
                		$.ajax({
    						url: 'sub_plan.php',
							type: "POST",
							data: {
								'freelancer_id': <?php echo $id; ?>,
								'duration': duration,
								'amount': amount
							},
    					success: function (response) {
      						if (response == 'PLAN_UPDATED') {
								Snackbar.show({
									text: 'Your active plan has been successfully updated!',
								});
								window.location = 'order-confirmation.php?ref_id='+response_ref.reference;
							} else if (response == 'ERROR_UPDATING_PLAN') {
								Snackbar.show({
									text: 'Error updating active plan',
								});
							} else if (response == 'PLAN_CREATED') {
								Snackbar.show({
									text: 'Plan subscription successful!',
								});
								window.location = 'order-confirmation.php?ref_id='+response_ref.reference;
							} else if (response == 'PLAN_CREATION_FAILED') {
								Snackbar.show({
									text: 'Subscription error!',
								});
							}
    					}
  						});
            		}
        		});
        	popup.openIframe();
			}
		} else {
			alert('Please agree to Terms & Conditions of payment');
		}
	});
</script>

</body>

</html>