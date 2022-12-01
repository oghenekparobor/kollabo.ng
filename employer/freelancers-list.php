<?php
include('install.php');

if(!isset($_SESSION['user_id'])) {
	header("Location: ../index.php");
} else {
	$id = $_SESSION['user_id'];
	$accttype = $_SESSION['account_type'];

	$sql = "SELECT * FROM employer WHERE user_id = '$id' LIMIT 1";
	$result = mysqli_query($con, $sql);
	$user = mysqli_fetch_assoc($result);
	$picture = $user['picture'];
	$firstname = $user['firstname'];
	$lastname = $user['lastname'];
	
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
<div class="clearfix"></div>
<!-- Header Container / End -->

<!-- Spacer -->
<div class="margin-top-90"></div>
<!-- Spacer / End-->

<!-- Page Content
================================================== -->
<div class="container">
	<div class="row">
		<div class="col-xl-3 col-lg-4">
			<div class="sidebar-container">
				
				<!-- Location -->
				<div class="sidebar-widget">
					<h3>Location</h3>
					<div class="input-with-icon">
						<div id="autocomplete-container">
							<input id="autocomplete-input" type="text" name="location" placeholder="Location">
						</div>
						<i class="icon-material-outline-location-on"></i>
					</div>
				</div>

				<!-- Hourly Rate -->
				<div class="sidebar-widget">
					<h3>Minimum Rate</h3>
					<div class="margin-top-55"></div>

					<!-- Range Slider -->
					<input class="range-slider" type="text" id="pricerange" name="pricerange" data-slider-currency="₦" data-slider-min="500" data-slider-max="1000000" data-slider-step="5" data-slider-value="[500,1000000]"/>
				</div>

				<div class="clearfix"></div>

			</div>
		</div>
		<div class="col-xl-9 col-lg-8 content-left-offset">

			<h3 class="page-title">Search Results</h3>

			<div class="notify-box margin-top-15">

				<div class="sort-by">
					<span>Sort by:</span>
					<select class="selectpicker hide-tick">
						<option id="random">Random</option>
						<option id="newest">Newest</option>
						<option id="oldest">Oldest</option>
					</select>
				</div>
			</div>
			
			<!-- Freelancers List Container -->
			<div class="freelancers-container freelancers-list-layout compact-list margin-top-35" id="searchresult">
				
				<!--Freelancer -->
				<?php 
				$page_no;
				if (isset($_GET['page_no']) && $_GET['page_no']!="") {
					$page_no = $_GET['page_no'];
				} else {
					$page_no = 1;
				}
				$total_records_per_page = 8;
				$offset = ($page_no-1) * $total_records_per_page;
				$previous_page = $page_no - 1;
				$next_page = $page_no + 1;
				$adjacents = "2";
			
				$result_count = mysqli_query($con, "SELECT COUNT(*) As total_records FROM `freelancer`");
					$total_records = mysqli_fetch_array($result_count);
					$total_records = $total_records['total_records'];
					$total_no_of_pages = ceil($total_records / $total_records_per_page);
					$second_last = $total_no_of_pages - 1;

				$sql = "SELECT * FROM freelancer WHERE verified = 'true' LIMIT $offset, $total_records_per_page";
				$rs_result = mysqli_query ($con, $sql); //run the query 
				while ($row = mysqli_fetch_assoc($rs_result)) {
					$fid = $row['id'];
					$freelancer = $row['user_id'];
					$ffirstname = $row['firstname'];
					$flastname = $row['lastname'];
					$tagline = $row['tagline'];
					$nation = $row['nationality'];
					$pic = $row['picture'];
					$minrate = $row['minimal_hourly_rate'];
					$verify;

					if ($row['verified'] == 'true') {
						$verify = "";
					} else {
						$verify = "";
					}

					$success = "SELECT * FROM mytask WHERE freelancer_id = '$freelancer' AND finished IS NOT NULL "; 
					$successres=mysqli_query($con,$success);
					$successcount = mysqli_num_rows($successres);
							
					$total = "SELECT * FROM mytask WHERE freelancer_id = '$freelancer' "; 
					$totalres=mysqli_query($con,$total);
					$totalcount = mysqli_num_rows($totalres);

					$calc;
					if ($totalcount < 1){
						$calc = 0;
					} else {
						$calc = ($successcount / $totalcount) * 100;
						$calc = number_format($calc, 0);
					}
																			
					echo "
				<div class='freelancer'>

					<div class='freelancer-overview'>
						<div class='freelancer-overview-inner'>
							
							<span class='bookmark-icon'></span>
							
							<div class='freelancer-avatar'>
								$verify
								<a href='single-freelancer-profile.php?freelancer=$freelancer'><img src='../images/freelancer/profile/$pic' alt=''></a>
							</div>

							<div class='freelancer-name'>
								<h4><a href='single-freelancer-profile.php?freelancer=$freelancer'>$ffirstname $flastname <img class='flag' src='../images/flags/gb.svg' alt='' title='$nation' data-tippy-placement='top'></a></h4>
								<span>$tagline</span>
								<!-- Rating -->
								<div class='freelancer-rating'>
									<div class='star-rating' data-rating='4.9'></div>
								</div>
							</div>
						</div>
					</div>
					
					<div class='freelancer-details'>
						<div class='freelancer-details-list'>
							<ul>
								<li>Location <strong><i class='icon-material-outline-location-on'></i> $nation</strong></li>
								<li>Rate <strong>₦$minrate / hr</strong></li>
								<li>Job Success <strong>$calc%</strong></li>
							</ul>
						</div>
						<a href='single-freelancer-profile.php?freelancer=$freelancer' class='button button-sliding-icon ripple-effect'>View Profile <i class='icon-material-outline-arrow-right-alt'></i></a>
					</div>
				</div>
						";
				}
				?>
	
			</div>
			<!-- Freelancers Container / End -->


			<!-- Pagination -->
			<div class="clearfix"></div>
			<div class="row">
				<div class="col-md-12">
					<!-- Pagination -->
					<div class="pagination-container margin-top-40 margin-bottom-60">
						<nav class="pagination">
							<ul>
							<?php
							if ($total_no_of_pages <= 10){   
 								for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
 									if ($counter == $page_no) {
 										echo "<li class='current-page ripple-effect'><a>$counter</a></li>"; 
        							}else{
        								echo "<li><a href='?page_no=$counter' class='ripple-effect'>$counter</a></li>";
                					}
        						}
							}
							?>
							</ul>
						</nav>
					</div>
				</div>
			</div>
			<!-- Pagination / End -->

		</div>
	</div>
