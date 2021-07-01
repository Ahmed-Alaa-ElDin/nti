<?php
$title = 'Courses4U - Dashboard';
$cart =true;
include(dirname(__DIR__) . '/first_project/includes/head.php');

// Get New Courses
$query = "SELECT `courses`.*, `categories`.`name` AS `category`, `teachers`.`first_name`, `teachers`.`last_name`, `teachers`.`profile_img` 
,`avg`.`avg_rating` AS `avg_rating`
FROM `courses` 
LEFT JOIN `categories` ON `courses`.`category_id` = `categories`.`id` 
LEFT JOIN `teachers` ON `courses`.`created_by` = `teachers`.`id` 
LEFT JOIN (SELECT `course_id`, AVG(`rating`) AS `avg_rating`, COUNT(`rating`) AS `num_rating` FROM `reviews` GROUP BY `course_id`) AS `avg` ON `courses`.`id` = `avg`.`course_id`
ORDER BY `created_at` DESC 
LIMIT 7";
$newCoursesResults = mysqli_query($con, $query);

// print_r(mysqli_error($con));
// print_r(mysqli_fetch_all($newCoursesResults,MYSQLI_ASSOC));
// exit();

$query = "SELECT `courses`.*, `categories`.`name` AS `category`, `teachers`.`first_name`, `teachers`.`last_name`, `teachers`.`profile_img` 
,`avg`.`avg_rating` AS `avg_rating`
FROM `courses` 
LEFT JOIN `categories` ON `courses`.`category_id` = `categories`.`id` 
LEFT JOIN `teachers` ON `courses`.`created_by` = `teachers`.`id` 
LEFT JOIN (SELECT `course_id`, AVG(`rating`) AS `avg_rating`, COUNT(`rating`) AS `num_rating` FROM `reviews` GROUP BY `course_id`) AS `avg` ON `courses`.`id` = `avg`.`course_id`
ORDER BY `avg_rating` DESC 
LIMIT 7";
$topCoursesResults = mysqli_query($con, $query);
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
            <div class="content-wrapper-before"></div>
            <div class="content-header row">
                <div class="col-12">
                    <h1 class="text-white text-center mt-3 font-weight-bold">New Courses</h1>
                </div>
            </div>
            <div class="content-body mt-5">
                <div class="newCourses ">
                    <div class="row ">
                        <?php
                        if (mysqli_num_rows($newCoursesResults) > 0) {
                            while ($course = mysqli_fetch_assoc($newCoursesResults)) {
                        ?>
                                <div class="col-md-3">
                                    <div class="card pull-up bg-white rounded overflow-hidden">
                                        <img class="card-img-top rounded" src='/nti/first_project/uploads/<?= $course['course_img'] ?>'>
                                        <div class="card-body">
                                            <!-- Course Name -->
                                            <h5 class="card-title font-weight-bold mb-1"><?= $course['name'] ?></h5>
                                            <!-- Author -->
                                            <div class="mb-1">
                                                <span><img src='/nti/first_project/uploads/<?= $course['profile_img'] ?>' width="30" height="30" class="rounded"> &nbsp; <?= $course['first_name'] ?> <?= $course['last_name'] ?></span>
                                                <span class="pull-right"><span class="text-danger font-weight-bold h6"><?= $course['price'] ?></span> <small>EGP</small></span>
                                            </div>
                                            <!-- Category -->
                                            <h6><?= $course['category'] ?></h6>
                                            <!-- review -->
                                            <div>
                                                <div class="rating mx-auto my-1" data-score="<?= $course['avg_rating'] ?>" style="max-width: max-content;"></div>
                                            </div>
                                            <!-- Duration -->
                                            <p class="card-text"> <?= $course['hours'] ?>.<?= number_format($course['minutes'] * 100 / 60, 0) ?> total hours</p>
                                            <!-- Buttons -->
                                            <div class="text-center">
                                                <button class="addToCart btn btn-primary mx-auto" data-course-id="<?= $course['id'] ?>">Add to Cart</button>
                                            </div>
                                        </div>
                                        <div class="card-footer text-center">
                                            <!-- Craetion Date -->
                                            <span class="text-muted">Created on : <?= date('d F Y', strtotime($course['created_at'])) ?></span>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                        <div class="col-md-3">
                            <div class="card pull-up bg-white rounded overflow-hidden">
                                <img class="card-img-top rounded" src='/nti/first_project/uploads/placeholder_course.png'>
                                <div class="card-body">
                                    <a href="#" class="btn btn-secondary d-block">See All Courses</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>


    </div>

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-wrapper-before" style="background-color: #27ae60 !important;"></div>
            <div class="content-header row">
                <div class="col-12">
                    <h1 class="text-white text-center mt-3 font-weight-bold text-white">Top Rated Courses</h1>
                </div>
            </div>
            <div class="content-body mt-5">
                <div class="newCourses ">
                    <div class="row ">
                        <?php
                        if (mysqli_num_rows($topCoursesResults) > 0) {
                            while ($course = mysqli_fetch_assoc($topCoursesResults)) {
                        ?>
                                <div class="col-md-3">
                                    <div class="card pull-up bg-white rounded overflow-hidden">
                                        <img class="card-img-top rounded" src='/nti/first_project/uploads/<?= $course['course_img'] ?>'>
                                        <div class="card-body">
                                            <!-- Course Name -->
                                            <h5 class="card-title font-weight-bold mb-1"><?= $course['name'] ?></h5>
                                            <!-- Author -->
                                            <div class="mb-1">
                                                <span><img src='/nti/first_project/uploads/<?= $course['profile_img'] ?>' width="30" height="30" class="rounded"> &nbsp; <?= $course['first_name'] ?> <?= $course['last_name'] ?></span>
                                                <span class="pull-right"><span class="text-danger font-weight-bold h6"><?= $course['price'] ?></span> <small>EGP</small></span>
                                            </div>
                                            <!-- Category -->
                                            <h6><?= $course['category'] ?></h6>
                                            <!-- review -->
                                            <div>
                                                <div class="rating mx-auto my-1" data-score="<?= $course['avg_rating'] ?>" style="max-width: max-content;"></div>
                                            </div>
                                            <!-- Duration -->
                                            <p class="card-text"> <?= $course['hours'] ?>.<?= number_format($course['minutes'] * 100 / 60, 0) ?> total hours</p>
                                            <!-- Buttons -->
                                            <div class="text-center">
                                                <button class="addToCart btn btn-success mx-auto" data-course-id="<?= $course['id'] ?>" style="background-color: #27ae60 !important">Add to Cart</button>
                                            </div>
                                        </div>
                                        <div class="card-footer text-center">
                                            <!-- Craetion Date -->
                                            <span class="text-muted">Created on : <?= date('d F Y', strtotime($course['created_at'])) ?></span>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                        <div class="col-md-3">
                            <div class="card pull-up bg-white rounded overflow-hidden">
                                <img class="card-img-top rounded" src='/nti/first_project/uploads/placeholder_course.png'>
                                <div class="card-body">
                                    <a href="#" class="btn btn-secondary d-block">See All Courses</a>
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

    <script>
        // Add Toastr
        <?php
        if (isset($_SESSION['successMessages'])) {
        ?>
            toastr.success('<?= $_SESSION['successMessages'] ?>')
        <?php
            unset($_SESSION['successMessages']);
        }

        if (isset($_SESSION['errorMessage']['subscriptionNotFound'])) {
        ?>
            toastr.error("<?= $_SESSION['errorMessage']['subscriptionNotFound'] ?>")
        <?php
            unset($_SESSION['errorMessage']['subscriptionNotFound']);
        }
        ?>

        $('.rating').raty({
            readOnly: true
        });

        $('.addToCart').on('click', function() {
            var courseId = $(this).attr('data-course-id');
            $.ajax({
                url: 'permission/addToCart.php',
                method: 'post',
                data: {
                    'course_id' : courseId
                },
                success: function(res) {
                    if (res) {
                        if (res == 'log') {
                            window.location.href = 'login.php';
                        } else if (res == 'added') {
                            let count = parseInt($('#myCart').text()) + 1;
                            $('#myCart').text(count);
                            toastr.success('Congratulations, Course Added to Cart');
                        }
                    }
                }
            })
        })
    </script>

</body>

</html>