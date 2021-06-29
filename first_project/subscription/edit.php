<?php
// prerequisite variables
$title = 'Courses4U - Edit Course';

$style =
    '.badge {
    white-space: unset;
    line-height: unset;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

input[type=number] {
  -moz-appearance: textfield;
}';

include(dirname(__DIR__) . '/includes/head.php');
include(dirname(__DIR__) . '/permission/isTeacher.php');

// Declaration of cleaning function
function clean($request)
{
    $request = htmlspecialchars($request);
    $request = trim($request);
    $request = stripcslashes($request);

    return $request;
}

// Get Students
$studentsQuery = 'SELECT * FROM `students`';
$studentsResults = mysqli_query($con, $studentsQuery);

// Get Courses
$coursesQuery = 'SELECT * FROM `courses`';
$coursesResults = mysqli_query($con, $coursesQuery);

// Get Status
$statusesQuery = 'SELECT * FROM `statuses`';
$statusesResults = mysqli_query($con, $statusesQuery);


// --------------------------------------------------------------------------------------------------------------------------------
// get subscription data for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // get subscription data
    $query = "SELECT * , DATE_FORMAT(`join_date`, '%Y-%m-%dT%H:%i') AS `join_date`, DATE_FORMAT(`expiry_date`, '%Y-%m-%dT%H:%i') AS `expiry_date`  FROM `subscriptions` WHERE `id` = $id";
    $result = mysqli_query($con, $query);

    // check subscription presence
    if (!$result || mysqli_num_rows($result)) {
        $subscription = mysqli_fetch_assoc($result);
    } else {
        $_SESSION['errorMessage']['subscriptionNotFound'] = 'This subscription isn\'t there';
        header('location: all.php');
        exit();
    };
}

