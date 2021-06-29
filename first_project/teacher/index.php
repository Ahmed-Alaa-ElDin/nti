<?php
$title = 'Courses4U - Dashboard';
include(dirname(__DIR__) . '/includes/head.php');

include(dirname(__DIR__) . '/permission/isTeacher.php');

// get all teachers
$subscriptions = [];
for ($i = 0; $i <= 5; $i++) {
    $year = date('Y', strtotime("-$i month"));
    $month = date('m', strtotime("-$i month"));
    $monthM = date('M', strtotime("-$i month"));
    // get count subscriptions
    // $query = "SELECT MONTH(`join_date`) FROM `subscriptions`";
    $query = "SELECT COUNT(*) AS `count` FROM `subscriptions` WHERE YEAR(`join_date`) = '$year' AND MONTH(`join_date`) = $month GROUP BY YEAR(`join_date`),MONTH(`join_date`)";
    $results = mysqli_query($con, $query);
    print_r(mysqli_error($con));
    $date = '"' . $monthM . ' ' . $year . '"';
    if (mysqli_num_rows($results)) {
        $count = mysqli_fetch_assoc($results)['count'];
    } else {
        $count =  '0';
    }
    $subscriptionDates[] = $date;
    $subscriptionCount[] = $count;
}
print_r($subscriptionDates);
print_r($subscriptionCount);

// exit();
?>

<body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-color="bg-chartbg" data-col="2-columns">
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <!-- Top Bar-->
    <?php
    include(dirname(__DIR__) . '/includes/top-bar.php');
    ?>
    <!-- ////////////////////////////////////////////////////////////////////////////// -->

    <!-- Side Bar  -->
    <?php
    include(dirname(__DIR__) . '/includes/side-bar.php');
    ?>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-wrapper-before"></div>
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="mainCharts mt-5">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card pull-up bg-white">
                                <div class="card-content">
                                    <h5 class="text-muted danger position-absolute p-1">Progress Stats</h5>
                                    <div>
                                        <i class="ft-pie-chart danger font-large-1 float-right p-1"></i>
                                    </div>
                                    <div>
                                        <div class="ct-chart"></div>
                                    </div>
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
    include(dirname(__DIR__) . '/includes/footer.php');
    ?>

    <?php
    include(dirname(__DIR__) . '/includes/scripts.php');
    ?>

    <script>
        // set datatable
        $(document).ready(function() {
            $('#myTable').DataTable();
        });

        // Add Toastr
        <?php
        if (isset($_SESSION['successMessages'])) {
        ?>
            toastr.success('<?= $_SESSION['successMessages'] ?>')
        <?php
            unset($_SESSION['successMessages']);
        }
        ?>

        var data = {
            labels: [
                <?php echo implode(',' , $subscriptionDates) ?>            
            ],
            series: [
                [<?php echo implode(',' , $subscriptionCount) ?>]
            ],
            ticks: ['One', 'Two', 'Three'],
        };

        new Chartist.Bar('.ct-chart', data);
    </script>
</body>

</html>