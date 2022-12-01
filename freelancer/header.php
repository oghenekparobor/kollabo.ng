<header id="header-container" class="fullwidth dashboard-header not-sticky">

<style>
	@media only screen and (max-device-width: 480px) { 
		#logo_img {
            padding: 20px;
        }
	}
</style>

	<!-- Header -->
	<div id="header">
		<div class="container">
			
			<!-- Left Side Content -->
			<div class="left-side">

				<!-- Logo -->
				<div id="logo">
					<a href="#"><img src="../images/logo.png" id="logo_img" alt=""></a>
				</div>
				
			</div>
			<!-- Left Side Content / End -->


			<!-- Right Side Content / End -->
			<div class="right-side">

				<!--  User Notifications -->
				<div class="header-widget hide-on-mobile">
					
					<!-- Notifications -->
					<div class="header-notifications">

						<!-- Trigger -->
						<div class="header-notifications-trigger">
							<a href="#"><i class="icon-feather-bell"></i><span><?php
								$tasks = "SELECT * FROM notification WHERE user_id = '$id' AND read_status = 'new' "; 
								$taskres=mysqli_query($con,$tasks);
								$taskcount = mysqli_num_rows($taskres); 
								echo $taskcount;
								?></span></a>
						</div>

						<!-- Dropdown -->
						<div class="header-notifications-dropdown">

							<div class="header-notifications-headline">
								<h4>Notifications</h4>
								<button class="mark-as-read ripple-effect-dark" title="Mark all as read" data-tippy-placement="left">
									<i class="icon-feather-check-square"></i>
								</button>
							</div>

							<div class="header-notifications-content">
								<div class="header-notifications-scroll" data-simplebar>
									<ul>
										<!-- Notification -->
										<?php 
							$sql = "SELECT * FROM notification WHERE user_id = '$id' AND read_status = 'new' ORDER BY DATE(created) DESC";
							$rs_result = mysqli_query ($con, $sql); //run the query 
							while ($row = mysqli_fetch_assoc($rs_result)) {
								$nid = $row['id'];
								$notification= $row['notification'];
								$read_status = $row['read_status'];
								$type = $row['type'];

								echo "
									<li class='notifications-not-read'>
										<a href=''>
											<span class='notification-icon'><i class='icon-material-outline-group'></i></span>
											<span class='notification-text'>
												$notification
											</span>
										</a>
									</li>
								";
							}
							?>
										
									</ul>
								</div>
							</div>

						</div>

					</div>
					
					<!-- Messages -->
					<div class="header-notifications">
						<div class="header-notifications-trigger">
							<a href="#"><i class="icon-feather-mail"></i><span><?php
								$messages = "SELECT * FROM messages WHERE recipient = '$id' AND status_flc = 'new' "; 
								$messageres=mysqli_query($con,$messages);
								$messagecount = mysqli_num_rows($messageres); 
								echo $messagecount;
								?></span></a>
						</div>

						<!-- Dropdown -->
						<div class="header-notifications-dropdown">

							<div class="header-notifications-headline">
								<h4>Messages</h4>
								<!-- <button class="mark-as-read ripple-effect-dark" title="Mark all as read" data-tippy-placement="left">
									<i class="icon-feather-check-square"></i>
								</button> -->
							</div>

							<div class="header-notifications-content">
								<div class="header-notifications-scroll" data-simplebar>
									<!-- <ul>
										<li class="notifications-not-read">
											<a href="dashboard-messages.html">
												<span class="notification-avatar status-online"><img src="../images/freelancer/profile/<?php echo $picture; ?>" alt=""></span>
												<div class="notification-text">
													<strong><?php echo $firstname." ".$lastname; ?></strong>
													<p class="notification-msg-text">Thanks for reaching out. I'm quite busy right now on many...</p>
													<span class="color">4 hours ago</span>
												</div>
											</a>
										</li>
									</ul> -->
								</div>
							</div>

							<a href="dashboard-messages.php" class="header-notifications-button ripple-effect button-sliding-icon">View All Messages<i class="icon-material-outline-arrow-right-alt"></i></a>
						</div>
					</div>

				</div>
				<!--  User Notifications / End -->

				<!-- User Menu -->
				<div class="header-widget">

					<!-- Messages -->
					<div class="header-notifications user-menu">
						<div class="header-notifications-trigger" id="online_or_not">
						<?php
								$bookmark = "SELECT * FROM online_status WHERE user_id = '$id' "; 
								$bookmarkres = mysqli_query($con,$bookmark);
								$bookmarkcount = mysqli_fetch_assoc($bookmarkres);
					
								$text;
								if ($bookmarkcount['status'] == 'online') {
									$text = "status-online";
								} else {
									$text = "";
								}
								echo "
								<a href='#'><div class='user-avatar $text'><img src='../images/freelancer/profile/$picture' style='width:70px; height:40px' alt=''></div></a>
								";
								?>
						</div>

						<!-- Dropdown -->
						<div class="header-notifications-dropdown">

							<!-- User Status -->
							<div class="user-status">

								<!-- User Name / Avatar -->
								<div class="user-details" id="online_or_not1">
								<?php
								$bookmark = "SELECT * FROM online_status WHERE user_id = '$id' "; 
								$bookmarkres = mysqli_query($con,$bookmark);
								$bookmarkcount = mysqli_fetch_assoc($bookmarkres);
					
								$text;
								if ($bookmarkcount['status'] == 'online') {
									$text = "status-online";
								} else {
									$text = "";
								}
								echo "
								<a href='#'><div class='user-avatar $text'><img src='../images/freelancer/profile/$picture' style='width:70px; height:40px' alt=''></div></a>
								";
								?>
									<div class="user-name">
									<?php echo $firstname." ".$lastname; ?> <span>Freelancer</span>
									</div>
								</div>
								<br>
								
								<!-- User Status Switcher -->
								<?php
								$bookmark = "SELECT * FROM online_status WHERE user_id = '$id' ";
								$bookmarkres = mysqli_query($con,$bookmark);
								$bookmarkcount = mysqli_fetch_assoc($bookmarkres);

								$check;
								$text;
								if ($bookmarkcount['status'] == 'online') {
									$check = "checked";
									$text = "Online";
								} else {
									$check = "";
									$text = "Invisible";
								}

								echo "
								<div class='switches-list'>
									<div class='switch-container'>
										<label class='switch'><input type='checkbox' id='snackbar-user-status' $check><span class='switch-button'></span> $text</label>
									</div>
								</div>";
								?>
						</div>
						
						<ul class="user-menu-small-nav">
							<li><a href="dashboard.php"><i class="icon-material-outline-dashboard"></i> Dashboard</a></li>
							<li><a href="dashboard-settings.php"><i class="icon-material-outline-settings"></i> Settings</a></li>
							<li><a href="../logout.php"><i class="icon-material-outline-power-settings-new"></i> Logout</a></li>
						</ul>

						</div>
					</div>

				</div>
				<!-- User Menu / End -->

				<!-- Mobile Navigation Button -->
				<!-- <span class="mmenu-trigger">
					<button class="hamburger hamburger--collapse" type="button">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</button>
				</span> -->

			</div>
			<!-- Right Side Content / End -->

		</div>
	</div>
	<!-- Header / End -->

</header>