// --------------------------------------------------------------------------------------------------------------------------------
// if submission occurred by post request
// Validate inputs
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Validate ID
    if (isset($_POST['id'])) {
        $id = clean($_POST['id']);
        if (empty($id)) {
            $_SESSION['errorMessages']['id'] = 'Please send a <strong> valid ID</strong>';
        } else {
            $_SESSION['oldData']['id'] = $id;
        }
    } else {
        $_SESSION['errorMessages']['id'] = 'Please send a <strong> valid ID</strong>';
    }

    // Validate Course
    if (isset($_POST['course_id'])) {
        $course_id = clean($_POST['course_id']);
        if (!filter_var($course_id, FILTER_VALIDATE_INT)) {
            $_SESSION['errorMessages']['course_id'] = 'Please Choose the <strong>Course</strong>';
            $_SESSION['oldData']['course_id'] = $course_id;
        } else {
            $_SESSION['oldData']['course_id'] = $course_id;
        }
    } else {
        $_SESSION['errorMessages']['course_id'] = 'Please Choose the <strong>Course</strong>';
    }

    // Validate Student
    if (isset($_POST['student_id'])) {
        $student_id = clean($_POST['student_id']);
        if (!filter_var($student_id, FILTER_VALIDATE_INT)) {
            $_SESSION['errorMessages']['student_id'] = 'Please Choose the <strong>Student</strong>';
            $_SESSION['oldData']['student_id'] = $student_id;
        } else {
            $_SESSION['oldData']['student_id'] = $student_id;
        }
    } else {
        $_SESSION['errorMessages']['student_id'] = 'Please Choose the <strong>Course</strong>';
    }

    // Validate Status
    if (isset($_POST['status_id'])) {
        $status_id = clean($_POST['status_id']);
        if (!filter_var($status_id, FILTER_VALIDATE_INT)) {
            $_SESSION['errorMessages']['status_id'] = 'Please Choose the <strong>Status</strong>';
            $_SESSION['oldData']['status_id'] = $status_id;
        } else {
            $_SESSION['oldData']['status_id'] = $status_id;
        }
    } else {
        $_SESSION['errorMessages']['status_id'] = 'Please Choose the <strong>Status</strong>';
    }

    // Validate Date of Join
    if (isset($_POST['join_date'])) {
        $join_date = clean($_POST['join_date']);
        if (empty($join_date)) {
            $_SESSION['errorMessages']['join_date'] = 'Please Choose the <strong>Date of Join</strong>';
        } else {
            $_SESSION['oldData']['join_date'] = $join_date;
        }
    }

    // Validate Date of Expiry
    if (isset($_POST['expiry_date'])) {
        $expiry_date = clean($_POST['expiry_date']);
        if (empty($expiry_date)) {
            $expiry_date = '0000-00-00 00:00:00';
        } else {
            $_SESSION['oldData']['expiry_date'] = $expiry_date;
        }
    }

    // check validation success and update course
    if (empty($_SESSION['errorMessages'])) {
        $updateQuery = "UPDATE `subscriptions` SET `course_id`=?,`student_id`=? ,`status_id`=?,`join_date`=?,`expiry_date`=? WHERE `id` = ?";
        $stmt = mysqli_prepare($con, $updateQuery);
        mysqli_stmt_bind_param($stmt, "iiissi", $course_id, $student_id, $status_id, $join_date, $expiry_date, $id);
        mysqli_stmt_execute($stmt);

        // check insert success
        if (mysqli_affected_rows($con) == 1) {

            $_SESSION['successMessages'] = 'Course Edited successfully';

            // clear session data and error messages
            if (isset($_SESSION['errorMessages'])) {
                unset($_SESSION['errorMessages']);
            }
            if (isset($_SESSION['oldData'])) {
                unset($_SESSION['oldData']);
            }

            // redirect to home page
            header("Location: all.php");
            exit();
        }
    }
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
            <div class="content-wrapper-before"></div>
            <div class="content-header row">
                <div class="col-12 text-center my-2">
                    <h2 class="text-white font-weight-bold">Edit Subscription</h2>
                </div>
            </div>
            <div class="content-body">
                <div class="card">
                    <div class="card-content pt-2">
                        <div class="card-body">
                            <form class="form" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                                <div class="form-body">
                                    <div class="row">

                                        <input type="hidden" name="id" value="<?= isset($_GET['id']) ? $_GET['id'] : (isset($_SESSION['oldData']['id']) ? $_SESSION['oldData']['id'] : "") ?>">

                                        <!-- Course -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="course" class="font-weight-bold">Course</label>
                                            <select class="form-control" name="course_id" id="course">
                                                <option class="text-muted" value="">Choose Course</option>
                                                <?php
                                                while ($course = mysqli_fetch_array($coursesResults)) {
                                                    if (isset($_SESSION['oldData']['course_id']) && $_SESSION['oldData']['course_id'] == $course['id']) {
                                                        echo "<option value='$course[id]' selected>$course[name]</option>";
                                                    } elseif (isset($subscription['course_id']) && $subscription['course_id'] == $course['id']) {
                                                        echo "<option value='$course[id]' selected>$course[name]</option>";
                                                    } else {
                                                        echo "<option value='$course[id]'>$course[name]</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <?= (isset($_SESSION['errorMessages']['course_id'])) ? "<div class='badge badge-danger mt-1 mw-100'>" . $_SESSION['errorMessages']['course_id'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Student -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="student" class="font-weight-bold">Student</label>
                                            <select class="form-control" name="student_id" id="student">
                                                <option class="text-muted" value="">Choose Student</option>
                                                <?php
                                                while ($student = mysqli_fetch_array($studentsResults)) {
                                                    if (isset($_SESSION['oldData']['student_id']) && $_SESSION['oldData']['student_id'] == $student['id']) {
                                                        echo "<option value='$student[id]' selected>$student[first_name] $student[last_name]</option>";
                                                    } elseif (isset($subscription['student_id']) && $subscription['student_id'] == $student['id']) {
                                                        echo "<option value='$student[id]' selected>$student[first_name] $student[last_name]</option>";
                                                    } else {
                                                        echo "<option value='$student[id]'>$student[first_name] $student[last_name]</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <?= (isset($_SESSION['errorMessages']['student_id'])) ? "<div class='badge badge-danger mt-1 mw-100'>" . $_SESSION['errorMessages']['student_id'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Status -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="status" class="font-weight-bold">Status</label>
                                            <select class="form-control" name="status_id" id="status">
                                                <option class="text-muted" value="">Choose Status</option>
                                                <?php
                                                while ($status = mysqli_fetch_array($statusesResults)) {
                                                    if (isset($_SESSION['oldData']['status_id']) && $_SESSION['oldData']['status_id'] == $status['id']) {
                                                        echo "<option value='$status[id]' selected>$status[name]</option>";
                                                    } elseif (isset($subscription['status_id']) && $subscription['status_id'] == $status['id']) {
                                                        echo "<option value='$status[id]' selected>$status[name]</option>";
                                                    } else {
                                                        echo "<option value='$status[id]'>$status[name]</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <?= (isset($_SESSION['errorMessages']['status_id'])) ? "<div class='badge badge-danger mt-1 mw-100'>" . $_SESSION['errorMessages']['status_id'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Join Date -->
                                        <div class="offset-md-1 col-md-4 form-group text-center">
                                            <label for="join_date" class="font-weight-bold">Date of Join</label>
                                            <input type="datetime-local" class="form-control" name="join_date" value="<?= isset($_SESSION['oldData']['join_date']) ? $_SESSION['oldData']['join_date'] : (isset($subscription['join_date']) ? $subscription['join_date'] : "") ?>">
                                            <?= (isset($_SESSION['errorMessages']['join_date'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['join_date'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Expiry Date -->
                                        <div class="offset-md-2 col-md-4 form-group text-center">
                                            <label for="expiry_date" class="font-weight-bold">Date of Expiry</label>
                                            <input type="datetime-local" class="form-control" name="expiry_date" value="<?= isset($_SESSION['oldData']['expiry_date']) ? $_SESSION['oldData']['expiry_date'] : (isset($subscription['expiry_date']) ? $subscription['expiry_date'] : "") ?>">
                                            <?= (isset($_SESSION['errorMessages']['expiry_date'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['expiry_date'] . "</div>" : ''; ?>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-actions center">
                                    <button type="submit" class="btn btn-outline-primary">Submit</button>
                                </div>
                            </form>
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
        $(function() {

            // Get Cities by ajax function 
            function getCities(country_id, selected = null) {
                $('#city').html(`<option class="text-muted" value="">Choose Your City</option>`);

                $.ajax({
                    url: '../ajax/getCity.php',
                    data: {
                        'country_id': country_id
                    },
                    success: function(res) {
                        if (res) {
                            let response = JSON.parse(res)
                            if (response.length > 0) {
                                for (let i = 0; i < response.length; i++) {
                                    if (selected != null && response[i]['id'] == selected) {
                                        let option = `<option value='${response[i]['id']}' selected> ${response[i]['name']} </option>`;
                                        $('#city').append(option);
                                    } else {
                                        let option = `<option value='${response[i]['id']}'> ${response[i]['name']} </option>`;
                                        $('#city').append(option);
                                    }
                                }
                            }
                        }
                    }
                })
            }

            console.log($('#country').val());

            // Get cities on bage load
            if ($('#country').val()) {
                getCities($('#country').val(), <?= isset($_SESSION['oldData']['city_id']) ? $_SESSION['oldData']['city_id'] : (isset($course['city_id']) ? $course['city_id'] : null) ?>);
            }
            $('#country').on('change', function() {
                getCities($(this).val());
            })
        })
    </script>
</body>

</html>

<?php
if (isset($_SESSION['errorMessages'])) {
    unset($_SESSION['errorMessages']);
}
if (isset($_SESSION['oldData'])) {
    unset($_SESSION['oldData']);
}
?>