<?php
include('install.php');

//change orders to paid & mytaskstatus to paid

$orderid = $_POST['order_id'];
$taskid = $_POST['task_id'];
$reference = $_POST['reference_id'];
$freelancer_id = $_POST['freelancer_id'];
$price = $_POST['price'];
$userid = $_POST['userid'];

$first = "UPDATE orders SET order_ref = '$reference', status = 'paid' WHERE id = '$orderid' ";
if (mysqli_query($con, $first)) {

  $second = "UPDATE mytask SET payment_status = 'paid' ";
  if (mysqli_query($con, $second)) {
    
    $third = "SELECT * FROM wallet WHERE freelancer_id = '$freelancer_id' ";
    $result = mysqli_query($con, $third);
	  $wallet = mysqli_fetch_assoc($result);
    $balance = $wallet['balance'];
    
    $new_balance = $balance + $price;

    $final = "UPDATE wallet SET balance = '$new_balance' WHERE freelancer_id = '$freelancer_id' ";
    if (mysqli_query($con, $final)) {
      mysqli_query($con, "INSERT INTO `transactions` (`id`, `payer_id`, `payee_id`, `transaction_type`, `amount`, `created`) VALUES (NULL, '$userid', '$freelancer_id', 'transfer', '$price', current_timestamp())");
      echo "PAYMENT_SUCCESSFUL";
    } else {
      echo "WALLET_UPDATE_FAILED";
    }
  } else {
    echo "PAYMENT_ERROR";
  } 
} else {
  echo "PAYMENT_ERROR";
}
