<?php
// prerequisite variables
$addCourse = true;

$title = 'Courses4U - Add New Courses';

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

// Get All Teachers
$teachersQuery = 'SELECT * FROM `teachers`';
$teachersResults = mysqli_query($con, $teachersQuery);

// Get All Categories
$categoriesQuery = 'SELECT * FROM `categories`';
$categoriesResults = mysqli_query($con, $categoriesQuery);


// Validate inputs
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $category_id = $teacher_id = $price = $hours = $minutes = $course_img = null;

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

    if (isset($_FILES["course_img"])) {

        // Check if image file is a actual image or fake image
        if (empty($_FILES["course_img"]["tmp_name"]) || !getimagesize($_FILES["course_img"]["tmp_name"])) {
            $course_img = 'default_course.png	';
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
        $course_img = 'default_course.png';
    }



    // check validation success and insert user
    if (empty($_SESSION['errorMessages'])) {
        $insertQuery = "INSERT INTO `courses`(`name`, `price`, `hours`, `minutes`, `course_img`, `category_id`, `created_by`) VALUES (?,?,?,?,?,?,?)";
        $stmt = mysqli_prepare($con, $insertQuery);
        mysqli_stmt_bind_param($stmt, "siiisii", $name, $price, $hours, $minutes, $course_img, $category_id, $teacher_id);
        mysqli_stmt_execute($stmt);
        
        // check insert success
        if (mysqli_affected_rows($con) == 1) {

            $_SESSION['successMessages'] = 'New Course Added successfully';

            // clear session data and error messages
            if (isset($_SESSION['errorMessages'])) {
                unset($_SESSION['errorMessages']);
            }
            if (isset($_SESSION['oldData'])) {
                unset($_SESSION['oldData']);
            }

            // redirect to home page
            header("Location: /nti/first_project/course/all.php");
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
                    <h2 class="text-white font-weight-bold">Add New Course</h2>
                </div>
            </div>
            <div class="content-body">
                <div class="card">
                    <div class="card-content pt-2">
                        <div class="card-body">
                            <form class="form" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                                <div class="form-body">
                                    <div class="row">

                                        <!-- Name -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="name" class="font-weight-bold">Course Name</label>
                                            <input type="text" id="name" class="form-control" placeholder="Enter The Course Name" name="name" value=<?= isset($_SESSION['oldData']['name']) ? '"' .  $_SESSION['oldData']['name'] . '"' : "" ?>>
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
                                                    if ((isset($_SESSION['oldData']['teacher_id']) && $_SESSION['oldData']['teacher_id'] == $teacher['id']) || (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == $teacher['id'])) {
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
                                            <input type="number" min='0' id="price" class="form-control" placeholder="Enter Price" name="price" value=<?= isset($_SESSION['oldData']['price']) ? '"' .  $_SESSION['oldData']['price'] . '"' : "" ?>>
                                            <?= (isset($_SESSION['errorMessages']['price'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['price'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Duration -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="price" class="font-weight-bold">Duration</label>
                                            <div class="row justify-content-md-center align-items-center">
                                                <div class="col-5">
                                                    <input type="number" min="0" class="form-control" name="hours" placeholder="Hours" value=<?= isset($_SESSION['oldData']['hours']) ? '"' .  $_SESSION['oldData']['hours'] . '"' : "" ?>>
                                                </div>
                                                <span class="align-middle col-2 d-block"> : </span>
                                                <div class="col-5">
                                                    <input type="number" min="0" max="59" class="form-control" name="minutes" placeholder="Minutes" value=<?= isset($_SESSION['oldData']['minutes']) ? '"' .  $_SESSION['oldData']['minutes'] . '"' : "" ?>>
                                                </div>
                                            </div>
                                            <?= (isset($_SESSION['errorMessages']['hours'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['hours'] . "</div>" : ''; ?>
                                            <?= (isset($_SESSION['errorMessages']['minutes'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['minutes'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Course Image -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="courseImg" class="font-weight-bold">Course Image</label>
                                            <div class="input-group">
                                                <div class="custom-file text-primary">
                                                    <input type="file" class="custom-file-input" name="course_img" id="courseImgInput" aria-describedby="inputGroupFileAddon01">
                                                    <label class="custom-file-label text-left" for="courseImgInput">Choose file</label>
                                                </div>
                                            </div>
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