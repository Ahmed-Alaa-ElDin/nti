<?php
if (isset($_SESSION['user']) && isset($cart)) {
    $query = "SELECT COUNT(*) AS `Count` FROM `subscriptions` WHERE `student_id` = " . $_SESSION['user']['id'] . " AND `status_id` = 1";
    $result = mysqli_query($con, $query);
    $cartCount = mysqli_fetch_assoc($result);

    $query = "SELECT COUNT(*) AS `Count` FROM `subscriptions` WHERE `student_id` = " . $_SESSION['user']['id'] . " AND `status_id` = 2";
    $result = mysqli_query($con, $query);
    $coursesCount = mysqli_fetch_assoc($result);

    // print_r($cartCount['Count']);
}
?>

<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="collapse navbar-collapse show" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                    <!-- <li class="nav-item d-block d-md-none"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li> -->
                    <!-- <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li> -->
                    <?php
                    if (isset($_SESSION['user'])) {
                    ?>
                        <!-- <li class="nav-item dropdown navbar-search"><a class="nav-link dropdown-toggle hide" data-toggle="dropdown" href="#"><i class="ficon ft-search"></i></a>
                            <ul class="dropdown-menu">
                                <li class="arrow_box">
                                    <form>
                                        <div class="input-group search-box">
                                            <div class="position-relative has-icon-right full-width">
                                                <input class="form-control" id="search" type="text" placeholder="Search here...">
                                                <div class="form-control-position navbar-search-close"><i class="ft-x"> </i></div>
                                            </div>
                                        </div>
                                    </form>
                                </li>
                            </ul>
                        </li> -->
                    <?php
                    }
                    ?>
                </ul>
                <!-- <ul class="nav navbar-nav float-right">
                    <li class="dropdown dropdown-language nav-item"><a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-us"></i><span class="selected-language"></span></a>
                        <div class="dropdown-menu" aria-labelledby="dropdown-flag">
                            <div class="arrow_box"><a class="dropdown-item" href="#"><i class="flag-icon flag-icon-us"></i> English</a>
                                <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-cn"></i> Chinese</a>
                                <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-ru"></i> Russian</a>
                                <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-fr"></i> French</a>
                                <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-es"></i> Spanish</a>
                            </div>
                        </div>
                    </li>
                </ul> -->
                <ul class="nav navbar-nav float-right">
                    <?php
                    if (isset($_SESSION['user']) && isset($cart)) {
                    ?>
                        <li class="dropdown dropdown-notification nav-item mr-2">
                            <a class="nav-link nav-link-label" href="/nti/first_project/student/myCart.php" title="My Cart">
                                <i class="ficon ft-shopping-cart"> </i>
                                <span id="myCart" class="badge badge-danger position-absolute" style="font-size: 0.75em;"><?= $cartCount['Count'] ?></span>
                            </a>
                        </li>
                    <?php
                    }
                    ?>

                    <?php
                    if (isset($_SESSION['user']) && isset($cart)) {
                    ?>
                        <li class="dropdown dropdown-notification nav-item mr-2">
                            <a class="nav-link nav-link-label" href="/nti/first_project/student/myCourses.php" title="My Courses">
                                <i class="ficon ft-book"> </i>
                                <span id="myCart" class="badge badge-success text-dark position-absolute" style="font-size: 0.75em;"><?= $coursesCount['Count'] ?></span>
                            </a>
                        </li>
                    <?php
                    }
                    ?>

                    <?php
                    if (isset($_SESSION['user'])) {
                    ?>
                        <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"> <span class="avatar avatar-online"><img src="/nti/first_project/uploads/<?= $_SESSION['user']['profile_img'] ?>" alt="avatar"><i></i></span></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="arrow_box_right">
                                    <div class="dropdown-item overflow-hidden pr-2" href="#">
                                        <span class="avatar avatar-online">
                                            <img src="/nti/first_project/uploads/<?= $_SESSION['user']['profile_img'] ?>" alt="avatar">
                                            <span class="user-name text-bold-700 ml-1"><?= $_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name'] ?></span>
                                        </span>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="/nti/first_project/teacher/edit.php?id=<?= $_SESSION['user']['id'] ?>"><i class="ft-user"></i> Edit Profile</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="/nti/first_project/logout.php"><i class="ft-power"></i> Logout</a>
                                </div>
                            </div>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="dropdown dropdown-user nav-item text-white font-weight-bold">
                            <div class="d-flex items-center" style="height: 70px;">
                                <div class="justify-content-center align-self-center">
                                    <a href="login.php" class="text-white font-weight-bold">Login</a> | <a href="register.php" class="text-white font-weight-bold ">Register</a>
                                </div>
                            </div>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</nav>