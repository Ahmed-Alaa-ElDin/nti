<?php
// prerequisite variables
$title = 'Courses4U - Edit Status';

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


// --------------------------------------------------------------------------------------------------------------------------------
// get status data for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // get status data
    $query = "SELECT * FROM `statuses` WHERE `id` = $id";
    $result = mysqli_query($con, $query);

    // check status presence
    if (!$result || mysqli_num_rows($result)) {
        $status = mysqli_fetch_assoc($result);
    } else {
        $_SESSION['errorMessage']['statusNotFound'] = 'This status isn\'t there';
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

    // Validate Status Name
    if (isset($_POST['name'])) {
        $name = clean($_POST['name']);
        if (empty($name)) {
            $_SESSION['errorMessages']['name'] = 'Please enter the <strong>Status Name</strong>';
        } elseif (strlen($name) > 50) {
            $_SESSION['errorMessages']['name'] = 'the maximum length of Status Name is <strong>50 Characters</strong>';
            $_SESSION['oldData']['name'] = $name;
        } else {
            $_SESSION['oldData']['name'] = $name;
        }
    } else {
        $_SESSION['errorMessages']['name'] = 'Please enter the <strong>Status Name</strong>';
    }

    // check validation success and update status
    if (empty($_SESSION['errorMessages'])) {
        $updateQuery = "UPDATE `statuses` SET `name`= ? WHERE `id` = ?";
        $stmt = mysqli_prepare($con, $updateQuery);
        mysqli_stmt_bind_param($stmt, "si", $name, $id);
        mysqli_stmt_execute($stmt);

        $_SESSION['successMessages'] = 'Status Edited successfully';

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
                    <h2 class="text-white font-weight-bold">Edit Status</h2>
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

                                        <!-- Name -->
                                        <div class="offset-md-3 col-md-6 form-group text-center">
                                            <label for="name" class="font-weight-bold">Name</label>
                                            <input type="text" id="name" class="form-control" placeholder="Enter Status Name" name="name" value="<?= isset($_SESSION['oldData']['name']) ? $_SESSION['oldData']['name'] : (isset($status['name']) ? $status['name'] : "") ?>">
                                            <?= (isset($_SESSION['errorMessages']['name'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['name'] . "</div>" : ''; ?>
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