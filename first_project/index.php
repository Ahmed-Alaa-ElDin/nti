<?php
$title = 'Courses4U - Dashboard';
include(dirname(__DIR__) . '/first_project/includes/head.php');
?>

<body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-color="bg-chartbg" data-col="2-columns">
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <!-- Top Bar-->
    <?php
    include(dirname(__DIR__) . '/first_project/includes/top-bar.php');
    ?>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <!-- Side Bar -->
    <?php
    include(dirname(__DIR__) . '/first_project/includes/side-bar.php');
    ?>
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
    include(dirname(__DIR__) . '/first_project/includes/footer.php');
    ?>

    <?php
    include(dirname(__DIR__) . '/first_project/includes/scripts.php');
    ?>

    <script>
        // Add Toastr
        <?php
        if (isset($_SESSION['successMessages'])) {
        ?>
            toastr.success('<?= $_SESSION['successMessages'] ?>')
        <?php
            unset($_SESSION['successMessages']);
        }
        ?>
    </script>

</body>

</html>