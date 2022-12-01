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
                <div class="row layout-spacing layout-top-spacing" id="cancel-row">
                    <div class="col-lg-12">
                        <div class="widget-content searchable-container list">

                            <div class="row">
                                <div class="col-xl-4 col-lg-5 col-md-5 col-sm-7 filtered-list-search layout-spacing align-self-center">
                                    <form class="form-inline my-2 my-lg-0">
                                        <div class="">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                            <input type="text" class="form-control product-search" id="input-search" placeholder="Search Contacts...">
                                        </div>
                                    </form>
                                </div>

                                <!-- <div class="col-xl-8 col-lg-7 col-md-7 col-sm-5 text-sm-right text-center layout-spacing align-self-center">
                                
                                    <div class="d-flex justify-content-sm-end justify-content-center">
                                        <svg id="btn-add-contact" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                                    </div>

                                    <div class="modal fade" id="addContactModal" tabindex="-1" role="dialog" aria-labelledby="addContactModalTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <i class="flaticon-cancel-12 close" data-dismiss="modal"></i>
                                                    <div class="add-contact-box">
                                                        <div class="add-contact-content">
                                                            <form id="addContactModalTitle" action="features.php" method="post">

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="contact-occupation">
                                                                            <i class="flaticon-fill-area"></i>
                                                                            <input type="text" id="c-occupation" class="form-control" placeholder="Name">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="contact-phone">
                                                                            <i class="flaticon-telephone"></i>
                                                                            <select id="c-phone" name="recipient" class="form-control">
                                                                                <option value=""></option>
                                                                                <?php
                                                                                $res = mysqli_query($con, "SELECT * FROM `users` WHERE acct_type != 'admin' ");
                                                                                while ($row = mysqli_fetch_assoc($res)) {
                                                                                    $uid = $row['id'];
                                                                                    $acct = $row['acct_type'];
                                                                                    $user_first;
                                                                                    $user_last;

                                                                                    if ($acct == 'employer') {
                                                                                        $getemp = "SELECT * FROM employer WHERE user_id = '$uid' ";
                                                                                        $userdata = mysqli_fetch_assoc(mysqli_query($con, $getemp));
                                                    
                                                                                        $user_first = $userdata['firstname'];
                                                                                        $user_last = $userdata['lastname'];
                                                                                    } else if ($acct == 'freelancer') {
                                                                                        $getfrl = "SELECT * FROM freelancer WHERE user_id = '$uid' ";
                                                                                        $frldata = mysqli_fetch_assoc(mysqli_query($con, $getfrl));
                                                                                        
                                                                                        $user_first = $frldata['firstname'];
                                                                                        $user_last = $frldata['lastname'];
                                                                                    } else {
                                                                                        $user_first = "";
                                                                                        $user_last = "";
                                                                                    }                                                                                    
                                                                                    echo "<option value='$uid'>$user_first $user_last</option>";
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <span class="validation-text"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="contact-location">
                                                                            <i class="flaticon-location-1"></i>
                                                                            <input type="hidden" value="<?php echo $id; ?>" name="sender" />
                                                                            <textarea type="text" name="message" col="7" row="5" class="form-control" placeholder="Your message"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button id="btn-edit" class="float-left btn">Save</button>

                                                    <button class="btn" data-dismiss="modal"> <i class="flaticon-delete-1"></i> Discard</button>

                                                    <button id="btn-add" name="send_dm" form="addContactModalTitle" class="btn">Send</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div> -->
                            </div>

                            <div class="searchable-items list">
                                <div class="items items-header-section">
                                    <div class="item-content">
                                        <div class="">
                                            <div class="n-chk align-self-center text-center">
                                                <label class="new-control new-checkbox checkbox-primary">
                                                  <input type="checkbox" class="new-control-input" id="contact-check-all">
                                                  <span class="new-control-indicator"></span>
                                                </label>
                                            </div>
                                            <h4>Name</h4>
                                        </div>
                                        <div class="user-email">
                                            <h4>Email</h4>
                                        </div>
                                        <div class="user-location">
                                            <h4 style="margin-left: 0;">Location</h4>
                                        </div>
                                        <div class="user-phone">
                                            <h4 style="margin-left: 3px;">Phone</h4>
                                        </div>
                                        <div class="action-btn">
                                        <h4 style="margin-left: 3px;">Actions</h4>
                                        </div>
                                    </div>
                                </div>

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

                                if ($acct == 'employer') {
                                    $getemp = "SELECT * FROM employer WHERE user_id = '$uid' ";
                                    $userdata = mysqli_fetch_assoc(mysqli_query($con, $getemp));

                                    $firstname = $userdata['firstname'];
                                    $lastname = $userdata['lastname'];
                                    $email = $userdata['email'];
                                    $location = $userdata['nationality'];
                                    $picture = "../images/employer/profile/".$userdata['picture'];
                                    $phone = "";
                                } else if ($acct == 'freelancer') {
                                    $getfrl = "SELECT * FROM freelancer WHERE user_id = '$uid' ";
                                    $frldata = mysqli_fetch_assoc(mysqli_query($con, $getfrl));
                                    
                                    $firstname = $frldata['firstname'];
                                    $lastname = $frldata['lastname'];
                                    $email = $frldata['email'];
                                    $location = $frldata['nationality'];
                                    $picture = "../images/freelancer/profile/".$frldata['picture'];
                                    $phone = "";
                                } else {
                                    $firstname = "";
                                    $lastname = "";
                                    $email = "";
                                    $location = "";
                                    $phone = "";
                                }

                                echo "
                                <a class='items' href='user_profile.php?user_id=$uid'>
                                    <div class='item-content'>
                                        <div class='user-profile'>
                                            <div class='n-chk align-self-center text-center'>
                                                <label class='new-control new-checkbox checkbox-primary'>
                                                  <input type='checkbox' class='new-control-input contact-chkbox'>
                                                  <span class='new-control-indicator'></span>
                                                </label>
                                            </div>
                                            <img src='$picture' alt='avatar'>
                                            <div class='user-meta-info'>
                                                <p class='user-name' data-name='$firstname $lastname'>$firstname $lastname</p>
                                                <p class='user-work' data-occupation='$acct'>$acct</p>
                                            </div>
                                        </div>
                                        <div class='user-email'>
                                            <p class='info-title'>Email: </p>
                                            <p class='usr-email-addr' data-email='$email'>$email</p>
                                        </div>
                                        <div class='user-location'>
                                            <p class='info-title'>Location: </p>
                                            <p class='usr-location' data-location='$location'>$location</p>
                                        </div>
                                        <div class='user-phone'>
                                            <p class='info-title'>Phone: </p>
                                            <p class='usr-ph-no' data-phone='+1 (070) 123-4567'>+1 (070) 123-4567</p>
                                        </div>
                                        <div class='action-btn'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-user-minus delete'><path d='M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2'></path><circle cx='8.5' cy='7' r='4'></circle><line x1='23' y1='11' x2='17' y2='11'></line></svg>
                                        </div>
                                    </div>
                                </a>
                                ";
                            }
                            ?>
                                
                              
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <?php
             include("footer.php");
             ?>