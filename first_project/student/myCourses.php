<?php
$title = 'Courses4U - My Cart';
include(dirname(__DIR__) . '/includes/head.php');

// get all students
$query = "SELECT `subscriptions`.*, `courses`.`name`, `courses`.`course_img`, `statuses`.`name` AS `status_name`
            FROM `subscriptions` 
            LEFT JOIN `courses` ON `subscriptions`.`course_id` = `courses`.`id`
            LEFT JOIN `students` ON `subscriptions`.`student_id` = `students`.`id`
            LEFT JOIN `statuses` ON `subscriptions`.`status_id` = `statuses`.`id`
            WHERE `subscriptions`.`student_id` = " . $_SESSION['user']['id'] . "
            AND  `subscriptions`.`status_id` = 2
            ";
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
                    <h2 class="text-white font-weight-bold">All Subscriptions</h2>
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
                                            <th class="align-middle">Course</th>
                                            <th class="align-middle">Date of Join</th>
                                            <th class="align-middle">Expiry Date</th>
                                            <th class="align-middle">Status</th>
                                            <th class="align-middle">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($subscription = mysqli_fetch_assoc($results)) { ?>
                                            <tr>
                                                <td class="align-middle text-left">
                                                    <div style="min-width: max-content;">
                                                        <?= $subscription['course_img'] ? "<img src='/nti/first_project/uploads/$subscription[course_img]' style='width:40px;height:40px' class='rounded-circle'>" : "<img src='/nti/first_project/uploads/default_course.png' style='width:40px;height:40px' class='rounded-circle'>" ?> &nbsp;
                                                        <?= $subscription['name'] ?>
                                                    </div>
                                                </td>
                                                <td class="align-middle"><?= $subscription['join_date'] ?></td>
                                                <td class="align-middle"><?= $subscription['expiry_date'] ? $subscription['expiry_date'] : 'No Expiry Date' ?></td>
                                                <td class="align-middle"><?= $subscription['status_name'] ?></td>
                                                <td class="align-middle">
                                                    <div style="min-width: max-content;">
                                                        <button type="button" class="btn btn-danger btn-sm text-white" data-toggle="modal" data-keyboard="false" data-target="#deleteTeacher" data-id="<?= $subscription['id'] ?>">
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
                    <div>Are you sure, you want to delete this course from your courses ??</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <a href="/nti/first_project/student/deleteCourse.php?id=<?= $subscription['id'] ?>" id="deletingButton" class="btn btn-danger text-white">Delete</a>
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
            var modal = $(this)
            modal.find('#deletingButton').attr('href', '/nti/first_project/student/deleteCourse.php?id=' + id);
        })

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
    </script>
</body>

</html>