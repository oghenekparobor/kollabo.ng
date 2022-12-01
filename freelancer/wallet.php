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

	$sql1 = "SELECT * FROM wallet WHERE freelancer_id = '$id' LIMIT 1";
	$result1 = mysqli_query($con, $sql1);
	$bal = mysqli_fetch_assoc($result1);
	$balance = $bal['balance'];

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

<!-- Titlebar
================================================== -->
<div id="titlebar" class="gradient">
	<div class="container">
		<div class="row">
			<div class="col-xl-12">

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs" class="dark">
					<ul>
						<li><a href="dashboard.php">Home</a></li>
						<li>Wallet</li>
					</ul>
				</nav>

			</div>
		</div>
	</div>
</div>

<!-- Sliders
================================================== -->
<!-- Container -->
<div class="container">
	<div class="row">
		<div class="col-xl-12">
			<div class="section-headline border-top margin-top-45 padding-top-45 margin-bottom-12">
				<h3>Request Withdrawal</h3>
			</div>
		</div>
		<div class="col-xl-6 col-md-6">
			<div class="section-headline margin-top-25 margin-bottom-35">
				<h5>Amount to be withdrawn </h5>
			</div>
			<form action="withdraw.php" id="withdraw" method="post">
			<input type="hidden" value="<?php echo $id; ?>" name="user_id" />
			<input class="range-slider-single" type="number" name="amount" data-slider-min="1" data-slider-max="<?php echo $balance; ?>" data-slider-step="1" data-slider-value="1"/><br><br>
			<select class="selectpicker" name="bank" data-live-search="true">
				<option></option>
				<option value="044">Access Bank Plc</option>
				<option value="023">Citibank Nigeria Limited</option>
				<option value="063">Diamond Bank</option>
				<option value="050">Ecobank Nigeria Plc</option>
				<option value="084">Enterprise Bank</option>
				<option value="070">Fidelity Bank Plc</option>
				<option value="011">First Bank of Nigeria Limited</option>
				<option value="214">First City Monument Bank Limited</option>
				<option value="058">Guaranty Trust Bank Plc</option>
				<option value="030">Heritage Banking Company Limited</option>
				<option value="082">Keystone Bank Limited</option>
				<option value="014">Mainstreet Bank</option>
				<option value="076">Polaris Bank Limited</option>
				<option value="068">Standard Chartened</option>
				<option value="221">Stanbic IBTC Bank Plc</option>
				<option value="232">Sterling Bank Plc</option>
				<option value="032">Union Bank of Nigeria Plc</option>
				<option value="033">Unity Bank for Africa</option>
				<option value="215">Unity Bank Plc</option>
				<option value="035">Wema Bank Plc</option>
				<option value="057">Zenith Bank Plc</option>
			</select><br>
			<input type="number" min="0" step="1" name="acct_no" placeholder="Account Number">		
			</form><br>
			<button href="#" form="withdraw" class="button ripple-effect">Pay Out</button>
		</div>
	</div>
	<br><br><hr>
</div><br><br>
<!-- Container / End -->

<!-- Table & Notifications
================================================== -->
<!-- Container -->
<div class="container">
		<div class="row">
		
			<div class="section-headline margin-bottom-30">
				<h4 style="padding: 20px;">Withdrawal History</h4>
			</div>
			<table class="basic-table">
				<tr>
					<th>#</th>
					<th>Amount</th>
					<th>Created</th>
					<th></th>
				</tr>
				<?php 
							$sql = "SELECT * FROM `transactions` WHERE payee_id = '$id' ORDER BY DATE(created) DESC";
							$rs_result = mysqli_query ($con, $sql); //run the query 
							$no = 0;
							while ($row = mysqli_fetch_assoc($rs_result)) {
								$no += 1;
								$tid = $row['id'];
								$amount= $row['amount'];
								$created = $row['created'];

								$created = date('D d M Y', strtotime($created));
										
								echo "
				<tr>
					<td data-label='#'>$no</td>
					<td data-label='Amount'>$amount</td>
					<td data-label='Date'>$created</td>
					<td data-label='Action'><a href='del_transaction.php?transaction_id=$tid' class='button gray ripple-effect-dark'>Delete</a></td>
				</tr>
				";
							}
							?>

			</table>

	</div>

</div><br><br><br><br>
<!-- Container / End -->

<div class="margin-top-70"></div>

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

</body>

</html>