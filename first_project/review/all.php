<?php
$allReviews = true;
$title = 'Courses4U - Reviews';
include(dirname(__DIR__) . '/includes/head.php');

include(dirname(__DIR__) . '/permission/isTeacher.php');

// get all reviews
$query = "SELECT `reviews`.*, `courses`.`name`, `students`.`first_name` , `students`.`last_name` FROM `reviews` 
LEFT JOIN `courses` ON `courses`.`id` = `reviews`.`course_id` 
LEFT JOIN `students` ON `students`.`id` = `reviews`.`student_id`";
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
                    <h2 class="text-white font-weight-bold">All Reviews</h2>
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
                                            <th class="align-middle">Student</th>
                                            <th class="align-middle">Rating</th>
                                            <th class="align-middle">Feedback</th>
                                            <th class="align-middle">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($review = mysqli_fetch_assoc($results)) { ?>
                                            <tr>
                                                <td class="align-middle"><?= $review['name'] ?></td>
                                                <td class="align-middle"><?= $review['first_name'] . " " . $review['last_name'] ?></td>
                                                <td class="align-middle"><?= $review['rating'] ?></td>
                                                <td class="align-middle"><?= htmlspecialchars_decode($review['review']) ?></td>
                                                <td class="align-middle">
                                                    <div style="min-width: max-content;">
                                                        <a href="/nti/first_project/review/edit.php?id=<?= $review['id'] ?>" class="btn btn-primary btn-sm text-white">Edit</a>
                                                        <button type="button" class="btn btn-danger btn-sm text-white" data-toggle="modal" data-keyboard="false" data-target="#deleteTeacher" data-id="<?= $review['id'] ?>" >
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
                    <div>Are you sure, you want to delete this review
                        <span id="reviewName" class="font-weight-bold"></span>
                        .
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <a href="/nti/first_project/review/delete.php?id=<?= $review['id'] ?>" id="deletingButton" class="btn btn-danger text-white">Delete</a>
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
            modal.find('#deletingButton').attr('href', '/nti/first_project/review/delete.php?id=' + id)
        })

        // Add Toastr
        <?php
        if (isset($_SESSION['successMessages'])) {
        ?>
            toastr.success('<?= $_SESSION['successMessages'] ?>')
        <?php
            unset($_SESSION['successMessages']);
        }

        if (isset($_SESSION['errorMessage']['reviewNotFound'])) {
        ?>
            toastr.error("<?= $_SESSION['errorMessage']['reviewNotFound'] ?>")
        <?php
            unset($_SESSION['errorMessage']['reviewNotFound']);
        }
        ?>
    </script>
</body>

</html>