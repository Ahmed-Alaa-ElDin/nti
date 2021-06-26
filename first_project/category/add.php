<?php
// prerequisite variables
$addCategory = true;

$title = 'Courses4U - Add New Category';

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

// Validate inputs
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = null;

    // Validate Name
    if (isset($_POST['name'])) {
        $name = clean($_POST['name']);
        if (empty($name)) {
            $_SESSION['errorMessages']['name'] = 'Please enter the <strong>Category Name</strong>';
        } elseif (strlen($name) > 50) {
            $_SESSION['errorMessages']['name'] = 'the maximum length of Category Name is <strong>50 Characters</strong>';
            $_SESSION['oldData']['name'] = $name;
        } else {
            $_SESSION['oldData']['name'] = $name;
        }
    } else {
        $_SESSION['errorMessages']['name'] = 'Please enter the <strong>Category Name</strong>';
    }

    // check validation success and insert category
    if (empty($_SESSION['errorMessages'])) {
        $insertQuery = "INSERT INTO `categories`(`name`) VALUES (?)";
        $stmt = mysqli_prepare($con, $insertQuery);
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);

        // check insert success
        if ($stmt) {

            $_SESSION['successMessages'] = 'New Category Added successfully';

            // clear session data and error messages
            if (isset($_SESSION['errorMessages'])) {
                unset($_SESSION['errorMessages']);
            }
            if (isset($_SESSION['oldData'])) {
                unset($_SESSION['oldData']);
            }

            // redirect to home page
            header("Location: /nti/first_project/category/all.php");
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
                    <h2 class="text-white font-weight-bold">Add New Category</h2>
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
                                        <div class="offset-md-3 col-md-6 form-group text-center">
                                            <label for="Name" class="font-weight-bold"> Name</label>
                                            <input type="text" id="Name" class="form-control" placeholder="Enter Category Name" name="name" value=<?= isset($_SESSION['oldData']['name']) ? '"' .  $_SESSION['oldData']['name'] . '"' : "" ?>>
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