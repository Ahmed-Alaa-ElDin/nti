<?php
// prerequisite variables
$title = 'Courses4U - Edit Review';

$style =
    '.badge {
            white-space: unset;
            line-height: unset;
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

// Get All Students
$studentsQuery = 'SELECT * FROM `students`';
$studentsResults = mysqli_query($con, $studentsQuery);

// Get All Courses
$coursesQuery = 'SELECT * FROM `courses`';
$coursesResults = mysqli_query($con, $coursesQuery);


// --------------------------------------------------------------------------------------------------------------------------------
// get review data for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // get review data
    $query = "SELECT * FROM `reviews` WHERE `id` = $id";
    $result = mysqli_query($con, $query);

    // check review presence
    if (!$result || mysqli_num_rows($result)) {
        $review = mysqli_fetch_assoc($result);
        // print_r($review);
        // exit();
    } else {
        $_SESSION['errorMessage']['reviewNotFound'] = 'This review isn\'t there';
        header('location: all.php');
        exit();
    };
}

// --------------------------------------------------------------------------------------------------------------------------------
// if submission occurred by post request
// Validate inputs
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Validate id
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
        $course_id = filter_var(clean($_POST['course_id']), FILTER_SANITIZE_NUMBER_INT);
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
        $student_id = filter_var(clean($_POST['student_id']), FILTER_SANITIZE_NUMBER_INT);
        if (!filter_var($student_id, FILTER_VALIDATE_INT)) {
            $_SESSION['errorMessages']['student_id'] = 'Please Choose the <strong>Student</strong>';
            $_SESSION['oldData']['student_id'] = $student_id;
        } else {
            $_SESSION['oldData']['student_id'] = $student_id;
        }
    } else {
        $_SESSION['errorMessages']['student_id'] = 'Please Choose the <strong>Student</strong>';
    }

    // Validate Rating
    if (isset($_POST['rating'])) {
        // print_r(clean($_POST['rating']));
        // exit();
        $rating = clean($_POST['rating']);
        if (!filter_var($rating, FILTER_VALIDATE_FLOAT)) {
            $_SESSION['errorMessages']['rating'] = 'Please Choose the <strong>Rating</strong>';
            $_SESSION['oldData']['rating'] = $rating;
        } else {
            $_SESSION['oldData']['rating'] = $rating;
        }
    } else {
        $_SESSION['errorMessages']['rating'] = 'Please Choose the <strong>Rating</strong>';
    }

    // Validate Reviews
    if (isset($_POST['review'])) {
        $review = clean($_POST['review']);
        if (empty($review)) {
            $review = 'Without Feedback';
        } else {
            $_SESSION['oldData']['review'] = $review;
        }
    } else {
        $_SESSION['errorMessages']['review'] = 'Please Choose the <strong>Review</strong>';
    }

    // check validation success and update review
    if (empty($_SESSION['errorMessages'])) {
        $updateQuery = "UPDATE `reviews` SET `course_id`= ?, `student_id`= ?, `rating`= ?, `review`= ? WHERE `id` = ?";
        $stmt = mysqli_prepare($con, $updateQuery);
        mysqli_stmt_bind_param($stmt, "iidsi", $course_id, $student_id, $rating, $review, $id);

        mysqli_stmt_execute($stmt);

        $_SESSION['successMessages'] = 'Review Edited successfully';

        // clear session data and error messages
        if (isset($_SESSION['errorMessages'])) {
            unset($_SESSION['errorMessages']);
        }
        if (isset($_SESSION['oldData'])) {
            unset($_SESSION['oldData']);
        }

        // redirect to home page
        header("Location: /nti/first_project/review/all.php");
        exit();
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
                    <h2 class="text-white font-weight-bold">Edit Review</h2>
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
                                                    } elseif (isset($review['course_id']) && $review['course_id'] == $course['id']) {
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
                                                    if ((isset($_SESSION['oldData']['student_id']) && $_SESSION['oldData']['student_id'] == $student['id'])) {
                                                        echo "<option value='$student[id]' selected>$student[first_name] $student[last_name]</option>";
                                                    } elseif (isset($review['student_id']) && $review['student_id'] == $student['id']) {
                                                        echo "<option value='$student[id]' selected>$student[first_name] $student[last_name]</option>";
                                                    } else {
                                                        echo "<option value='$student[id]'>$student[first_name] $student[last_name]</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <?= (isset($_SESSION['errorMessages']['student_id'])) ? "<div class='badge badge-danger mt-1 mw-100'>" . $_SESSION['errorMessages']['student_id'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Rating -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="rating" class="font-weight-bold">Rate</label>
                                            <div id="rating"></div>
                                            <?= (isset($_SESSION['errorMessages']['rating'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['rating'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Feedback -->
                                        <div class="col-md-12 form-group text-center">
                                            <label for="review" class="font-weight-bold">Feedback</label>
                                            <textarea name="review" class="form-control" id="review">
                                                <?= isset($_SESSION['oldData']['review']) ? $_SESSION['oldData']['review'] : (isset($review['review']) ? $review['review'] : '') ?>
                                            </textarea>
                                            <?= (isset($_SESSION['errorMessages']['review'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['review'] . "</div>" : ''; ?>
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
        // adding rating star
        $('#rating').raty({
            half: true,
            hints: [
                ['bad 1/2', 'bad'],
                ['poor 1/2', 'poor'],
                ['regular 1/2', 'regular'],
                ['good 1/2', 'good'],
                ['gorgeous 1/2', 'gorgeous']
            ],
            scoreName: 'rating',
            <?= isset($_SESSION['oldData']['rating']) ? "score:'" . $_SESSION['oldData']['rating'] . "'," : (isset($review['rating']) ? "score: $review[rating]," : '') ?>
        });

        // ading tinymce
        tinymce.init({
            selector: 'textarea#review',
            plugins: 'directionality lists ',
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | ltr rtl',
            elementpath: false
        });
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