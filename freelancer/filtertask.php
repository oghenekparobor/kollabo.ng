<?php
include('install.php');

$loc;

$location = $_POST['location'];
$pr = $_POST['pricerange'];

$price = explode(",", $pr);
$min = $price[0];
$max = $price[1];

if (empty($location)) {
    $loc = "SELECT * FROM `tasks` WHERE `min_salary` > $min AND `max_salary` < $max AND bid_status = 'active' ";
} else {
    $loc = " SELECT * FROM `tasks` WHERE `location` LIKE '%$location%' AND `min_salary` > $min AND `max_salary` < $max AND bid_status = 'active' ";
}

$rs_result = mysqli_query ($con, $loc); //run the query 
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
                                                            
    echo "<a href='single-task-page.php?taskid=$tid' class='task-listing'>

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
</a>";
				}
