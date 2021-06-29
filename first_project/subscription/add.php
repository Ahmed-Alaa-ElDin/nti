<?php
// prerequisite variables
$addSubcription = true;

$title = 'Courses4U - Add New Subscription';

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


// Validate inputs
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

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

    // check validation success and insert subscription
    if (empty($_SESSION['errorMessages'])) {
        $insertQuery = "INSERT INTO `subscriptions`(`course_id`, `student_id`, `status_id`, `join_date`, `expiry_date`) VALUES (?,?,?,?,?)";
        $stmt = mysqli_prepare($con, $insertQuery);
        mysqli_stmt_bind_param($stmt, "iiiss", $course_id, $student_id, $status_id, $join_date, $expiry_date);
        mysqli_stmt_execute($stmt);

        // check insert success
        if (mysqli_affected_rows($con) == 1) {

            $_SESSION['successMessages'] = 'New Sudscription Added successfully';

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
                    <h2 class="text-white font-weight-bold">Add New Subscription</h2>
                </div>
            </div>
            <div class="content-body">
                <div class="card">
                    <div class="card-content pt-2">
                        <div class="card-body">
                            <form class="form" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                                <div class="form-body">
                                    <div class="row">

                                        <!-- Course -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="course" class="font-weight-bold">Course</label>
                                            <select class="form-control" name="course_id" id="course">
                                                <option class="text-muted" value="">Choose Course</option>
                                                <?php
                                                while ($course = mysqli_fetch_array($coursesResults)) {
                                                    if (isset($_SESSION['oldData']['course_id']) && $_SESSION['oldData']['course_id'] == $course['id']) {
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
                                            <input type="datetime-local" class="form-control" name="join_date" value=<?= isset($_SESSION['oldData']['join_date']) ? $_SESSION['oldData']['join_date'] :  "" ?>>
                                            <?= (isset($_SESSION['errorMessages']['join_date'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['join_date'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Expiry Date -->
                                        <div class="offset-md-2 col-md-4 form-group text-center">
                                            <label for="expiry_date" class="font-weight-bold">Date of Expiry</label>
                                            <input type="datetime-local" class="form-control" name="expiry_date" value=<?= isset($_SESSION['oldData']['expiry_date']) ? $_SESSION['oldData']['expiry_date'] : "" ?>>
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