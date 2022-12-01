<?php
include('install.php');

if(!isset($_SESSION['user_id'])) {
	header("Location: ../login.php");
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
<?php include('header.php'); ?>
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
							<input id="autocomplete-input" type="text" placeholder="Location">
						</div>
						<i class="icon-material-outline-location-on"></i>
					</div>
				</div>

				<!-- Budget -->
				<div class="sidebar-widget">
					<h3>Fixed Price</h3>
					<div class="margin-top-55"></div>

					<!-- Range Slider -->
					<input class="range-slider" type="text" value="" id="pricerange" data-slider-currency="₦" data-slider-min="100" data-slider-max="100000" data-slider-step="5" data-slider-value="[100,100000]"/>
				</div>

				<div class="clearfix"></div>

			</div>
		</div>
		<div class="col-xl-9 col-lg-8 content-left-offset">

			<!-- <h3 class="page-title">Search Results</h3> -->

			<div class="notify-box margin-top-15">
				<div class="switch-container">
					<!-- <label class="switch"><input type="checkbox"><span class="switch-button"></span><span class="switch-text">Turn on email alerts for this search</span></label> -->
				</div>

				<div class="sort-by">
					<span>Sort by:</span>
					<select class="selectpicker hide-tick">
						<option>Newest</option>
						<option>Oldest</option>
						<option>Random</option>
					</select>
				</div>
			</div>
			
			<!-- Tasks Container -->
			<div class="tasks-list-container compact-list margin-top-35" id="searchresult">
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
			
				$result_count = mysqli_query($con, "SELECT COUNT(*) As total_records FROM `tasks` WHERE bid_status = 'active' ");
					$total_records = mysqli_fetch_array($result_count);
					$total_records = $total_records['total_records'];
					$total_no_of_pages = ceil($total_records / $total_records_per_page);
					$second_last = $total_no_of_pages - 1;

				$sql = "SELECT * FROM tasks WHERE bid_status = 'active' LIMIT $offset, $total_records_per_page";
				$rs_result = mysqli_query ($con, $sql); //run the query 
				while ($row = mysqli_fetch_assoc($rs_result)) {
					$tid = $row['id'];
					$title = $row['title'];
					$type = $row['type'];
					$created = $row['created'];
					$min = $row['min_salary'];
					$max = $row['max_salary'];
					$description = $row['description'];
					$tags = $row['tags'];
					$location = $row['location'];					
																			
					echo "
				<a href='single-task-page.php?taskid=$tid' class='task-listing'>

					<div class='task-listing-details'>

						<div class='task-listing-description'>
							<h3 class='task-listing-title'>$title</h3>
							<ul class='task-icons'>
								<li><i class='icon-material-outline-location-on'></i> $location</li>
								<li><i class='icon-material-outline-access-time'></i> $created</li>
							</ul>
							<p class='task-listing-text'>$description</p>
							<div class='task-tags'>";
							$tag = explode(",", $tags);
							for($i=0; $i < count($tag); $i++){
								echo "<span>$tag[$i]</span> &nbsp;";
							}
							echo "
							</div>
						</div>

					</div>

					<div class='task-listing-bid'>
						<div class='task-listing-bid-inner'>
							<div class='task-offers'>
								<strong>₦$min - ₦$max</strong>
								<span>$type</span>
							</div>
							<form action='single-task-page.php?taskid=$tid' method='post'>
							<button type='submit' class='button button-sliding-icon ripple-effect'>Bid Now <i class='icon-material-outline-arrow-right-alt'></i></button>
							</form>
						</div>
					</div>
				</a>
				";
				}
				?>		

			</div>
			<!-- Tasks Container / End -->


			<!-- Pagination -->
			<div class="clearfix"></div>
			<div class="row">
				<div class="col-md-12">
					<!-- Pagination -->
					<div class="pagination-container margin-top-60 margin-bottom-60">
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
        url:"filtertask.php",
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
        url:"filtertask.php",
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