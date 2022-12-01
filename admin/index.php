<?php
include('install.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: auth_login.php");
} else {
    $id = $_SESSION['admin_id'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Kollabo | Admin </title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/main.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/apps/contacts.css" rel="stylesheet" type="text/css" />
     <link href="assets/css/apps/mailing-chat.css" rel="stylesheet" type="text/css" />
     <link href="assets/css/elements/search.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    
    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="assets/css/users/user-profile.css" rel="stylesheet" type="text/css" />
    <!--  END CUSTOM STYLE FILE  -->
    
     <!-- BEGIN PAGE LEVEL STYLE -->
    <link href="plugins/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
    <link href="plugins/fullcalendar/custom-fullcalendar.advance.css" rel="stylesheet" type="text/css" />
    <link href="plugins/flatpickr/flatpickr.css" rel="stylesheet" type="text/css">
    <link href="plugins/flatpickr/custom-flatpickr.css" rel="stylesheet" type="text/css">
    <link href="assets/css/forms/theme-checkbox-radio.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL STYLE -->
    
     <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

    
    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <!--  END CUSTOM STYLE FILE  -->

      <!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/dt-global_style.css">
    <!-- END PAGE LEVEL CUSTOM STYLES -->
    
     <!--  BEGIN CUSTOM STYLE FILE  -->
    <link rel="stylesheet" type="text/css" href="plugins/dropify/dropify.min.css">
    <link href="assets/css/users/account-setting.css" rel="stylesheet" type="text/css" />
    <!--  END CUSTOM STYLE FILE  -->

     <link href="assets/css/authentication/form-1.css" rel="stylesheet" type="text/css" />
    
    <link rel="stylesheet" type="text/css" href="assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="assets/css/forms/switches.css">

     <link href="assets/css/apps/scrumboard.css" rel="stylesheet" type="text/css" />
</head>
<body>

<?php
include("header.php");
?>  

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="row layout-top-spacing">

                    <!-- <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-chart-one">
                            <div class="widget-heading">
                                <h5 class="">Revenue</h5>
                                <ul class="tabs tab-pills">
                                    <li><a href="javascript:void(0);" id="tb_1" class="tabmenu">Yearly</a></li>
                                </ul>
                            </div>

                            <div class="widget-content">
                                <div class="tabs tab-content">
                                    <div id="content_1" class="tabcontent"> 
                                        <div id="revenueMonthly"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-chart-two">
                            <div class="widget-heading">
                                <h5 class="">Sales by Category</h5>
                            </div>
                            <div class="widget-content">
                                <div id="chart-2" class=""></div>
                            </div>
                        </div>
                    </div> -->


                    <div class="col-xl-5 col-lg-12 col-md-6 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-table-one">
                            <div class="widget-heading">
                                <h5 class="">Transactions</h5>
                            </div>

                            <div class="widget-content">

                            <?php 
							$sql = "SELECT * FROM transactions  ORDER BY id DESC LIMIT 4";
							$rs_result = mysqli_query ($con, $sql); //run the query 
							while ($row = mysqli_fetch_assoc($rs_result)) {
								$bid = $row['id'];
								$payer= $row['payer_id'];
								$payee= $row['payee_id'];
								$transact= $row['transaction_type'];
								$amount= $row['amount'];
                                $created= $row['created'];
								$created = date('D d M Y h:i:s a', strtotime($created));
                                
                                $firstname;
                                $lastname;
                                $label;
                                $type;

                                if ($transact == 'transfer') {
                                    $label = "TR";
                                    $type = "
                                    <div class='t-rate rate-dec'>
                                        <p><span>-₦$amount</span> <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-arrow-down'><line x1='12' y1='5' x2='12' y2='19'></line><polyline points='19 12 12 19 5 1'></polyline></svg></p>
                                    </div>";
                                } else if ($transact == 'debit') {
                                    $label = "DR";
                                    $type = "
                                    <div class='t-rate rate-dec'>
                                        <p><span>-₦$amount</span> <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-arrow-down'><line x1='12' y1='5' x2='12' y2='19'></line><polyline points='19 12 12 19 5 1'></polyline></svg></p>
                                    </div>";
                                } else {
                                    $label = "CR";
                                    $type = "
                                    <div class='t-rate rate-inc'>
                                        <p><span>+₦$amount</span> <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-arrow-up'><line x1='12' y1='19' x2='12' y2='5'></line><polyline points='5 12 12 5 19 12'></polyline></svg></p>
                                    </div>";
                                }            

								$sql = "SELECT * FROM users WHERE id = '$payer' LIMIT 1";
								$result = mysqli_query($con, $sql);
								$use = mysqli_fetch_assoc($result);
								$accttype = $use['acct_type'];

								if ($accttype == 'employer'){
									$sql = "SELECT * FROM employer WHERE user_id = '$payer' LIMIT 1";
								    $result = mysqli_query($con, $sql);
								    $user = mysqli_fetch_assoc($result);
								    $firstname = $user['firstname'];
								    $lastname = $user['lastname'];
								} else if ($accttype == 'freelancer') {
									$sql = "SELECT * FROM freelancer WHERE user_id = '$payer' LIMIT 1";
								    $result = mysqli_query($con, $sql);
								    $user = mysqli_fetch_assoc($result);
								    $firstname = $user['firstname'];
								    $lastname = $user['lastname'];
								} else {
                                    $firstname = "Kollabo";
                                    $lastname = ".ng";
                                }
																			
								echo "

                                <div class='transactions-list'>
                                    <div class='t-item'>
                                        <div class='t-company-name'>
                                            <div class='t-icon'>
                                                <div class='avatar avatar-xl'>
                                                    <span class='avatar-title rounded-circle'>$label</span>
                                                </div>
                                            </div>
                                            <div class='t-name'>
                                                <h4>$firstname $lastname</h4>
                                                <p class='meta-date'>$created</p>
                                            </div>
                                        </div>
                                        $type
                                    </div>
                                </div>
                                
                                ";
							}
							?>

                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                        
                        <div class="widget widget-activity-four">

                            <div class="widget-heading">
                                <h5 class="">Recent Activities</h5>
                            </div>

                            <div class="widget-content">

                                <div class="mt-container mx-auto">
                                    <div class="timeline-line">
                                        
                                        <div class='item-timeline timeline-primary'>
                                            <div class='t-dot' data-original-title='' title=''>
                                            </div>
                                            <div class='t-text'>
                                                <p>Updated Server Logs</p>
                                                <!-- <span class='badge badge-danger'>Pending</span> -->
                                                <p class='t-time'>Just Now</p>
                                            </div>
                                        </div>


                                    </div>                                    
                                </div>

                                <div class="tm-action-btn">
                                    <!-- <button class="btn">View All <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></button> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                        
                        <div class="widget widget-account-invoice-one">

                            <div class="widget-heading">
                                <h5 class="">Account Info</h5>
                            </div>

                            <div class="widget-content">
                                <div class="invoice-box">
                                    
                                    <div class="acc-total-info">
                                        <h5>Balance</h5>
                                        <p class="acc-amount">₦470</p>
                                    </div>

                                    <div class="inv-detail">                                        
                                        <div class="info-detail-1">
                                            <p>Monthly Plan</p>
                                            <p>₦ 199.0</p>
                                        </div>
                                        <div class="info-detail-2">
                                            <p>Taxes</p>
                                            <p>₦ 17.82</p>
                                        </div>
                                        <div class="info-detail-3 info-sub">
                                            <div class="info-detail">
                                                <p>Extras this month</p>
                                                <p>₦ -0.68</p>
                                            </div>
                                            <div class="info-detail-sub">
                                                <p>Netflix Yearly Subscription</p>
                                                <p>₦ 0</p>
                                            </div>
                                            <div class="info-detail-sub">
                                                <p>Others</p>
                                                <p>₦ -0.68</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="inv-action">
                                        <a href="#" class="btn btn-dark">Summary</a>
                                        <a href="#" class="btn btn-danger">Transfer</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div> -->

                    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-table-two">

                            <div class="widget-heading">
                                <h5 class="">Recent Freelancers</h5>
                            </div>

                            <div class="widget-content">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><div class="th-content">Freelancer</div></th>
                                                <th><div class="th-content">Email</div></th>
                                                <th><div class="th-content">Status</div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
							$sql = "SELECT * FROM freelancer WHERE DATE(created) <= CURRENT_DATE AND DATE(created) >= (CURRENT_DATE - INTERVAL 7 DAY ) ORDER BY id DESC LIMIT 8 ";
							$rs_result = mysqli_query ($con, $sql); //run the query 
							while ($row = mysqli_fetch_assoc($rs_result)) {
								$fid = $row['id'];
								$firstname= $row['firstname'];
								$lastname = $row['lastname'];
								$email = $row['email'];
								$picture = $row['picture'];
                                $verified = $row['verified'];
                                
                                $label;
                                if ($verified == 'true') {
                                    $verified = "outline-badge-success";
                                    $label = "Verified";
                                } else {
                                    $verified = "outline-badge-danger";
                                    $label = "Pending";
                                }

								echo "
                                            <tr>
                                                <td><div class='td-content customer-name'><img src='../images/freelancer/profile/$picture' alt='avatar'>$firstname $lastname</div></td>
                                                <td><div class='td-content'>$email</div></td>
                                                <td><div class='td-content'><span class='badge $verified'>$label</span></div></td>
                                            </tr>
                                            ";
							}
							?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-table-three">

                            <div class="widget-heading">
                                <h5 class="">Recent Employers</h5>
                            </div>

                            <div class="widget-content">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><div class="th-content">Employer</div></th>
                                                <th><div class="th-content th-heading">Email</div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
							$sql = "SELECT * FROM employer WHERE DATE(created) <= CURRENT_DATE AND DATE(created) >= (CURRENT_DATE - INTERVAL 7 DAY ) ORDER BY id DESC LIMIT 8 ";
							$rs_result = mysqli_query ($con, $sql); //run the query 
							while ($row = mysqli_fetch_assoc($rs_result)) {
								$fid = $row['id'];
								$firstname= $row['firstname'];
								$lastname = $row['lastname'];
								$email = $row['email'];
								$picture = $row['picture'];

								echo "
                                            <tr>
                                                <td><div class='td-content customer-name'><img src='../images/employer/profile/$picture' alt='avatar'>$firstname $lastname</div></td>
                                                <td><div class='td-content'>$email</div></td>
                                            </tr>
                                            ";
							}
							?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
         <?php
            include("footer.php");
          ?>