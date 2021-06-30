<?php
$title = 'Courses4U - Dashboard';

include(dirname(__DIR__) . '/includes/head.php');

include(dirname(__DIR__) . '/permission/isTeacher.php');

for ($i = 0; $i <= 5; $i++) {
    $year = date('Y', strtotime("-$i month"));
    $month = date('m', strtotime("-$i month"));
    $monthM = date('M', strtotime("-$i month"));

    $date = '"' . $monthM . ' ' . $year . '"';
    $dates[] = $date;

    $query = "SELECT COUNT(*) AS `count` FROM `subscriptions` WHERE YEAR(`join_date`) = '$year' AND MONTH(`join_date`) = $month GROUP BY YEAR(`join_date`),MONTH(`join_date`)";
    $resultsSubscriptions = mysqli_query($con, $query);

    // get count subscriptions    
    if (mysqli_num_rows($resultsSubscriptions)) {
        $count = mysqli_fetch_assoc($resultsSubscriptions)['count'];
    } else {
        $count =  '0';
    }
    $subscriptionCount[] = $count;

    // get count Students
    $query = "SELECT COUNT(*) AS `count` FROM `students` WHERE YEAR(`created_at`) = '$year' AND MONTH(`created_at`) = $month GROUP BY YEAR(`created_at`),MONTH(`created_at`)";
    $resultsStudents = mysqli_query($con, $query);

    if (mysqli_num_rows($resultsStudents)) {
        $count = mysqli_fetch_assoc($resultsStudents)['count'];
    } else {
        $count =  '0';
    }
    $studentCount[] = $count;

    // get count Courses
    $query = "SELECT COUNT(*) AS `count` FROM `courses` WHERE YEAR(`created_at`) = '$year' AND MONTH(`created_at`) = $month GROUP BY YEAR(`created_at`),MONTH(`created_at`)";
    $resultsCourses = mysqli_query($con, $query);

    if (mysqli_num_rows($resultsCourses)) {
        $count = mysqli_fetch_assoc($resultsCourses)['count'];
    } else {
        $count =  '0';
    }
    $courseCount[] = $count;
}
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
            <div class="content-wrapper-before">
            </div>
            <div class="content-header row">
                <div class="col-12">
                    <h1 class="text-white text-center mt-3 font-weight-bold">Teacher Dashboard</h1>
                </div>
            </div>
            <div class="content-body mt-4">
                <div class="mainCharts">
                    <div class="row">
                        <!-- New Subscription Chart -->
                        <div class="col-md-4">
                            <div class="card pull-up bg-white">
                                <div class="card-content">
                                    <h5 class="text-muted danger position-absolute p-1">New Subscriptions</h5>
                                    <div>
                                        <i class="ft-trending-up danger font-large-1 float-right p-1"></i>
                                    </div>
                                    <div>
                                        <canvas id="newSubChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- New Students Chart -->
                        <div class="col-md-4">
                            <div class="card pull-up bg-white">
                                <div class="card-content">
                                    <h5 class="text-muted primary position-absolute p-1">New Students</h5>
                                    <div>
                                        <i class="ft-user primary font-large-1 float-right p-1"></i>
                                    </div>
                                    <div>
                                        <canvas id="newStudentChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- New Courses Chart -->
                        <div class="col-md-4">
                            <div class="card pull-up bg-white">
                                <div class="card-content">
                                    <h5 class="text-muted warning position-absolute p-1">New Courses</h5>
                                    <div>
                                        <i class="ft-book warning font-large-1 float-right p-1"></i>
                                    </div>
                                    <div>
                                        <canvas id="newCourseChart"></canvas>
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

        // charts options 
        var options = {
            scales: {
                responsive: true,
                y: {
                    beginAtZero: true
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false,
                    }

                }
            }
        }


        // New Subscription Chart
        var ctx = $('#newSubChart');

        var newSubChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [<?= implode(',', $dates) ?>],
                datasets: [{
                    label: '# New Subscriptions',
                    data: [<?= implode(',', $subscriptionCount) ?>],
                    backgroundColor: ['#fa626baa', '#fa626baa', '#fa626baa', '#fa626baa', '#fa626baa', '#fa626baa'],
                    borderColor: ['#fa626b', '#fa626b', '#fa626b', '#fa626b', '#fa626b', '#fa626b', ],
                    borderWidth: 2,
                }]
            },
            options: options
        });

        // New Students Chart
        var ctx = $('#newStudentChart');

        var newSubChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [<?= implode(',', $dates) ?>],
                datasets: [{
                    label: '# New Students',
                    data: [<?= implode(',', $studentCount) ?>],
                    backgroundColor: ['#6967ceaa', '#6967ceaa', '#6967ceaa', '#6967ceaa', '#6967ceaa', '#6967ceaa'],
                    borderColor: ['#6967ce', '#6967ce', '#6967ce', '#6967ce', '#6967ce', '#6967ce'],
                    borderWidth: 2,
                }]
            },
            options: options
        });

        // New Courses Chart
        var ctx = $('#newCourseChart');

        var newSubChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [<?= implode(',', $dates) ?>],
                datasets: [{
                    label: '# New Courses',
                    data: [<?= implode(',', $courseCount) ?>],
                    backgroundColor: ['#fdb901aa', '#fdb901aa', '#fdb901aa', '#fdb901aa', '#fdb901aa', '#fdb901aa'],
                    borderColor: ['#fdb901', '#fdb901', '#fdb901', '#fdb901', '#fdb901', '#fdb901'],
                    borderWidth: 2,
                }]
            },
            options: options
        });
    </script>
</body>

</html>