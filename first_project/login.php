<?php
// prerequisite variables
$teacher = false;
$title = 'Courses4U - Log In';
$style =
    '.badge {
            white-space: unset;
            line-height: unset;
        }';

// include head tag
include(dirname(__DIR__) . '/first_project/includes/head.php');

// check if the user logged in
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role_id'] == 1) {
        header("Location: teacher/");
        exit();
    } else {
        header("Location: student/");
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

    // Validate Email
    if (isset($_POST['email'])) {
        $email = clean($_POST['email']);
        if (empty($email)) {
            $_SESSION['errorMessages']['email'] = 'Please enter your <strong>E-mail</strong>';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['errorMessages']['email'] = 'This input must contain <strong>Valid E-mail</strong>';
            $_SESSION['oldData']['email'] = $email;
        } else {
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
        } else {
            $password = sha1($password);
        }
    } else {
        $_SESSION['errorMessages']['password'] = 'Please enter <strong>Password</strong>';
    }

    // Check Role and Credentials
    if (isset($_POST['role_id'])) {
        if ($_POST['role_id'] == 1) {
            $teacher = true;
            if (empty($_SESSION['errorMessages'])) {
                // validate as teacher
                $query = "SELECT * FROM `teachers` WHERE `email` = '$email' AND `password` = '$password'";
                $result = mysqli_query($con, $query);
                mysqli_num_rows($result);

                if (mysqli_num_rows($result) > 0) {
                    $data = mysqli_fetch_assoc($result);

                    $_SESSION['successMessages'] = 'You Logged in successfully';

                    $_SESSION['user']['id']            =    $data['id'];
                    $_SESSION['user']['first_name']    =    $data['first_name'];
                    $_SESSION['user']['last_name']     =    $data['last_name'];
                    $_SESSION['user']['email']         =    $data['email'];
                    $_SESSION['user']['profile_img']   =    $data['profile_img'];
                    $_SESSION['user']['role_id']       =    1;

                    header("Location: teacher/");

                    exit();
                } else {
                    $_SESSION['errorMessages']['teacherLogin'] = '<strong>Invalid Credentials</strong>, Please try again';
                }
            }
        } else {
            $teacher = false;
            if (empty($_SESSION['errorMessages'])) {
                // validate as student
                $query = "SELECT * FROM `students` WHERE `email` = '$email' AND `password` = '$password'";
                $result = mysqli_query($con, $query);
                mysqli_num_rows($result);
                
                if (mysqli_num_rows($result) > 0) {
                    $data = mysqli_fetch_assoc($result);
                    
                    $_SESSION['successMessages'] = 'You Logged in successfully';
                    
                    $_SESSION['user']['first_name']    =    $data['first_name'];
                    $_SESSION['user']['last_name']     =    $data['last_name'];
                    $_SESSION['user']['email']         =    $data['email'];
                    $_SESSION['user']['profile_img']   =    $data['profile_img'];
                    $_SESSION['user']['role_id']       =    2;
                    
                    header("Location: student/");
                    
                    exit();
                } else {
                    $_SESSION['errorMessages']['studentLogin'] = '<strong>Invalid Credentials</strong>, Please try again';
                }
            }
        }
    } else {
        $_SESSION['errorMessages']['studentLogin'] = 'Bad request';
        $_SESSION['errorMessages']['teacherLogin'] = 'Bad request';
    }
}

?>

