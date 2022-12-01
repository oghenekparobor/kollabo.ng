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
            <div class="container">

                <div class="container">

                    <div class="row layout-top-spacing">

                        <div id="searchLive" class="col-lg-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h4>Users Account Settings</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area text-center tags-content">
                                    
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-sm-9 filtered-list-search mx-auto">
                                            <form class="form-inline my-2 my-lg-0 justify-content-center">
                                                <div class="w-100">
                                                    <input type="text" class="w-100 form-control product-search br-30" id="input-search" placeholder="Search users..." >
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-lg-12">

                                            <div class="searchable-container">
                                                <div class="row">
                                                    <div class="col-md-12">

                                                        <div class="searchable-items">
                                                        <?php
                                                        $allusers = "SELECT * FROM users WHERE acct_type != 'admin' ORDER BY id DESC";
                                                        $response = mysqli_query($con, $allusers);
                                                        while ($row = mysqli_fetch_assoc($response)) {
                                                            $uid = $row['id'];
                                                            $acct = $row['acct_type'];
                                                            $firstname;
                                                            $lastname;
                                                            $email;
                                                            $location;
                                                            $phone;
                                                            $picture;
                                                            $verify;
                                                            $block_status;
                            
                                                            if ($acct == 'employer') {
                                                                $getemp = "SELECT * FROM employer WHERE user_id = '$uid' ";
                                                                $userdata = mysqli_fetch_assoc(mysqli_query($con, $getemp));
                            
                                                                $firstname = $userdata['firstname'];
                                                                $lastname = $userdata['lastname'];
                                                                $email = $userdata['email'];
                                                                $location = $userdata['nationality'];
                                                                $picture = "../images/employer/profile/".$userdata['picture'];
                                                                $phone = "";
                                                                $verify = "";

                                                                if ($row['block_status'] == 'opened') {
                                                                    $block_status = "
                                                                    <div class='user-status'>
                                                                        <a href='block_unblock.php?user_id=$uid'><span class='badge badge-danger'>Block</span></a>
                                                                    </div> ";
                                                                } else {
                                                                    $block_status = "
                                                                    <div class='user-status'>
                                                                        <a href='block_unblock.php?user_id=$uid'><span class='badge badge-warning'>Unblock</span></a>
                                                                    </div> ";
                                                                }

                                                            } else if ($acct == 'freelancer') {
                                                                $getfrl = "SELECT * FROM freelancer WHERE user_id = '$uid' ";
                                                                $frldata = mysqli_fetch_assoc(mysqli_query($con, $getfrl));
                                                                
                                                                $firstname = $frldata['firstname'];
                                                                $lastname = $frldata['lastname'];
                                                                $email = $frldata['email'];
                                                                $location = $frldata['nationality'];
                                                                $picture = "../images/freelancer/profile/".$frldata['picture'];
                                                                $phone = "";

                                                                if ($frldata['verified'] == 'true') {
                                                                    $verify = "
                                                                    <div class='user-status'>
                                                                        <a><span class='badge badge-primary'>Verified</span></a>
                                                                    </div>";
                                                                } else {
                                                                    $verify = "
                                                                    <div class='user-status'>
                                                                        <a href='verify.php?user_id=$uid'><span class='badge badge-warning'>Verify</span></a>
                                                                    </div>";
                                                                }

                                                                if ($row['block_status'] == 'opened') {
                                                                    $block_status = "
                                                                    <div class='user-status'>
                                                                        <a href='block_unblock.php?user_id=$uid'><span class='badge badge-danger'>Block</span></a>
                                                                    </div> ";
                                                                } else {
                                                                    $block_status = "
                                                                    <div class='user-status'>
                                                                        <a href='block_unblock.php?user_id=$uid'><span class='badge badge-warning'>Unblock</span></a>
                                                                    </div> ";
                                                                }
                                                                
                                                            } else {
                                                                $firstname = "";
                                                                $lastname = "";
                                                                $email = "";
                                                                $location = "";
                                                                $phone = "";
                                                            }
                            
                                                            echo "
                                                            <div class='items'>
                                                                <div class='user-profile'>
                                                                    <img src='$picture' alt='avatar'>
                                                                </div>
                                                                <div class='user-name'>
                                                                    <p class=''>$firstname $lastname</p>
                                                                </div>
                                                                <div class='user-email'>
                                                                    <p>$email</p>
                                                                </div>
                                                                $verify
                                                                $block_status                                                               
                                                            </div>
                                                            ";
                                                        }
                                                        ?>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                   

                                </div>
                            </div>
                        </div>


                    </div>
                    
                </div>

            </div>

            <?php
              include("footer.php");
            ?>