<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    <title>Courses4U - Log In</title>
    <?php
    include('../includes/head.php');
    ?>
    <style>
        .badge {
            white-space: unset;
            line-height: unset;
        }
    </style>
</head>

<?php
// check if the user logged in
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role_id'] == 1) {
        header("Location: dashboard.php");
        exit();
    } else {
        header("Location: home.php");
        exit();
    }
}

// Declaration of cleaning function
function clean($request)
{
    $request = htmlspecialchars($request);
    $request = trim($request);
    $request = stripcslashes($request);

    return $request;
}


// Validate inputs
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Check Role

    if (isset($_POST[''])) {
        # code...
    }
    // Validate Email
    if (isset($_POST['email'])) {
        $email = clean($_POST['email']);
        if (empty($email)) {
            $_SESSION['errorMessages']['email'] = 'Please enter your <strong>E-mail</strong>';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['errorMessages']['email'] = 'This input must contain <strong>Valid E-mail</strong>';
            $_SESSION['oldData']['email'] = $email;
        } elseif (strlen($email) > 50) {
            $_SESSION['errorMessages']['email'] = 'the maximum length of E-mail is <strong>50 Characters</strong>';
            $_SESSION['oldData']['email'] = $email;
        } else {
            $_SESSION['data']['email'] = $email;
            $_SESSION['oldData']['email'] = $email;
        }
    } else {
        $_SESSION['errorMessages']['email'] = 'Please enter your <strong>E-mail</strong>';
    }

    // Validate Password
    if (isset($_POST['password'])) {
        $password = clean($_POST['password']);
        if (empty($password)) {
            $_SESSION['errorMessages']['password'] = 'Please enter <strong>Password</strong>';
        } elseif (strlen($password) < 8) {
            $_SESSION['errorMessages']['password'] = 'the length of Password must be <strong>8 Characters at least</strong>';
        } elseif (!filter_var($password, FILTER_VALIDATE_REGEXP, [
            'options' => ['regexp' => '^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$^']
        ])) {
            $_SESSION['errorMessages']['password'] = 'Your password must contain at least <strong> 8 characters</strong>, <strong>1 UPPERCASE letter</strong>, <strong>1 lowercase letter</strong>, <strong>1 number</strong> &amp; <strong>1 speci@l ch@r@cter</strong>';
        } else {
            $_SESSION['data']['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
    } else {
        $_SESSION['errorMessages']['password'] = 'Please enter <strong>Password</strong>';
    }
}

?>

<body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-color="bg-chartbg" data-col="2-columns">
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <!-- Top Bar-->
    <?php
    include('../includes/top-bar.php');
    ?>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <!-- Side Bar -->
    <div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true" data-img="../theme-assets/images/backgrounds/02.jpg">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item m-auto text-center"><a class="navbar-brand" href="home.html"><img class="brand-logo" alt="Chameleon admin logo" src="../theme-assets/images/logo/logo.png" />
                        <h3 class="brand-text">Courses<span class="text-danger">4</span><span class="text-primary">U</span></h3>
                    </a></li>
                <li class="nav-item d-md-none"><a class="nav-link close-navbar"><i class="ft-x"></i></a></li>
            </ul>
        </div>
        <!-- <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item"><a href="index.html"><i class="ft-pie-chart"></i><span class="menu-title" data-i18n="">Dashboard</span></a>
                </li>
                <li class="nav-item"><a href="charts.html"><i class="ft-home"></i><span class="menu-title" data-i18n="">Home</span></a>
                </li>
            </ul>
        </div> -->
        <div class="navigation-background"></div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-wrapper-before"></div>
            <div class="content-header row">
                <div class="col-12 text-center my-2">
                    <h2 class="text-white font-weight-bold">Log In Form</h2>
                </div>
            </div>
            <div class="content-body">
                <div class="card w-50 m-auto">
                    <div class="card-content pt-2">
                        <!-- <div class="card-body">
						<h4 class="card-title">Contact Form</h4>
						<h6 class="card-subtitle text-muted">Support card subtitle</h6>
					</div> -->
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tab nav-fill">
                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold active" id="student-tab" data-toggle="tab" href="#student" role="tab" aria-controls="student" aria-selected="true">Student</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold" id="teacher-tab" data-toggle="tab" href="#teacher" role="tab" aria-controls="teacher" aria-selected="true">Teacher</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="myTabContent">
                                <!-- Student Login -->
                                <div class="tab-pane fade show active" id="student" role="tabpanel" aria-labelledby="student-tab">
                                    <form class="form" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                                        <div class="form-body">
                                            <div class="row">
                                                <input type="hidden" name="role_id" value="2">

                                                <!-- E-mail -->
                                                <div class="col-md-12 form-group text-center">
                                                    <label for="email" class="font-weight-bold">E-mail</label>
                                                    <input type="text" id="email" class="form-control" placeholder="Enter Your E-mail" name="email" value=<?= isset($_SESSION['oldData']['emailStudent']) ? '"' .  $_SESSION['oldData']['emailStudent'] . '"' : "" ?>>
                                                    <?= (isset($_SESSION['errorMessages']['emailStudent'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['emailStudent'] . "</div>" : ''; ?>
                                                </div>

                                                <!-- Password -->
                                                <div class="col-md-12 form-group text-center">
                                                    <label for="password" class="font-weight-bold">Password</label>
                                                    <input type="password" id="password" class="form-control" placeholder="Enter Your Password" name="password">
                                                    <?= (isset($_SESSION['errorMessages']['passwordStudent'])) ? "<div class='badge badge-danger mt-1 mw-100'>" . $_SESSION['errorMessages']['passwordStudent'] . "</div>" : ''; ?>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-actions center">
                                            <button type="submit" class="btn btn-outline-primary">Log In</button>
                                        </div>
                                    </form>

                                </div>
                                <!-- Teacher Login -->
                                <div class="tab-pane fade" id="teacher" role="tabpanel" aria-labelledby="teacher-tab">
                                    <form class="form" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                                        <div class="form-body">
                                            <div class="row">
                                                <input type="hidden" name="role_id" value="1">

                                                <!-- E-mail -->
                                                <div class="col-md-12 form-group text-center">
                                                    <label for="email" class="font-weight-bold">E-mail</label>
                                                    <input type="text" id="email" class="form-control" placeholder="Enter Your E-mail" name="email" value=<?= isset($_SESSION['oldData']['emailTeacher']) ? '"' .  $_SESSION['oldData']['emailTeacher'] . '"' : "" ?>>
                                                    <?= (isset($_SESSION['errorMessages']['emailTeacher'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['emailTeacher'] . "</div>" : ''; ?>
                                                </div>

                                                <!-- Password -->
                                                <div class="col-md-12 form-group text-center">
                                                    <label for="password" class="font-weight-bold">Password</label>
                                                    <input type="password" id="password" class="form-control" placeholder="Enter Your Password" name="password">
                                                    <?= (isset($_SESSION['errorMessages']['passwordTeacher'])) ? "<div class='badge badge-danger mt-1 mw-100'>" . $_SESSION['errorMessages']['passwordTeacher'] . "</div>" : ''; ?>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-actions center">
                                            <button type="submit" class="btn btn-outline-primary">Log In</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <?php
    include('../includes/footer.php');
    ?>

    <?php
    include('../includes/scripts.php');
    ?>

    <script>
        $(function() {

            // Get Cities by ajax function 
            function getCities(country_id, selected = null) {
                $('#city').html(`<option class="text-muted" value="">Choose Your City</option>`);

                $.ajax({
                    url: '../ajax/getCity.php',
                    data: {
                        'country_id': country_id
                    },
                    success: function(res) {
                        if (res) {
                            let response = JSON.parse(res)
                            if (response.length > 0) {
                                for (let i = 0; i < response.length; i++) {
                                    if (selected != null && response[i]['id'] == selected) {
                                        let option = `<option value='${response[i]['id']}' selected> ${response[i]['name']} </option>`;
                                        $('#city').append(option);
                                    } else {
                                        let option = `<option value='${response[i]['id']}'> ${response[i]['name']} </option>`;
                                        $('#city').append(option);
                                    }
                                }
                            }
                        }
                    }
                })
            }

            console.log($('#country').val());

            // Get cities on bage load
            if ($('#country').val()) {
                getCities($('#country').val(), <?= isset($_SESSION['oldData']['city_id']) ? $_SESSION['oldData']['city_id'] : null ?>);
            }
            $('#country').on('change', function() {
                getCities($(this).val());
            })
        })
    </script>
</body>

</html>

<?php
if (isset($_SESSION['errorMessages'])) {
    unset($_SESSION['errorMessages']);
}
if (isset($_SESSION['oldData'])) {
    unset($_SESSION['oldData']);
}
?>