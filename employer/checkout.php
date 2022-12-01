<?php
include('install.php');

if(!isset($_SESSION['user_id'])) {
	header("Location: ../index.php");
} else {

	if (!isset($_GET['order_id'])) {
		header ("Location: dashboard.php");
	} else {
		$id = $_SESSION['user_id'];
		$order_id = $_GET['order_id'];

		$sql = "SELECT * FROM employer WHERE user_id = '$id' LIMIT 1";
		$result = mysqli_query($con, $sql);
		$user = mysqli_fetch_assoc($result);
		$firstname = $user['firstname'];
		$lastname = $user['lastname'];
		$email = $user['email'];
		$nationality = $user['nationality'];
		$picture = $user['picture'];

		$order = "SELECT * FROM orders WHERE id = '$order_id' LIMIT 1";
		$orderres = mysqli_query($con, $order);
		$orders = mysqli_fetch_assoc($orderres);
		$created = $orders['created'];
		$ref = $orders['order_ref'];
		$mytaskid = $orders['my_task_id'];

		$mytask = "SELECT * FROM mytask WHERE id = '$mytaskid' LIMIT 1";
		$mytaskres = mysqli_query($con, $mytask);
		$mytasks = mysqli_fetch_assoc($mytaskres);
		$budget = $mytasks['budget'];
		$taskid = $mytasks['task_id'];
		$freelancer_id = $mytasks['freelancer_id'];

		$task = "SELECT * FROM tasks WHERE id = '$taskid' LIMIT 1";
		$taskres = mysqli_query($con, $task);
		$tasks = mysqli_fetch_assoc($taskres);
		$title = $tasks['title'];

	}

}
?>

<!doctype html>
<html lang="en">

<head>

<!-- Basic Page Needs
================================================== -->
<title>Kollabo | Checkout</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
================================================== -->
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/colors/blue.css">
<script src="https://js.paystack.co/v2/inline.js"></script>

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
<div id="titlebar" class="gradient">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2>Checkout</h2>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs" class="dark">
					<ul>
						<li><a href="#">Home</a></li>
						<li><a href="dashboard.php">Dashboard</a></li>
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

			<!-- Hedline -->
			<h3 class="margin-top-50">Payment Method</h3>

			<!-- Payment Methods Accordion -->
			<div class="payment margin-top-30">

				<div class="payment-tab payment-tab-active">
					<div class="payment-tab-trigger">
						<input checked id="paypal" name="cardType" type="radio" value="paystack">
						<label for="paypal">Paystack</label>
						<img class="payment-logo paypal" src="" alt="">
					</div>

					<div class="payment-tab-content">
						<p>You will be redirected to paystack to complete payment.</p>
					</div>
				</div>

			</div>
		
			<button onclick="loadInline()" class="button big ripple-effect margin-top-40 margin-bottom-65">Make Payment</button>

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
						<li><?php echo $title; ?> <span>₦<?php echo $budget; ?></span></li>
						<li class="total-costs">Final Price <span>₦<?php echo $budget; ?></span></li>
					</ul>
				</div>
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

<script>
	function loadInline() {
        var popup = PaystackPop.setup({
            key: 'pk_live_80647d9a057a757d20c5998645c2c4ba5ecb4714',
            email: '<?php echo $email; ?>',
    		amount: <?php echo $budget * 100; ?>,
            currency: 'NGN',
            onClose: function() {},
            callback: function (response) {
                $.ajax({
    				url: 'paid.php',
					type: "POST",
					data: {
						'order_id': <?php echo $order_id; ?>,
						'task_id': <?php echo $mytaskid; ?>,
						'reference_id': response.reference,
						'freelancer_id': <?php echo $freelancer_id; ?>,
						'price': <?php echo $budget; ?>,
						'userid': <?php echo $id; ?>
					},
    				success: function (response) {
      					if (response == 'PAYMENT_SUCCESSFUL') {
							window.location = 'dashboard.php';
						} else if (response == 'WALLET_UPDATE_FAILED') {
							alert('Failed to update freelancer please contact admin');
							window.location = 'dashboard.php';
						} else {
							alert('payment not updated, please contact admin');
							window.location = 'dashboard.php';
						}
    				}
  				});
            }
        });
        popup.openIframe();
    }
</script>

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

</body>

</html>