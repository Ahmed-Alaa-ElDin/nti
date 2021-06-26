<?php
// prerequisite variables
$addCity = true;

$title = 'Courses4U - Add New City';

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

// Get Countries
$countriesQuery = 'SELECT * FROM `countries`';
$countriesResults = mysqli_query($con, $countriesQuery);

// Validate inputs
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $country_id = null;

    // Validate City Name
    if (isset($_POST['name'])) {
        $name = clean($_POST['name']);
        if (empty($name)) {
            $_SESSION['errorMessages']['name'] = 'Please enter the <strong>City Name</strong>';
        } elseif (strlen($name) > 50) {
            $_SESSION['errorMessages']['name'] = 'the maximum length of City Name is <strong>50 Characters</strong>';
            $_SESSION['oldData']['name'] = $name;
        } else {
            $_SESSION['oldData']['name'] = $name;
        }
    } else {
        $_SESSION['errorMessages']['name'] = 'Please enter the <strong>City Name</strong>';
    }

    // Validate Country
    if (isset($_POST['country_id'])) {
        $country_id = clean($_POST['country_id']);
        if (!filter_var($country_id, FILTER_VALIDATE_INT)) {
            $_SESSION['errorMessages']['country_id'] = 'Please Choose the <strong>Country</strong>';
            $_SESSION['oldData']['country_id'] = $country_id;
        } else {
            $_SESSION['oldData']['country_id'] = $country_id;
        }
    } else {
        $_SESSION['errorMessages']['country_id'] = 'Please Choose the <strong>Country</strong>';
    }

    // check validation success and insert user
    if (empty($_SESSION['errorMessages'])) {
        $insertQuery = "INSERT INTO `cities`(`name`, `country_id`) VALUES (?,?)";
        $stmt = mysqli_prepare($con, $insertQuery);
        mysqli_stmt_bind_param($stmt, "si", $name, $country_id);
        mysqli_stmt_execute($stmt);

        // check insert success
        if ($stmt) {

            $_SESSION['successMessages'] = 'New City Added successfully';

            // clear session data and error messages
            if (isset($_SESSION['errorMessages'])) {
                unset($_SESSION['errorMessages']);
            }
            if (isset($_SESSION['oldData'])) {
                unset($_SESSION['oldData']);
            }

            // redirect to home page
            header("Location: /nti/first_project/city/all.php");
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
                    <h2 class="text-white font-weight-bold">Add New City</h2>
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

                                        <!-- City Name -->
                                        <div class="col-md-6 form-group text-center">
                                            <label for="name" class="font-weight-bold">Name</label>
                                            <input type="text" id="name" class="form-control" placeholder="Enter City Name" name="name" value=<?= isset($_SESSION['oldData']['name']) ? '"' .  $_SESSION['oldData']['name'] . '"' : "" ?>>
                                            <?= (isset($_SESSION['errorMessages']['name'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['name'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Country -->
                                        <div class="col-md-6 form-group text-center">
                                            <label for="country" class="font-weight-bold">Country</label>
                                            <select class="form-control" name="country_id" id="country">
                                                <option class="text-muted" value="">Choose Country</option>
                                                <?php
                                                while ($country = mysqli_fetch_array($countriesResults)) {
                                                    if (isset($_SESSION['oldData']['country_id']) && $_SESSION['oldData']['country_id'] == $country['id']) {
                                                        echo "<option value='$country[id]' selected>$country[name]</option>";
                                                    } else {
                                                        echo "<option value='$country[id]'>$country[name]</option>";
                                                    }
                                                }
                                                ?>
                                                <?= (isset($_SESSION['errorMessages']['country_id'])) ? "<div class='badge badge-danger mt-1 mw-100'>" . $_SESSION['errorMessages']['country_id'] . "</div>" : ''; ?>
                                            </select>
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