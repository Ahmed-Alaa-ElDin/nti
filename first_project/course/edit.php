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

// Get Categories
$categoriesQuery = 'SELECT * FROM `categories`';
$categoriesResults = mysqli_query($con, $categoriesQuery);

// Get Teachers
$teachersQuery = 'SELECT * FROM `teachers`';
$teachersResults = mysqli_query($con, $teachersQuery);

// --------------------------------------------------------------------------------------------------------------------------------
// get course data for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // get course data
    $query = "SELECT * FROM `courses` WHERE `id` = $id";
    $result = mysqli_query($con, $query);

    // check course presence
    if (!$result || mysqli_num_rows($result)) {
        $course = mysqli_fetch_assoc($result);
    } else {
        $_SESSION['errorMessage']['courseNotFound'] = 'This course isn\'t there';
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

    // Validate Course Name
    if (isset($_POST['name'])) {
        $name = clean($_POST['name']);
        if (empty($name)) {
            $_SESSION['errorMessages']['name'] = 'Please enter the <strong>Course Name</strong>';
        } elseif (strlen($name) > 50) {
            $_SESSION['errorMessages']['name'] = 'the maximum length of Course Name is <strong>50 Characters</strong>';
            $_SESSION['oldData']['name'] = $name;
        } else {
            $_SESSION['oldData']['name'] = $name;
        }
    } else {
        $_SESSION['errorMessages']['name'] = 'Please enter the <strong>Course Name</strong>';
    }

    // Validate Category
    if (isset($_POST['category_id'])) {
        $category_id = clean($_POST['category_id']);
        if (!filter_var($category_id, FILTER_VALIDATE_INT)) {
            $_SESSION['errorMessages']['category_id'] = 'Please Choose the <strong>Category</strong>';
            $_SESSION['oldData']['category_id'] = $category_id;
        } else {
            $_SESSION['oldData']['category_id'] = $category_id;
        }
    } else {
        $_SESSION['errorMessages']['category_id'] = 'Please Choose the <strong>Category</strong>';
    }

    // Validate Teacher
    if (isset($_POST['teacher_id'])) {
        $teacher_id = clean($_POST['teacher_id']);
        if (!filter_var($teacher_id, FILTER_VALIDATE_INT)) {
            $_SESSION['errorMessages']['teacher_id'] = 'Please Choose the <strong>Teacher</strong>';
            $_SESSION['oldData']['teacher_id'] = $teacher_id;
        } else {
            $_SESSION['oldData']['teacher_id'] = $teacher_id;
        }
    } else {
        $_SESSION['errorMessages']['teacher_id'] = 'Please Choose the <strong>Teacher</strong>';
    }

    // Validate Price
    if (isset($_POST['price'])) {
        $price = filter_var(clean($_POST['price']), FILTER_SANITIZE_NUMBER_INT);
        if (empty($price)) {
            $price = 0;
            $_SESSION['oldData']['price'] = null;
        } elseif (!filter_var($price, FILTER_VALIDATE_INT)) {
            $_SESSION['errorMessages']['price'] = 'This input must contain <strong>Valid Price</strong>';
            $_SESSION['oldData']['price'] = $price;
        } elseif ($price < 0) {
            $_SESSION['errorMessages']['price'] = 'The Price must be <strong>0 at least</strong>';
            $_SESSION['oldData']['price'] = $price;
        } else {
            $_SESSION['oldData']['price'] = $price;
        }
    }

    // Validate Hours
    if (isset($_POST['hours'])) {
        $hours = filter_var(clean($_POST['hours']), FILTER_SANITIZE_NUMBER_INT);
        if (empty($hours)) {
            $hours = 0;
        } elseif (!filter_var($hours, FILTER_VALIDATE_INT)) {
            $_SESSION['errorMessages']['hours'] = 'The hours input must contain <strong>Valid Hours</strong> (Numbers Only)';
            $_SESSION['oldData']['hours'] = $hours;
        } elseif ($hours < 0) {
            $_SESSION['errorMessages']['hours'] = 'The hours input must contain <strong>Number Greater than 0</strong>';
            $_SESSION['oldData']['hours'] = $hours;
        } else {
            $_SESSION['oldData']['hours'] = $hours;
        }
    }

    // Validate Minutes
    if (isset($_POST['minutes'])) {
        $minutes = filter_var(clean($_POST['minutes']), FILTER_SANITIZE_NUMBER_INT);
        if (empty($minutes)) {
            $minutes = 0;
        } elseif (!filter_var($minutes, FILTER_VALIDATE_INT)) {
            $_SESSION['errorMessages']['minutes'] = 'The minutes input must contain <strong>Valid Hours</strong> (Numbers Only)';
            $_SESSION['oldData']['minutes'] = $minutes;
        } elseif ($minutes < 0 || $minutes > 59) {
            $_SESSION['errorMessages']['minutes'] = 'The minutes must be <strong>Number Between 0 and 59</strong>';
            $_SESSION['oldData']['minutes'] = $minutes;
        } else {
            $_SESSION['oldData']['minutes'] = $minutes;
        }
    }

    // Validate Images
    if (isset($_POST["old_img"])) {
        $_SESSION['oldData']['old_img'] = $_POST["old_img"];

        // Check if image file is a actual image or fake image
        if (empty($_FILES["course_img"]["tmp_name"]) || !getimagesize($_FILES["course_img"]["tmp_name"])) {
            $course_img = $_POST["old_img"];
            $_SESSION['data']['course_img'] = 'default_course.png';
        } else {
            $target_dir = dirname(__DIR__) . "/uploads/";
            $fileName = basename($_FILES["course_img"]["name"]);
            $imageFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $newName = rand() . time() . '.' . $imageFileType;
            $target_file = $target_dir . $newName;

            // Check if file already exists
            if (file_exists($target_file)) {
                $_SESSION['errorMessages']['course_img'] = 'Sorry, <strong>file already exists</strong>';
            }

            // Check file size
            if ($_FILES["course_img"]["size"] > 2000000) {
                $_SESSION['errorMessages']['course_img'] = 'Sorry, the maximum file size is <strong>2 MB</strong>';
            }

            // Allow certain file formats
            if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
                $_SESSION['errorMessages']['course_img'] = 'Sorry, only <strong>JPG, JPEG, PNG & GIF</strong> files are allowed';
            }

            // finally move uploaded Image
            if (empty($_SESSION['errorMessages']['course_img'])) {
                $check = move_uploaded_file($_FILES["course_img"]["tmp_name"], $target_file);
                $course_img = $newName;
            }
        }
    } else {
        $_SESSION['errorMessages']['course_img'] = 'Some data are missing <strong>Please Try Again</strong>';
    }

    // check validation success and update course
    if (empty($_SESSION['errorMessages'])) {
        $updateQuery = "UPDATE `courses` SET `name`=?,`price`=? ,`hours`=?,`minutes`=?,`category_id`=?,`created_by`=?,`course_img`=? WHERE `id` = ?";
        $stmt = mysqli_prepare($con, $updateQuery);
        mysqli_stmt_bind_param($stmt, "siiiiisi", $name, $price, $hours, $minutes, $category_id, $teacher_id, $course_img, $id);
        mysqli_stmt_execute($stmt);

        // check insert success
        if (mysqli_affected_rows($con)) {

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
                    <h2 class="text-white font-weight-bold">Edit Course</h2>
                </div>
            </div>
            <div class="content-body">
                <div class="card">
                    <div class="card-content pt-2">
                        <!-- <div class="card-body">
						<h4 class="card-title">Contact Form</h4>
						<h6 class="card-subtitle text-muted">Support card subtitle</h6>
					</div> -->
                        <div class="card-body">
                            <form class="form" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                                <div class="form-body">
                                    <div class="row">

                                        <input type="hidden" name="id" value="<?= isset($_GET['id']) ? $_GET['id'] : (isset($_SESSION['oldData']['id']) ? $_SESSION['oldData']['id'] : "") ?>">

                                        <!-- Name -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="name" class="font-weight-bold">Course Name</label>
                                            <input type="text" id="name" class="form-control" placeholder="Enter The Course Name" name="name" value="<?= isset($_SESSION['oldData']['name']) ? $_SESSION['oldData']['name'] : (isset($course['name']) ? $course['name'] : "") ?>">
                                            <?= (isset($_SESSION['errorMessages']['name'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['name'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Category -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="category" class="font-weight-bold">Category</label>
                                            <select class="form-control" name="category_id" id="category">
                                                <option class="text-muted" value="">Choose Category</option>
                                                <?php
                                                while ($category = mysqli_fetch_array($categoriesResults)) {
                                                    if (isset($_SESSION['oldData']['category_id']) && $_SESSION['oldData']['category_id'] == $category['id']) {
                                                        echo "<option value='$category[id]' selected>$category[name]</option>";
                                                    } elseif (isset($course['category_id']) && $course['category_id'] == $category['id']) {
                                                        echo "<option value='$category[id]' selected>$category[name]</option>";
                                                    } else {
                                                        echo "<option value='$category[id]'>$category[name]</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <?= (isset($_SESSION['errorMessages']['category_id'])) ? "<div class='badge badge-danger mt-1 mw-100'>" . $_SESSION['errorMessages']['category_id'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Teacher -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="teacher" class="font-weight-bold">Teacher</label>
                                            <select class="form-control" name="teacher_id" id="teacher">
                                                <option class="text-muted" value="">Choose Teacher</option>
                                                <?php
                                                while ($teacher = mysqli_fetch_array($teachersResults)) {
                                                    if (isset($_SESSION['oldData']['teacher_id']) && $_SESSION['oldData']['teacher_id'] == $teacher['id']) {
                                                        echo "<option value='$teacher[id]' selected>$teacher[first_name] $teacher[last_name]</option>";
                                                    } elseif (isset($course['created_by']) && $course['created_by'] == $teacher['id']) {
                                                        echo "<option value='$teacher[id]' selected>$teacher[first_name] $teacher[last_name]</option>";
                                                    } else {
                                                        echo "<option value='$teacher[id]'>$teacher[first_name] $teacher[last_name]</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <?= (isset($_SESSION['errorMessages']['teacher_id'])) ? "<div class='badge badge-danger mt-1 mw-100'>" . $_SESSION['errorMessages']['teacher_id'] . "</div>" : ''; ?>
                                        </div>


                                        <!-- Price -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="price" class="font-weight-bold">Price <small class="text-danger font-weight-bold">(EGP)</small></label>
                                            <input type="number" min='0' id="price" class="form-control" placeholder="Enter Price" name="price" value=<?= isset($_SESSION['oldData']['price']) ? $_SESSION['oldData']['price'] : (isset($course['price']) ? $course['price'] : "") ?>>
                                            <?= (isset($_SESSION['errorMessages']['price'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['price'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Duration -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="price" class="font-weight-bold">Duration</label>
                                            <div class="row justify-content-md-center align-items-center">
                                                <div class="col-5">
                                                    <input type="number" min="0" class="form-control" name="hours" placeholder="Hours" value=<?= isset($_SESSION['oldData']['hours']) ? $_SESSION['oldData']['hours'] : (isset($course['hours']) ? $course['hours'] : "") ?>>
                                                </div>
                                                <span class="align-middle col-2 d-block"> : </span>
                                                <div class="col-5">
                                                    <input type="number" min="0" max="59" class="form-control" name="minutes" placeholder="Minutes" value=<?= isset($_SESSION['oldData']['minutes']) ? $_SESSION['oldData']['minutes'] : (isset($course['minutes']) ? $course['minutes'] : "") ?>>
                                                </div>
                                            </div>
                                            <?= (isset($_SESSION['errorMessages']['hours'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['hours'] . "</div>" : ''; ?>
                                            <?= (isset($_SESSION['errorMessages']['minutes'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['minutes'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Course Image -->
                                        <div class="col-md-4 form-group text-center">
                                            <input type="hidden" name="old_img" value="<?= isset($_SESSION['oldData']['old_img']) ? $_SESSION['oldData']['old_img'] : (isset($course['course_img']) ? $course['course_img'] : "default_course.png") ?>">
                                            <label for="courseImg" class="font-weight-bold">Course Image</label>
                                            <div class="input-group">
                                                <div class="custom-file text-primary">
                                                    <input type="file" class="custom-file-input" name="course_img" id="courseImgInput" aria-describedby="inputGroupFileAddon01">
                                                    <label class="custom-file-label text-left" for="courseImgInput">Choose file</label>
                                                </div>
                                            </div>
                                            <div class='badge badge-warning mt-1 mw-100 text-dark font-weight-bold'>If you left it empty, the old image will be kept as it is</div>
                                            <?= (isset($_SESSION['errorMessages']['course_img'])) ? "<div class='badge badge-danger mt-1 mw-100'>" . $_SESSION['errorMessages']['course_img'] . "</div>" : ''; ?>
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