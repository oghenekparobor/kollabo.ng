				<div class="dashboard-nav">
					<div class="dashboard-nav-inner">

						<ul data-submenu-title="Start">
							<li class="active"><a href="dashboard.php"><i class="icon-material-outline-dashboard"></i> Dashboard</a></li>
							<li><a href="dashboard-messages.php"><i class="icon-material-outline-question-answer"></i> Messages <span class="nav-tag"><?php
								$messages = "SELECT * FROM messages WHERE recipient = '$id' AND status_flc = 'new' "; 
								$messageres=mysqli_query($con,$messages);
								$messagecount = mysqli_num_rows($messageres); 
								echo $messagecount;
								?></span></a></li>
							<li><a href="dashboard-bookmarks.php"><i class="icon-material-outline-star-border"></i> Bookmarks</a></li>
							<li><a href="my-offers.php"><i class="icon-material-outline-rate-review"></i> My Offers</a></li>
						</ul>
						
						<ul data-submenu-title="Organize and Manage">
							<li><a href="#"><i class="icon-material-outline-assignment"></i> Tasks</a>
								<ul>
									<li><a href="tasks-list.php">Browse Tasks</a></li>
									<li><a href="dashboard-my-active-bids.php">My Active Bids <span class="nav-tag"><?php
								$tasks = "SELECT * FROM bidder WHERE freelancer_id = '$id' "; 
								$taskres=mysqli_query($con,$tasks);
								$taskcount = mysqli_num_rows($taskres); 
								echo $taskcount;
								?></span></a></li>
								<li><a href="my-tasks.php">My Tasks</a></li>
								</ul>	
							</li>
						</ul>

                        <ul data-submenu-title="Plan and Pricing">
							<li><a href="#"><i class="icon-material-outline-assignment"></i> Subscription</a>
								<ul>
									<li><a href="pricing-plans.php">Browse Plans</a></li>
									<li><a id="check_active_plan">Active Plan</a></li>
								</ul>	
							</li>
						</ul>

                        <!-- <ul data-submenu-title="Pay Wall">
							<li><a href="#"><i class="icon-material-outline-assignment"></i> Pay Wall</a>
								<ul>
									<li><a href="">Sell on Paywall</a></li>
									<li><a href="">Visit Paywall</a></li>
								</ul>	
							</li>
						</ul> -->

						<ul data-submenu-title="Account">
							<li><a href="wallet.php"><i class="icon-material-outline-account-balance-wallet"></i> Wallet</a></li>
							<li><a href="dashboard-settings.php"><i class="icon-material-outline-settings"></i> Settings</a></li>
							<li><a href="../logout.php"><i class="icon-material-outline-power-settings-new"></i> Logout</a></li>
						</ul>
						
					</div>
				</div>
				