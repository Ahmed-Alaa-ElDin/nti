<?php
// prerequisite variables
$title = 'Courses4U - Edit City';

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


// --------------------------------------------------------------------------------------------------------------------------------
// get city data for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // get city data
    $query = "SELECT * FROM `cities` WHERE `id` = $id";
    $result = mysqli_query($con, $query);

    // check city presence
    if (!$result || mysqli_num_rows($result)) {
        $city = mysqli_fetch_assoc($result);
    } else {
        $_SESSION['errorMessage']['cityNotFound'] = 'This city isn\'t there';
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


    // Validate City Name
    if (isset($_POST['name'])) {
        $name = clean($_POST['name']);
        if (empty($name)) {
            $_SESSION['errorMessages']['name'] = 'Please enter your <strong>City Name</strong>';
        } elseif (strlen($name) > 50) {
            $_SESSION['errorMessages']['name'] = 'the maximum length of City Name is <strong>50 Characters</strong>';
            $_SESSION['oldData']['name'] = $name;
        } else {
            $_SESSION['oldData']['name'] = $name;
        }
    } else {
        $_SESSION['errorMessages']['name'] = 'Please enter your <strong>City Name</strong>';
    }

    // Validate Country
    if (isset($_POST['country_id'])) {
        $country_id = clean($_POST['country_id']);
        if (!filter_var($country_id, FILTER_VALIDATE_INT)) {
            $_SESSION['errorMessages']['country_id'] = 'Please Choose your <strong>Country</strong>';
            $_SESSION['oldData']['country_id'] = $country_id;
        } else {
            $_SESSION['oldData']['country_id'] = $country_id;
        }
    } else {
        $_SESSION['errorMessages']['country_id'] = 'Please Choose your <strong>Country</strong>';
    }

    // check validation success and update student
    if (empty($_SESSION['errorMessages'])) {
        $updateQuery = "UPDATE `cities` SET `name`=?,`country_id`= ? WHERE `id` = ?";
        $stmt = mysqli_prepare($con, $updateQuery);
        mysqli_stmt_bind_param($stmt, "sii", $name, $country_id, $id);
        mysqli_stmt_execute($stmt);

        $_SESSION['successMessages'] = 'City Edited successfully';

        if (!$stmt) {
            echo 'sadas';
            exit();
        }
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
                    <h2 class="text-white font-weight-bold">Edit City</h2>
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
                                        <div class="col-md-6 form-group text-center">
                                            <label for="name" class="font-weight-bold">Name</label>
                                            <input type="text" id="name" class="form-control" placeholder="Enter Your City Name" name="name" value="<?= isset($_SESSION['oldData']['name']) ? $_SESSION['oldData']['name'] : (isset($city['name']) ? $city['name'] : "") ?>">
                                            <?= (isset($_SESSION['errorMessages']['name'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['name'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Country -->
                                        <div class="col-md-6 form-group text-center">
                                            <label for="country" class="font-weight-bold">Country</label>
                                            <select class="form-control" name="country_id" id="country">
                                                <option class="text-muted" value="">Choose Your Country</option>
                                                <?php
                                                while ($country = mysqli_fetch_array($countriesResults)) {
                                                    if (isset($_SESSION['oldData']['country_id']) && $_SESSION['oldData']['country_id'] == $country['id']) {
                                                        echo "<option value='$country[id]' selected>$country[name]</option>";
                                                    } elseif (isset($city['country_id']) && $city['country_id'] == $country['id']) {
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
                getCities($('#country').val(), <?= isset($_SESSION['oldData']['city_id']) ? $_SESSION['oldData']['city_id'] : (isset($student['city_id']) ? $student['city_id'] : null) ?>);
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