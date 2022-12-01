<header id="header-container" class="fullwidth">

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
					<a href="index.php"><img src="images/logo2.png" id="logo_img" alt=""></a>
				</div>

				<!-- Main Navigation -->
				<nav id="navigation">
					<ul id="responsive">

						<li><a href="index.php" class="<?php echo $index; ?>">Home</a></li>

						<li><a href="about.php" class="<?php echo $about; ?>">About Us</a></li>

						<li><a href="contact.php" class="<?php echo $contact; ?>">Contact Us</a></li>

					</ul>
				</nav>
				<div class="clearfix"></div>
				<!-- Main Navigation / End -->
				
			</div>
			<!-- Left Side Content / End -->

			<div class="right-side">
			<nav id="navigation">
					<ul id="responsive">

						<li><a href="login.php" class="<?php echo $login; ?>">Login</a></li>
						
						<li><a href="register.php" class="<?php echo $register; ?>">Register</a></li>

					</ul>
				</nav>
			</div>


			<!-- Right Side Content / End -->
			<div class="right-side">

				<!-- Mobile Navigation Button -->
				<span class="mmenu-trigger">
					<button class="hamburger hamburger--collapse" type="button">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</button>
				</span>

			</div>
			<!-- Right Side Content / End -->

		</div>
	</div>
	<!-- Header / End -->

</header>