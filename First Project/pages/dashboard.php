<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    <title>Courses4U - Dashboard</title>
    <?php
    include('../includes/head.php');
    ?>
</head>

<!-- php codes -->
<?php
if (!isset($_SESSION['user']['role_id']) || $_SESSION['user']['role_id'] != 1) {
    header("Location: home.php");
    exit();
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
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item"><a href="dashboard.html"><i class="ft-pie-chart"></i><span class="menu-title" data-i18n="">Dashboard</span></a>
                </li>
                <li class="nav-item"><a href="charts.html"><i class="ft-home"></i><span class="menu-title" data-i18n="">Home</span></a>
                </li>
            </ul>
        </div>
        <div class="navigation-background"></div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <div class="app-content content">
        <div class="content-wrapper">
            <!-- <div class="content-wrapper-before"></div> -->
            <div class="content-header row">
            </div>
            <div class="content-body">

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
</body>

</html>