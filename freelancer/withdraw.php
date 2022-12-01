<?php
include('install.php');

$bank = $_POST['bank'];
$acct_no = $_POST['acct_no'];
$amount = $_POST['amount'];
$userid = $_POST['user_id'];

$check = "SELECT * FROM wallet WHERE freelancer_id = '$userid' ";
$res = mysqli_query($con, $check);
$data = mysqli_fetch_assoc($res);

if ($amount > $data['balance']) {
    echo "<script>alert('Insufficient balance');</script>";
    echo "<script>window.location='wallet.php';</script>";
} else {
    //first check whether account number is valid
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.paystack.co/bank/resolve?account_number=".$acct_no."&bank_code=".$bank,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        // CURLOPT_HTTP_VERSION => CURLOPT_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer sk_live_4f2d6aab0eda959956e0efd3812c3a6124055a74",
            "Cache-Control: no-cache"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "<script>alert('Invalid account number');</script>";
        echo "<script>window.location='wallet.php';</script>";
    } else {
        //initialize the transfer
        $response = json_decode($response);
        $acct_name = $response->data->account_name;

        echo $acct_name;

        $url = "https://api.paystack.co/transfer";
        $fields = [
            "source" => "balance", 
            "reason" => "Freelancer's account withdrawal", 
            "amount" => $amount, 
            "recipient" => "RCP_gx2wn530m0i3w3m"
        ];
        $fields_string = http_build_query($fields);
        //open connection
        $ch = curl_init();
  
        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer sk_live_4f2d6aab0eda959956e0efd3812c3a6124055a74",
            "Cache-Control: no-cache",
        ));
  
        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
  
        //execute post
        $result = curl_exec($ch);

        // $transfer_code = $result->data->transfer_code;

        // echo $transfer_code;
        print_r($result);

        // $url = "https://api.paystack.co/transfer/finalize_transfer";
        // $fields = [
        //     "transfer_code" => "$transfer_code", 
        //     "otp" => "928783"
        // ];

        // $fields_string = http_build_query($fields);
        // //open connection
        // $ch = curl_init();
  
        // //set the url, number of POST vars, POST data
        // curl_setopt($ch,CURLOPT_URL, $url);
        // curl_setopt($ch,CURLOPT_POST, true);
        // curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //     "Authorization:  Bearer sk_live_4f2d6aab0eda959956e0efd3812c3a6124055a74",
        //     "Cache-Control: no-cache",
        // ));
  
        // //So that curl_exec returns the contents of the cURL; rather than echoing it
        // curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
  
        // //execute post
        // $result = curl_exec($ch);
        // echo $result;

    }
}