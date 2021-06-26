<?php
$allStudents = true;
$title = 'Courses4U - Students';
include(dirname(__DIR__) . '/includes/head.php');

include(dirname(__DIR__) . '/permission/isTeacher.php');

// print_r($_SESSION['errorMessages']);
// get all students
$query = "SELECT `students`.*, `countries`.`name` As country_name, `cities`.`name` As city_name FROM `students` LEFT JOIN `countries` ON `students`.`country_id` = `countries`.`id` LEFT JOIN `cities` ON `students`.`city_id` = `cities`.`id`";
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
                    <h2 class="text-white font-weight-bold">All Students</h2>
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
                                            <th class="align-middle">Age</th>
                                            <th class="align-middle">Phone</th>
                                            <th class="align-middle">Mail</th>
                                            <th class="align-middle">Gender</th>
                                            <th class="align-middle">Address</th>
                                            <th class="align-middle"># joined Courses</th>
                                            <th class="align-middle">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($student = mysqli_fetch_assoc($results)) { ?>
                                            <tr>
                                                <td class="align-middle text-left">
                                                    <div style="min-width: max-content;">
                                                        <?= $student['profile_img'] ? "<img src='/nti/first_project/uploads/$student[profile_img]' style='width:40px;height:40px' class='rounded-circle'>" : "<img src='/nti/first_project/uploads/default_student.png' style='width:40px;height:40px' class='rounded-circle'>" ?> &nbsp;
                                                        <?= $student['first_name'] ?> <?= $student['last_name'] ?>
                                                    </div>
                                                </td>
                                                <td class="align-middle"><?= $student['age'] ? $student['age'] : 'N/A' ?></td>
                                                <td class="align-middle"><?= $student['phone'] ? $student['phone'] : 'N/A' ?></td>
                                                <td class="align-middle"><?= $student['email'] ?></td>
                                                <td class="align-middle"><?= $student['gender'] == 1 ? 'Male' : 'Female' ?></td>
                                                <td class="align-middle"><?= $student['country_name'] ?> <?= $student['city_name'] ? '/ ' . $student['city_name'] : '' ?></td>
                                                <td class="align-middle">0</td>
                                                <td class="align-middle">
                                                    <div style="min-width: max-content;">
                                                        <a href="/nti/first_project/student/edit.php?id=<?= $student['id'] ?>" class="btn btn-primary btn-sm text-white">Edit</a>
                                                        <button type="button" class="btn btn-danger btn-sm text-white" data-toggle="modal" data-keyboard="false" data-target="#deleteTeacher" data-id="<?= $student['id'] ?>" data-name="<?= $student['first_name'] ?> <?= $student['last_name'] ?>">
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
            modal.find('#deletingButton').attr('href', '/nti/first_project/student/delete.php?id=' + id)
            modal.find('#studentName').text(name)
        })

        // Add Toastr
        <?php
        if (isset($_SESSION['successMessages'])) {
        ?>
            toastr.success('<?= $_SESSION['successMessages'] ?>')
        <?php
            unset($_SESSION['successMessages']);
        }

        if (isset($_SESSION['errorMessage']['studentNotFound'])) {
            // print_r($_SESSION['errorMessage']['studentNotFound']);
        ?>
            toastr.error("<?= $_SESSION['errorMessage']['studentNotFound'] ?>")
        <?php
            unset($_SESSION['errorMessage']['studentNotFound']);
        }
        ?>
    </script>
</body>

</html>