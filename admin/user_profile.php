<?php
include('install.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: auth_login.php");
} else {
    if (!isset($_GET['user_id'])) header("Location: apps_contacts.php");

    $id = $_SESSION['admin_id'];
    $uid = $_GET['user_id'];

    $firstname;
    $lastname;
    $email;
    $location;
    $introduction;
    $tagline;
    $minimal_hourly_rate;
    $skills;
    $attachment;
    $verified;
    $picture;

    $first_check = "SELECT * FROM users WHERE id = '$uid' LIMIT 1";
    $first_response = mysqli_fetch_assoc(mysqli_query($con, $first_check));
    $created = $first_response['created'];

    $created = date('D d M Y', strtotime($created));
    
    if ($first_response['acct_type'] == 'employer') {
        $get_emp = "SELECT * FROM employer WHERE user_id = '$uid' LIMIT 1 ";
        $emp_data = mysqli_fetch_assoc(mysqli_query($con, $get_emp));

        $firstname = $emp_data['firstname'];
        $lastname = $emp_data['lastname'];
        $email = $emp_data['email'];
        $location = $emp_data['nationality'];
        $introduction = $emp_data['introduction'];
        $picture = "../images/employer/profile/".$emp_data['picture'];
        $tagline = "";
        $minimal_hourly_rate = "";
        $skills = "";
        $attachment = "";
        $verified = "";

    } else if ($first_response['acct_type'] == 'freelancer') {
        $get_frl = "SELECT * FROM freelancer WHERE user_id = '$uid' LIMIT 1 ";
        $frl_data = mysqli_fetch_assoc(mysqli_query($con, $get_frl));

        $firstname = $frl_data['firstname'];
        $lastname = $frl_data['lastname'];
        $email = $frl_data['email'];
        $location = $frl_data['nationality'];
        $introduction = $frl_data['introduction'];
        $tagline = $frl_data['tagline'];
        $minimal_hourly_rate = $frl_data['minimal_hourly_rate'];
        $skills = $frl_data['skills'];
        $attachment = $frl_data['attachment'];
        $verified = $frl_data['verified'];
        $picture = "../images/freelancer/profile/".$frl_data['picture'];
    } else {
        $firstname = "";
        $lastname = "";
        $email = "";
        $location = "";
        $introduction = "";
        $tagline = "";
        $minimal_hourly_rate = "";
        $skills = "";
        $attachment = "";
        $verified = "";
    }
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

                <div class="row layout-spacing">

                    <!-- Content -->
                    <div class="col-xl-4 col-lg-6 col-md-5 col-sm-12 layout-top-spacing">

                        <div class="user-profile layout-spacing">
                            <div class="widget-content widget-content-area">
                                <div class="d-flex justify-content-between">
                                    <h3 class="">Profile</h3>
                                    <a href="" class="mt-2 edit-profile"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></a>
                                </div>
                                <div class="text-center user-info">
                                    <img src="<?php echo $picture; ?>" style="width: 120px; height: 120px;" alt="avatar">
                                    <p class=""><?php echo $firstname." ".$lastname; ?></p>
                                </div>
                                <div class="user-info-list">

                                    <div class="">
                                        <ul class="contacts-block list-unstyled">
                                            <li class="contacts-block__item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-coffee"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg><?php echo $first_response['acct_type']; ?>
                                            </li>
                                            <li class="contacts-block__item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg><?php echo $created; ?>
                                            </li>
                                            <li class="contacts-block__item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg><?php echo $location; ?>
                                            </li>
                                            <li class="contacts-block__item">
                                                <a href="mailto:example@mail.com"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg><?php echo $email; ?></a>
                                            </li>
                                            <li class="contacts-block__item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg> +1 (530) 555-12121
                                            </li>
                                            
                                        </ul>
                                    </div>                                    
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-xl-8 col-lg-6 col-md-7 col-sm-12 layout-top-spacing">
                    <?php
                    if ($first_response['acct_type'] == 'employer') {

                    } else if ($first_response['acct_type'] == 'freelancer') {
                        echo "
                        <div class='skills layout-spacing '>
                            <div class='widget-content widget-content-area'>
                                <h3 class=''>Skills</h3>";
                                $skill = explode(",", $skills);
							    for($i=0; $i < count($skill); $i++) {
                                    echo "
                                    <div class='progress br-30'>
                                        <div class='progress-bar bg-primary' role='progressbar' style='width: 100%' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'><div class='progress-title'><span>$skill[$i]</span> </div></div>
                                    </div>";
							    }
                                echo "
                            </div>
                        </div>";
                    }
                    ?>

                        <div class="bio layout-spacing ">
                            <div class="widget-content widget-content-area">
                                <h3 class="">Introduction</h3>
                                <p><?php echo $introduction; ?></p>

                                <div class="bio-skill-box">

                                    <div class='row'>

                                    <?php
                                    if ($first_response['acct_type'] == 'employer') {
                                    } else if ($first_response['acct_type'] == 'freelancer') {
                                        echo "
                                        <div class='col-12 col-xl-6 col-lg-12 mb-xl-5 mb-5 '>
                                            <div class='d-flex b-skills'>
                                                <div>
                                                </div>
                                                <div class=''>
                                                    <h5>Minimal Hourly Rate</h5>
                                                    <p><b>₦</b> $minimal_hourly_rate</p>
                                                </div>
                                            </div>
                                        </div>";
                                    }
                                    ?>
                                        
                                        <div class='col-12 col-xl-6 col-lg-12 mb-xl-5 mb-5 '>
                                            <div class='d-flex b-skills'>
                                                <div>
                                                </div>
                                                <div class=''>
                                                    <h5>Tagline</h5>
                                                    <p><?php echo $tagline; ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class='col-12 col-xl-6 col-lg-12 mb-xl-0 mb-0 '>
                                            <div class='d-flex b-skills'>
                                                <div>
                                                </div>
                                                <div class=''>
                                                    <h5>Attachment</h5>
                                                    <p><?php echo $attachment; ?></p>
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