<?php
// prerequisite variables
$title = 'Courses4U - Edit Teacher Profile';

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
// get teacher data for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // get teacher data
    $query = "SELECT * FROM `teachers` WHERE `id` = $id";
    $result = mysqli_query($con, $query);

    // check teacher presence
    if (!$result || mysqli_num_rows($result)) {
        $teacher = mysqli_fetch_assoc($result);
    } else {
        $_SESSION['errorMessage']['teacherNotFound'] = 'This teacher isn\'t there';
        header('location: all.php');
        exit();
    };
}

// --------------------------------------------------------------------------------------------------------------------------------
// if submission occurred by post request
// Validate inputs
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Validate First Name
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


    // Validate First Name
    if (isset($_POST['first_name'])) {
        $first_name = clean($_POST['first_name']);
        if (empty($first_name)) {
            $_SESSION['errorMessages']['first_name'] = 'Please enter your <strong>First Name</strong>';
        } elseif (strlen($first_name) > 50) {
            $_SESSION['errorMessages']['first_name'] = 'the maximum length of First Name is <strong>50 Characters</strong>';
            $_SESSION['oldData']['first_name'] = $first_name;
        } else {
            $_SESSION['oldData']['first_name'] = $first_name;
        }
    } else {
        $_SESSION['errorMessages']['first_name'] = 'Please enter your <strong>First Name</strong>';
    }

    // Validate Last Name
    if (isset($_POST['last_name'])) {
        $last_name = clean($_POST['last_name']);
        if (empty($last_name)) {
            $_SESSION['oldData']['last_name'] = null;
        } elseif (strlen($last_name) > 50) {
            $_SESSION['errorMessages']['last_name'] = 'the maximum length of Last Name is <strong>50 Characters</strong>';
            $_SESSION['oldData']['last_name'] = $last_name;
        } else {
            $_SESSION['oldData']['last_name'] = $last_name;
        }
    }

    // Validate Email
    if (isset($_POST['email'])) {
        $email = clean($_POST['email']);
        if (empty($email)) {
            $_SESSION['errorMessages']['email'] = 'Please enter your <strong>E-mail</strong>';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['errorMessages']['email'] = 'This input must contain <strong>Valid E-mail</strong>';
            $_SESSION['oldData']['email'] = $email;
        } elseif (strlen($email) > 50) {
            $_SESSION['errorMessages']['email'] = 'the maximum length of E-mail is <strong>50 Characters</strong>';
            $_SESSION['oldData']['email'] = $email;
        } else {
            $_SESSION['oldData']['email'] = $email;
        }
    } else {
        $_SESSION['errorMessages']['email'] = 'Please enter your <strong>E-mail</strong>';
    }

    // Validate Phone
    if (isset($_POST['phone'])) {
        $phone = clean($_POST['phone']);
        if (empty($phone)) {
            $_SESSION['oldData']['phone'] = null;
        } elseif (strlen($phone) > 20) {
            $_SESSION['errorMessages']['phone'] = 'the maximum length of Phone Number is <strong>20 Number</strong>';
            $_SESSION['oldData']['phone'] = $phone;
        } else {
            $_SESSION['oldData']['phone'] = $phone;
        }
    }

    // Validate Age
    if (isset($_POST['age'])) {
        $age = filter_var(clean($_POST['age']), FILTER_SANITIZE_NUMBER_INT);
        if (empty($age)) {
            $age = 0;
            $_SESSION['oldData']['age'] = null;
        } elseif (!filter_var($age, FILTER_VALIDATE_INT)) {
            $_SESSION['errorMessages']['age'] = 'This input must contain <strong>Valid Age</strong>';
            $_SESSION['oldData']['age'] = $age;
        } else {
            $_SESSION['oldData']['age'] = $age;
        }
    }

    // Validate Gender
    if (isset($_POST['gender'])) {
        $gender = clean($_POST['gender']);
        if (empty($gender)) {
            $_SESSION['errorMessages']['gender'] = 'Please Choose your <strong>Gendera</strong>';
        } elseif (!filter_var($gender, FILTER_VALIDATE_INT)) {
            $_SESSION['errorMessages']['gender'] = 'Please Choose your <strong>Genderb</strong>';
            $_SESSION['oldData']['gender'] = $gender;
        } elseif (!in_array($gender, [1, 2])) {
            $_SESSION['errorMessages']['gender'] = 'Please Choose your <strong>Genderc</strong>';
            $_SESSION['oldData']['gender'] = $gender;
        } else {
            $_SESSION['oldData']['gender'] = $gender;
        }
    } else {
        $_SESSION['errorMessages']['gender'] = 'Please Choose your <strong>Gendera</strong>';
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

    // Validate City
    if (isset($_POST['city_id'])) {
        $city_id = clean($_POST['city_id']);
        if (empty($city_id)) {
            $city_id = null;
            $_SESSION['oldData']['city_id'] = null;
        } elseif (!filter_var($city_id, FILTER_VALIDATE_INT)) {
            $_SESSION['errorMessages']['city_id'] = 'Please Choose your <strong>City</strong>';
            $_SESSION['oldData']['city_id'] = $city_id;
        } else {
            $_SESSION['oldData']['city_id'] = $city_id;
        }
    }

    // Validate Password
    if (isset($_POST['old_password']) && !empty($_POST['old_password'])) {
        $oldPassword = sha1(clean($_POST['old_password']));

        // compare old password from database
        $compreQuery = "SELECT * FROM `teachers` WHERE `id` = $id AND `password` = '$oldPassword'";
        $result = mysqli_query($con, $compreQuery);

        if (mysqli_affected_rows($con) == 1) {

            // if the same of the old password from database validate new password
            if (isset($_POST['new_password']) && !empty($_POST['new_password'])) {

                $new_password = clean($_POST['new_password']);

                if (strlen($new_password) < 8) {
                    $_SESSION['errorMessages']['new_password'] = 'the length of Password must be <strong>8 Characters at least</strong>';
                } elseif (!filter_var($new_password, FILTER_VALIDATE_REGEXP, [
                    'options' => ['regexp' => '^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$^']
                ])) {
                    $_SESSION['errorMessages']['new_password'] = 'Your new_password must contain at least <strong> 8 characters</strong>, <strong>1 UPPERCASE letter</strong>, <strong>1 lowercase letter</strong>, <strong>1 number</strong> &amp; <strong>1 speci@l ch@r@cter</strong>';
                } else {
                    $new_password = sha1($new_password);

                    // Validate Password Confirmation
                    if (isset($_POST['new_password_confirmation'])) {
                        $new_password_confirmation = clean($_POST['new_password_confirmation']);
                        if (empty($new_password_confirmation)) {
                            $_SESSION['errorMessages']['new_password_confirmation'] = 'Please enter the <strong>Password Again</strong>';
                        } elseif (sha1($new_password_confirmation) !== $new_password) {
                            $_SESSION['errorMessages']['new_password_confirmation'] = 'the two passwords <strong>Didn\'t Match</strong>';
                        } else {
                            $password = $new_password;

                            // update password
                            $updateQuery = "UPDATE `teachers` SET `password`= ? WHERE `id` = ?";
                            $stmt = mysqli_prepare($con, $updateQuery);
                            mysqli_stmt_bind_param($stmt, "si", $password, $id);
                            mysqli_stmt_execute($stmt);
                        }
                    } else {
                        $_SESSION['errorMessages']['new_password_confirmation'] = 'Please enter the <strong>Password Again</strong>';
                    }
                }
            }
        } else {
            $_SESSION['errorMessages']['old_password'] = 'Wrong password, Please enter the <strong>Old Password Again</strong>';
        }
    }

    if (isset($_POST["old_img"])) {
        $_SESSION['oldData']['old_img'] = $_POST["old_img"];

        // Check if image file is a actual image or fake image
        if (empty($_FILES["profile_img"]["tmp_name"]) || !getimagesize($_FILES["profile_img"]["tmp_name"])) {
            $profile_img = $_POST["old_img"];
            $_SESSION['data']['profile_img'] = 'default_teacher.png';
            // return false;
        } else {
            $target_dir = dirname(__DIR__) . "/uploads/";
            $fileName = basename($_FILES["profile_img"]["name"]);
            $imageFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $newName = rand() . time() . '.' . $imageFileType;
            $target_file = $target_dir . $newName;

            // Check if file already exists
            if (file_exists($target_file)) {
                $_SESSION['errorMessages']['profile_img'] = 'Sorry, <strong>file already exists</strong>';
            }

            // Check file size
            if ($_FILES["profile_img"]["size"] > 2000000) {
                $_SESSION['errorMessages']['profile_img'] = 'Sorry, the maximum file size is <strong>2 MB</strong>';
            }

            // Allow certain file formats
            if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
                $_SESSION['errorMessages']['profile_img'] = 'Sorry, only <strong>JPG, JPEG, PNG & GIF</strong> files are allowed';
            }

            // finally move uploaded Image
            if (empty($_SESSION['errorMessages']['profile_img'])) {
                $check = move_uploaded_file($_FILES["profile_img"]["tmp_name"], $target_file);
                $profile_img = $newName;
            }
        }
    } else {
        $_SESSION['errorMessages']['profile_img'] = 'Some data are missing <strong>Please Try Again</strong>';
    }



    // check validation success and update teacher
    if (empty($_SESSION['errorMessages'])) {
        $updateQuery = "UPDATE `teachers` SET `first_name`=?,`last_name`=?,`age`=?,`phone`=?,`email`=?,`profile_img`= ?,`gender`= ?,`country_id`= ?,`city_id`= ? WHERE `id` = ?";
        $stmt = mysqli_prepare($con, $updateQuery);
        mysqli_stmt_bind_param($stmt, "ssisssiiii", $first_name, $last_name, $age, $phone, $email, $profile_img, $gender, $country_id, $city_id, $id);
        mysqli_stmt_execute($stmt);

        $_SESSION['successMessages'] = 'Profile Edited successfully';

        // if editing logged in user --> update session data
        if ($id == $_SESSION['user']['id']) {
            $_SESSION['user']['id']           =   $id;
            $_SESSION['user']['first_name']   =   $first_name;
            $_SESSION['user']['last_name']    =   $last_name;
            $_SESSION['user']['email']        =   $email;
            $_SESSION['user']['profile_img']  =   $profile_img;
        }
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
                    <h2 class="text-white font-weight-bold">Edit Teacher Profile</h2>
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

                                        <!-- First Name -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="fisrtName" class="font-weight-bold">First Name</label>
                                            <input type="text" id="fisrtName" class="form-control" placeholder="Enter Your First Name" name="first_name" value="<?= isset($_SESSION['oldData']['first_name']) ? $_SESSION['oldData']['first_name'] : (isset($teacher['first_name']) ? $teacher['first_name'] : "") ?>">
                                            <?= (isset($_SESSION['errorMessages']['first_name'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['first_name'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Last Name -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="lastName" class="font-weight-bold">Last Name</label>
                                            <input type="text" id="lastName" class="form-control" placeholder="Enter Your Last Name" name="last_name" value="<?= isset($_SESSION['oldData']['last_name']) ? $_SESSION['oldData']['last_name'] : (isset($teacher['last_name']) ? $teacher['last_name'] : "") ?>">
                                            <?= (isset($_SESSION['errorMessages']['last_name'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['last_name'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- E-mail -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="email" class="font-weight-bold">E-mail</label>
                                            <input type="text" id="email" class="form-control" placeholder="Enter Your E-mail" name="email" value="<?= isset($_SESSION['oldData']['email']) ? $_SESSION['oldData']['email'] : (isset($teacher['email']) ? $teacher['email'] : "") ?>">
                                            <?= (isset($_SESSION['errorMessages']['email'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['email'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Contact Namber -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="contactNumber" class="font-weight-bold">Contact Number</label>
                                            <input type="text" id="contactNumber" class="form-control" placeholder="Enter Your Contact Number" name="phone" value="<?= isset($_SESSION['oldData']['phone']) ? $_SESSION['oldData']['phone'] : (isset($teacher['phone']) ? $teacher['phone'] : "") ?>">
                                            <?= (isset($_SESSION['errorMessages']['phone'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['phone'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Age -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="age" class="font-weight-bold">Age</label>
                                            <input type="number" min='0' max='100' id="age" class="form-control" placeholder="Enter Your Age" name="age" value="<?= isset($_SESSION['oldData']['age']) ? $_SESSION['oldData']['age'] : (isset($teacher['age']) ? $teacher['age'] : "") ?>">
                                            <?= (isset($_SESSION['errorMessages']['age'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['age'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Gender -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="gender" class="font-weight-bold">Gender</label>
                                            <select class="form-control" name="gender" id="gender">
                                                <option class="text-muted" value="">Choose Your Gender</option>
                                                <option value="1" <?= isset($_SESSION['oldData']['gender']) && $_SESSION['oldData']['gender'] == '1' ? 'selected' : (isset($teacher['gender']) && $teacher['gender'] == '1' ? 'selected' : "") ?>>Male</option>
                                                <option value="2" <?= isset($_SESSION['oldData']['gender']) && $_SESSION['oldData']['gender'] == '2' ? 'selected' : (isset($teacher['gender']) && $teacher['gender'] == '2' ? 'selected' : "") ?>>Female</option>
                                            </select>
                                            <?= (isset($_SESSION['errorMessages']['gender'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['gender'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Country -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="country" class="font-weight-bold">Country</label>
                                            <select class="form-control" name="country_id" id="country">
                                                <option class="text-muted" value="">Choose Your Country</option>
                                                <?php
                                                while ($country = mysqli_fetch_array($countriesResults)) {
                                                    if (isset($_SESSION['oldData']['country_id']) && $_SESSION['oldData']['country_id'] == $country['id']) {
                                                        echo "<option value='$country[id]' selected>$country[name]</option>";
                                                    } elseif (isset($teacher['country_id']) && $teacher['country_id'] == $country['id']) {
                                                        echo "<option value='$country[id]' selected>$country[name]</option>";
                                                    } else {
                                                        echo "<option value='$country[id]'>$country[name]</option>";
                                                    }
                                                }
                                                ?>
                                                <?= (isset($_SESSION['errorMessages']['country_id'])) ? "<div class='badge badge-danger mt-1 mw-100'>" . $_SESSION['errorMessages']['country_id'] . "</div>" : ''; ?>
                                            </select>
                                        </div>

                                        <!-- City -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="city" class="font-weight-bold">City</label>
                                            <select class="form-control" name="city_id" id="city">
                                                <option class="text-muted" value="">Choose Your City</option>
                                            </select>
                                            <?= (isset($_SESSION['errorMessages']['city_id'])) ? "<div class='badge badge-danger mt-1 mw-100'>" . $_SESSION['errorMessages']['city_id'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Profile Image -->
                                        <div class="col-md-4 form-group text-center">
                                            <input type="hidden" name="old_img" value="<?= isset($_SESSION['oldData']['old_img']) ? $_SESSION['oldData']['old_img'] : (isset($teacher['profile_img']) ? $teacher['profile_img'] : "default_teacher.png") ?>">
                                            <label for="profileImg" class="font-weight-bold">Profile Image</label>
                                            <div class="input-group">
                                                <div class="custom-file text-primary">
                                                    <input type="file" class="custom-file-input" name="profile_img" id="profileImgInput" aria-describedby="inputGroupFileAddon01">
                                                    <label class="custom-file-label text-left" for="profileImgInput">Choose file</label>
                                                </div>
                                            </div>
                                            <div class='badge badge-warning mt-1 mw-100 text-dark font-weight-bold'>If you left it empty, the old image will be kept as it is</div>
                                            <?= (isset($_SESSION['errorMessages']['profile_img'])) ? "<div class='badge badge-danger mt-1 mw-100'>" . $_SESSION['errorMessages']['profile_img'] . "</div>" : ''; ?>
                                        </div>

                                        <div class="col-md-12 bg-danger px-2 pt-1 rounded text-center">
                                            <div class='badge badge-dark mb-1 px-1 mw-100 text-center font-weight-bold'>If you left it empty, the old password will be kept as it is</div>
                                            <div class="row">
                                                <!-- Old Password -->
                                                <div class="col-md-4 form-group text-center">
                                                    <label for="oldPassword" class="text-white font-weight-bold">Old Password</label>
                                                    <input type="password" id="oldPassword" class="form-control" placeholder="Enter Your Old Password" name="old_password" autocomplete="off">
                                                    <?= (isset($_SESSION['errorMessages']['old_password'])) ? "<div class='badge border-danger danger badge-border bg-white px-1 mt-1 mw-100'>" . $_SESSION['errorMessages']['old_password'] . "</div>" : ''; ?>
                                                </div>

                                                <!-- New Password -->
                                                <div class="col-md-4 form-group text-center">
                                                    <label for="newPassword" class="text-white font-weight-bold">New Password</label>
                                                    <input type="password" id="newPassword" class="form-control" placeholder="Enter Your New Password" name="new_password" autocomplete="off">
                                                    <?= (isset($_SESSION['errorMessages']['new_password'])) ? "<div class='badge border-danger danger badge-border bg-white px-1 mt-1 mw-100 '>" . $_SESSION['errorMessages']['new_password'] . "</div>" : ''; ?>
                                                </div>

                                                <!-- Password Confirmation -->
                                                <div class="col-md-4 form-group text-center">
                                                    <label for="passwordConfirmation" class="text-white font-weight-bold">Password Confirmation</label>
                                                    <input type="password" id="passwordConfirmation" class="form-control" placeholder="Enter Your New Password Again" name="new_password_confirmation" autocomplete="off">
                                                    <?= (isset($_SESSION['errorMessages']['new_password_confirmation'])) ? "<div class='badge border-danger danger badge-border bg-white px-1 mt-1 mw-100'>" . $_SESSION['errorMessages']['new_password_confirmation'] . "</div>" : ''; ?>
                                                </div>
                                            </div>
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
                getCities($('#country').val(), <?= isset($_SESSION['oldData']['city_id']) ? $_SESSION['oldData']['city_id'] : (isset($teacher['city_id']) ? $teacher['city_id'] : null) ?>);
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