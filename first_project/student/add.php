<?php
// prerequisite variables
$addStudent = true;

$title = 'Courses4U - Add New Student';

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

    $first_name = $last_name = $age = $phone = $email =  $gender = $country_id = $city_id = null;
    $password = sha1('Abc@1234');

    // Validate First Name
    if (isset($_POST['first_name'])) {
        $first_name = clean($_POST['first_name']);
        if (empty($first_name)) {
            $_SESSION['errorMessages']['first_name'] = 'Please enter the <strong>First Name</strong>';
        } elseif (strlen($first_name) > 50) {
            $_SESSION['errorMessages']['first_name'] = 'the maximum length of First Name is <strong>50 Characters</strong>';
            $_SESSION['oldData']['first_name'] = $first_name;
        } else {
            $_SESSION['oldData']['first_name'] = $first_name;
        }
    } else {
        $_SESSION['errorMessages']['first_name'] = 'Please enter the <strong>First Name</strong>';
    }

    // Validate Last Name
    if (isset($_POST['last_name'])) {
        $last_name = clean($_POST['last_name']);
        if (empty($last_name)) {
            $last_name = Null;
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
            $_SESSION['errorMessages']['email'] = 'Please enter the <strong>E-mail</strong>';
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
        $_SESSION['errorMessages']['email'] = 'Please enter the <strong>E-mail</strong>';
    }

    // Validate Phone
    if (isset($_POST['phone'])) {
        $phone = clean($_POST['phone']);
        if (empty($phone)) {
            $phone = Null;
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
            $_SESSION['errorMessages']['gender'] = 'Please Choose the <strong>Gendera</strong>';
        } elseif (!filter_var($gender, FILTER_VALIDATE_INT)) {
            $_SESSION['errorMessages']['gender'] = 'Please Choose the <strong>Genderb</strong>';
            $_SESSION['oldData']['gender'] = $gender;
        } elseif (!in_array($gender, [1, 2])) {
            $_SESSION['errorMessages']['gender'] = 'Please Choose the <strong>Genderc</strong>';
            $_SESSION['oldData']['gender'] = $gender;
        } else {
            $_SESSION['oldData']['gender'] = $gender;
        }
    } else {
        $_SESSION['errorMessages']['gender'] = 'Please Choose the <strong>Gendera</strong>';
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

    // Validate City
    if (isset($_POST['city_id'])) {
        $city_id = clean($_POST['city_id']);
        if (empty($city_id)) {
            $city_id = Null;
            $_SESSION['oldData']['city_id'] = null;
        } elseif (!filter_var($city_id, FILTER_VALIDATE_INT)) {
            $_SESSION['errorMessages']['city_id'] = 'Please Choose the <strong>City</strong>';
            $_SESSION['oldData']['city_id'] = $city_id;
        } else {
            $_SESSION['oldData']['city_id'] = $city_id;
        }
    }

    if (isset($_FILES["profile_img"])) {

        // Check if image file is a actual image or fake image
        if (empty($_FILES["profile_img"]["tmp_name"]) || !getimagesize($_FILES["profile_img"]["tmp_name"])) {
            $profile_img = 'default_student.png	';
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
        $profile_img = 'default_student.png	';
    }

    // check validation success and insert user
    if (empty($_SESSION['errorMessages'])) {
        $insertQuery = "INSERT INTO `students`(`first_name`, `last_name`, `age`, `phone`, `email`, `password`, `gender`, `country_id`, `city_id`, `profile_img`) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $stmt = mysqli_prepare($con, $insertQuery);
        mysqli_stmt_bind_param($stmt, "ssisssiiis", $first_name, $last_name, $age, $phone, $email, $password, $gender, $country_id, $city_id, $profile_img);
        mysqli_stmt_execute($stmt);

        // check insert success
        if ($stmt) {

            $_SESSION['successMessages'] = 'New Student Added successfully';

            // clear session data and error messages
            if (isset($_SESSION['errorMessages'])) {
                unset($_SESSION['errorMessages']);
            }
            if (isset($_SESSION['oldData'])) {
                unset($_SESSION['oldData']);
            }
            if (isset($_SESSION['data'])) {
                unset($_SESSION['data']);
            }

            // redirect to home page
            header("Location: /nti/first_project/student/all.php");
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
                    <h2 class="text-white font-weight-bold">Add New Student</h2>
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

                                        <!-- First Name -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="fisrtName" class="font-weight-bold">First Name</label>
                                            <input type="text" id="fisrtName" class="form-control" placeholder="Enter First Name" name="first_name" value=<?= isset($_SESSION['oldData']['first_name']) ? '"' .  $_SESSION['oldData']['first_name'] . '"' : "" ?>>
                                            <?= (isset($_SESSION['errorMessages']['first_name'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['first_name'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Last Name -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="lastName" class="font-weight-bold">Last Name</label>
                                            <input type="text" id="lastName" class="form-control" placeholder="Enter Last Name" name="last_name" value=<?= isset($_SESSION['oldData']['last_name']) ? '"' .  $_SESSION['oldData']['last_name'] . '"' : "" ?>>
                                            <?= (isset($_SESSION['errorMessages']['last_name'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['last_name'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- E-mail -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="email" class="font-weight-bold">E-mail</label>
                                            <input type="text" id="email" class="form-control" placeholder="Enter E-mail" name="email" value=<?= isset($_SESSION['oldData']['email']) ? '"' .  $_SESSION['oldData']['email'] . '"' : "" ?>>
                                            <?= (isset($_SESSION['errorMessages']['email'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['email'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Contact Namber -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="contactNumber" class="font-weight-bold">Contact Number</label>
                                            <input type="text" id="contactNumber" class="form-control" placeholder="Enter Contact Number" name="phone" value=<?= isset($_SESSION['oldData']['phone']) ? '"' .  $_SESSION['oldData']['phone'] . '"' : "" ?>>
                                            <?= (isset($_SESSION['errorMessages']['phone'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['phone'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Age -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="age" class="font-weight-bold">Age</label>
                                            <input type="number" min='0' max='100' id="age" class="form-control" placeholder="Enter Age" name="age" value=<?= isset($_SESSION['oldData']['age']) ? '"' .  $_SESSION['oldData']['age'] . '"' : "" ?>>
                                            <?= (isset($_SESSION['errorMessages']['age'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['age'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Gender -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="gender" class="font-weight-bold">Gender</label>
                                            <select class="form-control" name="gender" id="gender">
                                                <option class="text-muted" value="">Choose Gender</option>
                                                <option value="1" <?= isset($_SESSION['oldData']['gender']) && $_SESSION['oldData']['gender'] == '1' ? 'selected' : '' ?>>Male</option>
                                                <option value="2" <?= isset($_SESSION['oldData']['gender']) && $_SESSION['oldData']['gender'] == '2' ? 'selected' : '' ?>>Female</option>
                                            </select>
                                            <?= (isset($_SESSION['errorMessages']['gender'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['gender'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Country -->
                                        <div class="col-md-4 form-group text-center">
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

                                        <!-- City -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="city" class="font-weight-bold">City</label>
                                            <select class="form-control" name="city_id" id="city">
                                                <option class="text-muted" value="">Choose City</option>
                                            </select>
                                            <?= (isset($_SESSION['errorMessages']['city_id'])) ? "<div class='badge badge-danger mt-1 mw-100'>" . $_SESSION['errorMessages']['city_id'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Profile Image -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="profileImg" class="font-weight-bold">Profile Image</label>
                                            <div class="input-group">
                                                <div class="custom-file text-primary">
                                                    <input type="file" class="custom-file-input" name="profile_img" id="profileImgInput" aria-describedby="inputGroupFileAddon01">
                                                    <label class="custom-file-label text-left" for="profileImgInput">Choose file</label>
                                                </div>
                                            </div>
                                            <?= (isset($_SESSION['errorMessages']['profile_img'])) ? "<div class='badge badge-danger mt-1 mw-100'>" . $_SESSION['errorMessages']['profile_img'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Passwort default warning -->
                                        <div class="col-md-12 text-center">
                                            <div class='badge badge-warning text-dark px-1 mt-1 mw-100'> The default Password is <span class="font-weight-bold">'Abc@1234'</span> </div>
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

            // Get cities on bage load
            if ($('#country').val()) {
                getCities($('#country').val(), <?= isset($_SESSION['oldData']['city_id']) ? $_SESSION['oldData']['city_id'] : null ?>);
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