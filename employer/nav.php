<div class="dashboard-nav">
					<div class="dashboard-nav-inner">

						<ul data-submenu-title="Start">
							<li class="active"><a href="dashboard.php"><i class="icon-material-outline-dashboard"></i> Dashboard</a></li>
							<li><a href="dashboard-messages.php"><i class="icon-material-outline-question-answer"></i> Messages <span class="nav-tag"><?php
								$messages = "SELECT * FROM messages WHERE recipient = '$id' AND status_emp = 'new' "; 
								$messageres=mysqli_query($con,$messages);
								$messagecount = mysqli_num_rows($messageres); 
								echo $messagecount;
								?></span></a></li>
							<li><a href="dashboard-bookmarks.php"><i class="icon-material-outline-star-border"></i> Bookmarks</a></li>
							<li><a href="dashboard-reviews.php"><i class="icon-feather-message-square"></i> Reviews</a></li>
							<li><a href="my-offers.php"><i class="icon-material-outline-rate-review"></i> My Offers</a></li>
						</ul>
						
						<ul data-submenu-title="Organize and Manage">
							<li><a href="#"><i class="icon-material-outline-business-center"></i> Tasks</a>
								<ul>
									<li><a href="freelancers-list.php">Find a freelancer </a></li>
									<li><a href="active-bids.php">My Active Bids</a></li>
									<li><a href="my-tasks.php">My Tasks</a></li>
									<li><a href="dashboard-post-a-task.php">Post a Task</a></li>
								</ul>	
							</li>
							<!-- <li><a href="#"><i class="icon-material-outline-assignment"></i> Bid</a>
								<ul>
									<li><a href="dashboard-manage-tasks.html">My Active Bids <span class="nav-tag">2</span></a></li>
									<li><a href="dashboard-manage-bidders.html">Manage Bidders</a></li>
								</ul>	
							</li> -->
						</ul>

						<!-- <ul data-submenu-title="Pay Wall">
							<li><a href="#"><i class="icon-material-outline-business-center"></i> Visit Pay Wall</a></li>
						</ul> -->

						<ul data-submenu-title="Account">
							<li><a href="dashboard-settings.php"><i class="icon-material-outline-settings"></i> Settings</a></li>
							<li><a href="../logout.php"><i class="icon-material-outline-power-settings-new"></i> Logout</a></li>
						</ul>
						
					</div>
				</div>