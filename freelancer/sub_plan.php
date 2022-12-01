<?php
include('install.php');

$freelancer_id = mysqli_real_escape_string($con, $_POST['freelancer_id']);
$duration = mysqli_real_escape_string($con, $_POST['duration']);
$amount = mysqli_real_escape_string($con, $_POST['amount']);

$admin = "SELECT * FROM users WHERE acct_type = 'admin' LIMIT 1";
$resd = mysqli_query($con, $admin);
$admin = mysqli_fetch_assoc($resd);
$adid = $admin['id'];

$days = 1;
if ($duration == 1) {
    $days = 30;
} else if ($duration == 12) {
    $days = 365;
}

$duration = date("Y-m-d", strtotime('+$days month'));

$first = "SELECT * FROM active_plan WHERE freelancer_id = '$freelancer_id' ";
$first_res = mysqli_query($con, $first);
if (mysqli_num_rows($con, $first_res) > 0) {
    $get = mysqli_fetch_assoc($con, $first);
    $expiration =  $get['expiry_date'];

    $tmstamp = strtotime($duration) + strtotime($expiration);

    $new_date = date("Y m d", $tmstamp) ;

    $second = "UPDATE active_plan SET expiry_date = '$new_date', created = current_timestamp() WHERE freelancer_id = '$freelancer_id' ";
    if (mysqli_query($con, $second)) {
      mysqli_query($con, "INSERT INTO `transactions` (`id`, `payer_id`, `payee_id`, `transaction_type`, `amount`, `created`) VALUES (NULL, '$freelancer_id', '$adid', 'credit', '$amount', current_timestamp())");
        echo "PLAN_UPDATED";
    } else {
        echo "ERROR_UPDATING_PLAN";
    }
} else {
    $last = " INSERT INTO `active_plan` (`id`, `freelancer_id`, `expiry_date`, `created`) 
                VALUES (NULL, '', '', current_timestamp()) ";
    if (mysqli_query($con, $last)) {
      mysqli_query($con, "INSERT INTO `transactions` (`id`, `payer_id`, `payee_id`, `transaction_type`, `amount`, `created`) VALUES (NULL, '$freelancer_id', '$adid', 'credit', '$amount', current_timestamp())");
        echo "PLAN_CREATED";
    } else {
        echo "PLAN_CREATION_FAILED";
    }
}

