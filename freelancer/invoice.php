<?php
include('install.php');

if(!isset($_SESSION['user_id'])) {
	header("Location: ../index.php");
} else {

	if (!isset($_GET['invoice_id'])) {
		header ("Location: dashboard.php");
	} else {
		$id = $_SESSION['user_id'];
		$order_id = $_GET['invoice_id'];

		$sql = "SELECT * FROM freelancer WHERE user_id = '$id' LIMIT 1";
		$result = mysqli_query($con, $sql);
		$user = mysqli_fetch_assoc($result);
		$firstname = $user['firstname'];
		$lastname = $user['lastname'];
		$nationality = $user['nationality'];

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

		$task = "SELECT * FROM tasks WHERE id = '$taskid' LIMIT 1";
		$taskres = mysqli_query($con, $task);
		$tasks = mysqli_fetch_assoc($taskres);
		$title = $tasks['title'];

	}

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Kollabo Invoice</title>
	<link rel="stylesheet" href="../css/invoice.css">
</head> 

<body>

<!-- Print Button -->
<div class="print-button-container">
	<a href="javascript:window.print()" class="print-button">Print this invoice</a>
</div>

<!-- Invoice -->
<div id="invoice">

	<!-- Header -->
	<div class="row">
		<div class="col-xl-6">
			<div id="logo"><img src="../images/logo.png" alt=""></div>
		</div>

		<div class="col-xl-6">	

			<p id="details">
				<strong>Order:</strong> #<?php echo $ref; ?> <br>
				<strong>Issued:</strong> <?php echo $created; ?> <br>
				<!-- Due 7 days from date of issue -->
			</p>
		</div>
	</div>


	<!-- Client & Supplier -->
	<div class="row">
		<div class="col-xl-12">
			<h2>Invoice</h2>
		</div>

		<div class="col-xl-6">	
			<strong class="margin-bottom-5">Supplier</strong>
			<p>
				Kollabo Ltd <br>
				#, lorem ipsum <br>
				State, CF44 6ZL, NG <br>
			</p>
		</div>

		<div class="col-xl-6">	
			<strong class="margin-bottom-5">Freelancer</strong>
			<p>
				<?php echo $firstname." ".$lastname; ?> <br>
				36 Edgewater Street <br>
				<?php echo $nationality; ?> <br>
			</p>
		</div>
	</div>


	<!-- Invoice -->
	<div class="row">
		<div class="col-xl-12">
			<table class="margin-top-20">
				<tr>
					<th>Description</th>
					<th>Price</th>
					<th>Total</th>
				</tr>

				<tr>
					<td><?php echo $title; ?></td> 
					<td>₦<?php echo $budget; ?></td>
					<td>₦<?php echo $budget; ?></td>
				</tr>
			</table>
		</div>
		
		<div class="col-xl-4 col-xl-offset-8">	
			<table id="totals">
				<tr>
					<th>Total Due</th> 
					<th><span>₦<?php echo $budget; ?></span></th>
				</tr>
			</table>
		</div>
	</div>


	<!-- Footer -->
	<div class="row">
		<div class="col-xl-12">
			<ul id="footer">
				<li><span>https://kollabo.ng</span></li>
				<li><a href="mailto:support@kollabo.ng" class="__cf_email__" data-cfemail="support@kollabo.ng">support@kollabo.ng</a></li>
				<li>(123) 123-456</li>
			</ul>
		</div>
	</div>
		
</div>

</html>