<body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-color="bg-chartbg" data-col="2-columns">
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <!-- Top Bar-->
    <?php
    include(dirname(__DIR__) . '/first_project/includes/top-bar.php');
    ?>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <!-- Side Bar -->
    <div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true" data-img="theme-assets/images/backgrounds/02.jpg">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item m-auto text-center"><a class="navbar-brand" href="/nti/first_project/"><img class="brand-logo" alt="Chameleon admin logo" src="theme-assets/images/logo/logo.png" />
                        <h3 class="brand-text">Courses<span class="text-danger">4</span><span class="text-primary">U</span></h3>
                    </a></li>
                <li class="nav-item d-md-none"><a class="nav-link close-navbar"><i class="ft-x"></i></a></li>
            </ul>
        </div>
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
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tab nav-fill">
                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold <?= $teacher != true ? 'active' : '' ?>" id="student-tab" data-toggle="tab" href="#student" role="tab" aria-controls="student" aria-selected="true">Student</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link font-weight-bold <?= $teacher == true ? 'active' : '' ?>" id="teacher-tab" data-toggle="tab" href="#teacher" role="tab" aria-controls="teacher" aria-selected="true">Teacher</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="myTabContent">
                                <!-- Student Login -->
                                <div class="tab-pane fade <?= $teacher != true ? 'show active' : '' ?>" id="student" role="tabpanel" aria-labelledby="student-tab">
                                    <form class="form" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                                        <div class="form-body">
                                            <div class="row">
                                                <input type="hidden" name="role_id" value="2">

                                                <?= (isset($_SESSION['errorMessages']['studentLogin']) && $teacher != true) ? "<div class='badge badge-danger mb-1 mx-auto'>" . $_SESSION['errorMessages']['studentLogin'] . "</div>" : ''; ?>

                                                <!-- E-mail -->
                                                <div class="col-md-12 form-group text-center">
                                                    <label for="email" class="font-weight-bold">E-mail</label>
                                                    <input type="text" id="email" class="form-control" placeholder="Enter Your E-mail" name="email" value=<?= isset($_SESSION['oldData']['email']) && $teacher != true ? '"' .  $_SESSION['oldData']['email'] . '"' : "" ?>>
                                                    <?= (isset($_SESSION['errorMessages']['email']) && $teacher != true) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['email'] . "</div>" : ''; ?>
                                                </div>

                                                <!-- Password -->
                                                <div class="col-md-12 form-group text-center">
                                                    <label for="password" class="font-weight-bold">Password</label>
                                                    <input type="password" id="password" class="form-control" placeholder="Enter Your Password" name="password">
                                                    <?= (isset($_SESSION['errorMessages']['password']) && $teacher != true) ? "<div class='badge badge-danger mt-1 mw-100'>" . $_SESSION['errorMessages']['password'] . "</div>" : ''; ?>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-actions center">
                                            <button type="submit" class="btn btn-outline-primary">Log In</button>
                                        </div>
                                    </form>

                                </div>
                                <!-- Teacher Login -->
                                <div class="tab-pane fade <?= $teacher == true ? 'show active' : '' ?>" id="teacher" role="tabpanel" aria-labelledby="teacher-tab">
                                    <form class="form" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                                        <div class="form-body">
                                            <div class="row">
                                                <input type="hidden" name="role_id" value="1">

                                                <?= (isset($_SESSION['errorMessages']['teacherLogin']) && $teacher == true) ? "<div class='badge badge-danger mb-1 mx-auto'>" . $_SESSION['errorMessages']['teacherLogin'] . "</div>" : ''; ?>

                                                <!-- E-mail -->
                                                <div class="col-md-12 form-group text-center">
                                                    <label for="email" class="font-weight-bold">E-mail</label>
                                                    <input type="text" id="email" class="form-control" placeholder="Enter Your E-mail" name="email" value=<?= isset($_SESSION['oldData']['email']) && $teacher == true ? '"' .  $_SESSION['oldData']['email'] . '"' : "" ?>>
                                                    <?= (isset($_SESSION['errorMessages']['email']) && $teacher == true) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['email'] . "</div>" : ''; ?>
                                                </div>

                                                <!-- Password -->
                                                <div class="col-md-12 form-group text-center">
                                                    <label for="password" class="font-weight-bold">Password</label>
                                                    <input type="password" id="password" class="form-control" placeholder="Enter Your Password" name="password">
                                                    <?= (isset($_SESSION['errorMessages']['password']) && $teacher == true) ? "<div class='badge badge-danger mt-1 mw-100'>" . $_SESSION['errorMessages']['password'] . "</div>" : ''; ?>
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
    include(dirname(__DIR__) . '/first_project/includes/footer.php');
    ?>

    <?php
    include(dirname(__DIR__) . '/first_project/includes/scripts.php');
    ?>

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