</div>


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
$('#autocomplete-input').on('input', function(){
	$('#searchresult').append(location);
	$.ajax({
        url:"filterfreelancer.php",
        type:"post",
		data: {
			'location' : document.getElementById('autocomplete-input').value,
			'pricerange' : document.getElementById('pricerange').value
		},
        success: function(response){
			$('#searchresult').html(response);
        },
        error: function(response){
            console.log('could not fetch data');
        },
        complete: function(response){
            // hide loading
        }
    });
});
</script>

<script>
$('#pricerange').on('change', function(){
	$('#searchresult').append(location);
	$.ajax({
        url:"filterfreelancer.php",
        type:"post",
		data: {
			'location' : document.getElementById('autocomplete-input').value,
			'pricerange' : document.getElementById('pricerange').value
		},
        success: function(response){
			$('#searchresult').html(response);
        },
        error: function(response){
            console.log('could not fetch data');
        },
        complete: function(response){
            // hide loading
        }
    });
});
</script>

<!-- Google Autocomplete -->
<script>
	function initAutocomplete() {
		 var options = {
		  types: ['(cities)'],
		  // componentRestrictions: {country: "us"}
		 };

		 var input = document.getElementById('autocomplete-input');
		 var autocomplete = new google.maps.places.Autocomplete(input, options);
	}
</script>

<!-- Google API & Maps -->
<!-- Geting an API Key: https://developers.google.com/maps/documentation/javascript/get-api-key -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAaoOT9ioUE4SA8h-anaFyU4K63a7H-7bc&amp;libraries=places"></script>

</body>

</html>