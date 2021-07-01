<?php
$cart = true;
$allStudents = true;
$title = 'Courses4U - Students';
include('../../includes/head.php');

// Find out how many items are in the table
$query = "SELECT COUNT(*) AS `count` FROM `courses`";
$result = mysqli_query($con, $query);

if (!mysqli_error($con)) {
    $total = mysqli_fetch_assoc($result)['count'];
}

// How many items to list per page
$limit = 8;

// How many pages will there be
$pages = ceil($total / $limit);

// What page are we currently on?
$page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
    'options' => array(
        'default'   => 1,
        'min_range' => 1,
    ),
)));

// Calculate the offset for the query
$offset = ($page - 1)  * $limit;

// Some information to display to the user
$start = $offset + 1;
$end = min(($offset + $limit), $total);


// Get All Courses
$query = "SELECT `courses`.*, `categories`.`name` AS `category`, `teachers`.`first_name`, `teachers`.`last_name`, `teachers`.`profile_img` 
,`avg`.`avg_rating` AS `avg_rating`
FROM `courses` 
LEFT JOIN `categories` ON `courses`.`category_id` = `categories`.`id` 
LEFT JOIN `teachers` ON `courses`.`created_by` = `teachers`.`id` 
LEFT JOIN (SELECT `course_id`, AVG(`rating`) AS `avg_rating`, COUNT(`rating`) AS `num_rating` FROM `reviews` GROUP BY `course_id`) AS `avg` ON `courses`.`id` = `avg`.`course_id`
ORDER BY `created_at` DESC 
LIMIT $limit OFFSET $offset";
$newCoursesResults = mysqli_query($con, $query);

?>

<body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-color="bg-chartbg" data-col="2-columns">
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <!-- Top Bar-->
    <?php
    include('../../includes/top-bar.php');
    ?>
    <!-- ////////////////////////////////////////////////////////////////////////////// -->

    <!-- Side Bar  -->
    <?php
    include('../../includes/side-bar.php');
    ?>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-wrapper-before"></div>
            <div class="content-header row">
                <div class="col-12 text-center mt-2">
                    <h1 class="text-white font-weight-bold">All Courses</h1>
                </div>
            </div>
            <div class="content-body mt-5">
                <div class="newCourses ">
                    <div class="row ">
                        <div class="col-12">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center mt-0 mb-4">
                                    <?=
                                    ($page > 1) ? '<li class="page-item"><a class="page-link" href="?page=1" title="First page">First Page</a></li> <li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '" title="Previous page">Previous</a></li>' : '<li class="page-link bg-primary text-white"><span class="disabled">First Page</span></li> <li class="page-item  bg-primary text-white"><span class="page-link" class="disabled">Previous</span></li>';
                                    ?>

                                    <?php
                                    for ($i=1; $i <= $pages; $i++) { 
                                        echo "<li class='page-item'><a class='page-link' href='?page=$i'>$i</a></li>";
                                    }
                                    ?>

                                    <?=
                                    ($page < $pages) ? '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '" title="Next page">Next</a></li><li class="page-item"><a class="page-link" href="?page='.$pages.'" title="Last page">Last Page</a></li> ' : '<li class="page-item  bg-primary text-white"><span class="page-link" class="disabled">Next</span></li> <li class="page-link  bg-primary text-white" class="page-item"><span class="disabled">Last Page</span></li>';
                                    ?>
                                </ul>
                            </nav>
                        </div>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <!-- delete modal -->
    <div class="modal fade text-left" id="deleteTeacher" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel3" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title text-white" id="basicModalLabel3">Delete Confirmation</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div>Are you sure, you want to delete
                        <span id="studentName" class="font-weight-bold"></span>
                        .
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <a href="/nti/first_project/student/delete.php?id=<?= $student['id'] ?>" id="deletingButton" class="btn btn-danger text-white">Delete</a>

                    <!-- <button type="button" class="btn btn-danger">Save</button> -->
                </div>
            </div>
        </div>
    </div>
    <!-- delete modal -->

    <?php
    include('../../includes/footer.php');
    ?>

    <?php
    include('../../includes/scripts.php');
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
                url: '../../permission/addToCart.php',
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