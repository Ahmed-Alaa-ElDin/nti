<?php
$allCourses = true;
$title = 'Courses4U - Courses';
include(dirname(__DIR__) . '/includes/head.php');

include(dirname(__DIR__) . '/permission/isTeacher.php');

// print_r($_SESSION['errorMessages']);
// get all courses
$query = "SELECT `courses`.*, 
`categories`.`name` AS `category`, 
`teachers`.`first_name` AS `teacher_first_name`, 
`teachers`.`last_name` AS `teacher_last_name` , 
`student`.`count_student` AS `count_student`,
`avg`.`avg_rating` AS `avg_rating`
FROM `courses` 
LEFT JOIN `categories` ON `courses`.`category_id` = `categories`.`id` 
LEFT JOIN `teachers` ON `courses`.`created_by` = `teachers`.`id` 
LEFT JOIN (SELECT `course_id`, COUNT(`student_id`) AS `count_student` FROM `course_student` GROUP BY `course_id`) AS `student` ON `courses`.`id` = `student`.`course_id`
LEFT JOIN (SELECT `course_id`, AVG(`rating`) AS `avg_rating` FROM `reviews` GROUP BY `course_id`) AS `avg` ON `courses`.`id` = `avg`.`course_id`";
$results = mysqli_query($con, $query);
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
                <div class="col-12 text-center my-2">
                    <h2 class="text-white font-weight-bold">All Courses</h2>
                </div>
            </div>
            <div class="content-body">
                <div class="card m-auto">
                    <div class="card-content pt-2">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="myTable" class="w-100 text-center table table-striped table-bordered">
                                    <thead class="">
                                        <tr>
                                            <th class="align-middle">Name</th>
                                            <th class="align-middle">Category</th>
                                            <th class="align-middle">Price <small class="text-danger font-weight-bold">(EGP)</small></th>
                                            <th class="align-middle">Duration</th>
                                            <th class="align-middle">Teacher</th>
                                            <th class="align-middle"># Students</th>
                                            <th class="align-middle">Avg. Rate</th>
                                            <th class="align-middle">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($course = mysqli_fetch_assoc($results)) { ?>
                                            <tr>
                                                <td class="align-middle text-left">
                                                    <div style="min-width: max-content;">
                                                        <?= $course['course_img'] ? "<img src='/nti/first_project/uploads/$course[course_img]' style='width:40px;height:40px' class='rounded-circle'>" : "<img src='/nti/first_project/uploads/default_courses.png' style='width:40px;height:40px' class='rounded-circle'>" ?> &nbsp;
                                                        <?= $course['name'] ?>
                                                    </div>
                                                </td>
                                                <td class="align-middle"><?= $course['category'] ? $course['category'] : 'N/A' ?></td>
                                                <td class="align-middle"><?= $course['price'] ? $course['price'] : '0' ?></td>
                                                <td class="align-middle"><?= $course['hours'] ? $course['hours'] : '00' ?> : <?= $course['minutes'] ? $course['minutes'] : '00' ?></td>
                                                <td class="align-middle">
                                                    <?= $course['teacher_first_name'] ? $course['teacher_first_name'] : 'N/A' ?>
                                                    <?= $course['teacher_last_name'] ? " " . $course['teacher_last_name'] : '' ?>
                                                </td>
                                                <td class="align-middle"><?= $course['count_student'] ? $course['count_student'] : 0 ?></td>
                                                <td class="align-middle"><?= $course['avg_rating'] ? number_format($course['avg_rating'],2) : '0.00' ?></td>
                                                <td class="align-middle">
                                                    <div style="min-width: max-content;">
                                                        <a href="/nti/first_project/course/edit.php?id=<?= $course['id'] ?>" class="btn btn-primary btn-sm text-white">Edit</a>
                                                        <button type="button" class="btn btn-danger btn-sm text-white" data-toggle="modal" data-keyboard="false" data-target="#deleteTeacher" data-id="<?= $course['id'] ?>" data-name="<?= $course['name'] ?> ">
                                                            Delete
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
                        <span id="courseName" class="font-weight-bold"></span>
                        .
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <a href="/nti/first_project/course/delete.php?id=<?= $course['id'] ?>" id="deletingButton" class="btn btn-danger text-white">Delete</a>
                </div>
            </div>
        </div>
    </div>
    <!-- delete modal -->

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

        // change modal content when triggered
        $('#deleteTeacher').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var modal = $(this)
            modal.find('#deletingButton').attr('href', '/nti/first_project/course/delete.php?id=' + id)
            modal.find('#courseName').text(name)
        })

        // Add Toastr
        <?php
        if (isset($_SESSION['successMessages'])) {
        ?>
            toastr.success('<?= $_SESSION['successMessages'] ?>')
        <?php
            unset($_SESSION['successMessages']);
        }

        if (isset($_SESSION['errorMessage']['courseNotFound'])) {
        ?>
            toastr.error("<?= $_SESSION['errorMessage']['courseNotFound'] ?>")
        <?php
            unset($_SESSION['errorMessage']['courseNotFound']);
        }
        ?>
    </script>
</body>

</html>