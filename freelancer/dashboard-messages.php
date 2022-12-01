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
<header id="header-container" class="fullwidth dashboard-header not-sticky">

	<!-- Header -->
	<?php include('header.php'); ?>
	<!-- Header / End -->

</header>
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
				<h3>Messages</h3>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs" class="dark">
					<ul>
						<li><a href="#">Home</a></li>
						<li><a href="dashboard.php">Dashboard</a></li>
						<li>Messages</li>
					</ul>
				</nav>
			</div>
	
				<div class="messages-container margin-top-0">

					<div class="messages-container-inner">

						<!-- Messages -->
						<div class="messages-inbox">
							<div class="messages-headline">
								<div class="input-with-icon">
										<input id="autocomplete-input" type="text" placeholder="Search">
									<i class="icon-material-outline-search"></i>
								</div>
							</div>

							<ul id='onlin'>

							<?php 
							$sql = "SELECT * FROM messages WHERE recipient = '$id' AND id IN (SELECT MAX(id) FROM messages GROUP BY recipient ORDER BY id DESC) GROUP BY recipient ORDER BY id DESC ";
							$rs_result = mysqli_query ($con, $sql); //run the query 
							while ($row = mysqli_fetch_assoc($rs_result)) {
								$mid = $row['id'];
								$recipient= $row['recipient'];
								$sender= $row['sender'];
								$message= $row['message'];
								$created= $row['created'];

								$created = date('D d M Y', strtotime($created));

								$ffirstname;
								$flastname;
								$picture;

								$sqlq = "SELECT * FROM users WHERE id = '$sender' LIMIT 1";
								$resultq = mysqli_query($con, $sqlq);
								$userq = mysqli_fetch_assoc($resultq);

								// if ($userq['acct_type'] == 'employer') {
									$sql = "SELECT * FROM employer WHERE user_id = '$sender' LIMIT 1";
									$result = mysqli_query($con, $sql);
									$user = mysqli_fetch_assoc($result);
									$ffirstname = $user['firstname'];
									$flastname = $user['lastname'];
									$picture = "../images/employer/profile/".$user['picture'];

									$on = "SELECT * FROM online_status WHERE user_id = '$sender' LIMIT 1";
									$resut = mysqli_query($con, $on);
									$uer = mysqli_fetch_assoc($resut);
									$status = $uer['status'];
									$stat;
									if ($status == 'online') {
										$stat = "status-online";
									} else {
										$stat = "status-offline";
									}
								// } else if ($userq['acct_type'] == 'freelancer') {
								// 	$sql = "SELECT * FROM employer WHERE user_id = '$recipient' LIMIT 1";
								// 	$result = mysqli_query($con, $sql);
								// 	$user = mysqli_fetch_assoc($result);
								// 	$ffirstname = $user['firstname'];
								// 	$flastname = $user['lastname'];
								// 	$picture = "../images/employer/profile/".$user['picture'];

								// 	$on = "SELECT * FROM online_status WHERE user_id = '$recipient' LIMIT 1";
								// 	$resut = mysqli_query($con, $on);
								// 	$uer = mysqli_fetch_assoc($resut);
								// 	$status = $uer['status'];
								// 	$stat;
								// 	if ($status == 'online') {
								// 		$stat = "status-online";
								// 	} else {
								// 		$stat = "status-offline";
								// 	}
								// }								
																			
								echo "
								<!-- <li class='active-message'> -->
								<li>
									<a onclick='openMessage($id, $sender)'>
										<div class='message-avatar'><i class='status-icon $stat'></i><img src='$picture' alt='' /></div>

										<input type='hidden' value='$recipient' id='recipient' />
										<div class='message-by'>
											<div class='message-by-headline'>
												<h5>$ffirstname $flastname</h5>
												<span>$created</span>
											</div>
											<p>$message</p>
										</div>
									</a>
								</li>
								";
							}
							?>								

							</ul>
						</div>
						<!-- Messages / End -->

						<!-- Message Content -->
						<div class="message-content" id='messagearea' style="max-height: 450px;">
							<!-- Message Content Inner / End -->
							
							<!-- Reply Area -->
							<!-- <div class="message-reply">
								<textarea cols="1" rows="1" placeholder="Your Message" data-autoresize></textarea>
								<button class="button ripple-effect">Send</button>
							</div> -->

						</div>
						<!-- Message Content -->

					</div>
			</div>
			<!-- Messages Container / End -->
			
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

function sendMessage(fr, em) { 
	if (document.getElementById('message').value == "") {
		// alert('');
	} else {
		$.ajax({
    	url: 'send_message.php',
		type: "POST",
		data: {
			'employer' : em,
			'freelancer' : fr,
			'message' : document.getElementById('message').value,
		},
    	success: function (response) {
      		if (response == 'MESSAGE_SENT') {
				$.ajax({
    				url: 'open_message.php',
					type: "POST",
					data: {
						'employer' : em,
						'freelancer' : fr,
					},
    				success: function (response) {
						document.getElementById('messagearea').innerHTML = response;

						var objDiv = document.getElementById("innerMessage");
						objDiv.scrollTop = objDiv.scrollHeight;
    				}
  				});
			} else {
				Snackbar.show({
					text: 'Message not sent!',
				});
			}
    	}
  	});
	}	
}
</script>

<script>
	function openMessage(free, empl) {
		$.ajax({
    	url: 'open_message.php',
		type: "POST",
		data: {
			'employer' : empl,
			'freelancer' : free,
		},
    	success: function (response) {
			document.getElementById('messagearea').innerHTML = response;

			var objDiv = document.getElementById("innerMessage");
			objDiv.scrollTop = objDiv.scrollHeight;
			runInterval(free, empl);
    	}
  		});
	}
</script>

<script>
	setInterval(() => {
		$('#onlin').load(location.href + ' #onlin');
	}, 120000);
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

<script>
	function runInterval(free, empl) {
		setInterval(() => {
		$.ajax({
    	url: 'get_new_message.php',
		type: "POST",
		data: {
			'employer' : empl,
			'freelancer' : free
		},
    	success: function (response) {
			if (response == 'NEW_MESSAGE_FOUND') {
				openMessage(free, empl);
				// $('#innerMessage').load(location.href + ' #innerMessage');
				// console.log('new messages');
			} else if (response == 'NO_NEW_MESSAGE_FOUND') {
				// do nothing
				// console.log('no new messages');

			}
    	}
  		});
	}, 500);
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

</body>

</html>