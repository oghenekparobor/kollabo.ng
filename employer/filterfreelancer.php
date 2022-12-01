<?php
include('install.php');

$loc;

$location = $_POST['location'];
$pr = $_POST['pricerange'];

$price = explode(",", $pr);
$min = $price[0];
$max = $price[1];

if (empty($location)) {
    $loc = "SELECT * FROM freelancer WHERE minimal_hourly_rate > $min AND minimal_hourly_rate < $max AND verified = 'true' ";
} else {
    $loc = " SELECT * FROM freelancer WHERE nationality LIKE '%$location%' AND minimal_hourly_rate > $min AND minimal_hourly_rate < $max AND verified = 'true' ";
}
				$rs_result = mysqli_query($con, $loc); //run the query 
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
                    	// echo "wqwqw";																		
					echo "
				<div class='freelancer'>

					<div class='freelancer-overview'>
						<div class='freelancer-overview-inner'>
							
							<span class='bookmark-icon'></span>
							
							<div class='freelancer-avatar'>
								$verify
								<a href='single-freelancer-profile.html'><img src='../images/freelancer/profile/$pic' alt=''></a>
							</div>

							<div class='freelancer-name'>
								<h4><a href='#'>$ffirstname $flastname <img class='flag' src='../images/flags/gb.svg' alt='' title='$nation' data-tippy-placement='top'></a></h4>
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
