<?php
// prerequisite variables
$title = 'Courses4U - Register';
$style =
    '.badge {
            white-space: unset;
            line-height: unset;
        }';

include(dirname(__DIR__) . '/first_project/includes/head.php');

// check if the user logged in
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role_id'] == 1) {
        header("Location: teacher/");
        exit();
    } else {
        header("Location: student/");
        exit();
    }
}

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

    $first_name = $last_name = $age = $phone = $email = $password = $gender = $country_id = $city_id = null;

    // Validate First Name
    if (isset($_POST['first_name'])) {
        $first_name = clean($_POST['first_name']);
        if (empty($first_name)) {
            $_SESSION['errorMessages']['first_name'] = 'Please enter your <strong>First Name</strong>';
        } elseif (strlen($first_name) > 50) {
            $_SESSION['errorMessages']['first_name'] = 'the maximum length of First Name is <strong>50 Characters</strong>';
            $_SESSION['oldData']['first_name'] = $first_name;
        } else {
            $_SESSION['data']['first_name'] = $first_name;
            $_SESSION['oldData']['first_name'] = $first_name;
        }
    } else {
        $_SESSION['errorMessages']['first_name'] = 'Please enter your <strong>First Name</strong>';
    }

    // Validate Last Name
    if (isset($_POST['last_name'])) {
        $last_name = clean($_POST['last_name']);
        if (empty($last_name)) {
            $_SESSION['data']['last_name'] = Null;
            $_SESSION['oldData']['last_name'] = null;
        } elseif (strlen($last_name) > 50) {
            $_SESSION['errorMessages']['last_name'] = 'the maximum length of Last Name is <strong>50 Characters</strong>';
            $_SESSION['oldData']['last_name'] = $last_name;
        } else {
            $_SESSION['data']['last_name'] = $last_name;
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
            $_SESSION['data']['email'] = $email;
            $_SESSION['oldData']['email'] = $email;
        }
    } else {
        $_SESSION['errorMessages']['email'] = 'Please enter your <strong>E-mail</strong>';
    }

    // Validate Phone
    if (isset($_POST['phone'])) {
        $phone = clean($_POST['phone']);
        if (empty($phone)) {
            $_SESSION['data']['phone'] = Null;
            $_SESSION['oldData']['phone'] = null;
        } elseif (strlen($phone) > 20) {
            $_SESSION['errorMessages']['phone'] = 'the maximum length of Phone Number is <strong>20 Number</strong>';
            $_SESSION['oldData']['phone'] = $phone;
        } else {
            $_SESSION['data']['phone'] = $phone;
            $_SESSION['oldData']['phone'] = $phone;
        }
    }

    // Validate Age
    if (isset($_POST['age'])) {
        $age = filter_var(clean($_POST['age']), FILTER_SANITIZE_NUMBER_INT);
        if (empty($age)) {
            $_SESSION['data']['age'] = 0;
            $_SESSION['oldData']['age'] = null;
        } elseif (!filter_var($age, FILTER_VALIDATE_INT)) {
            $_SESSION['errorMessages']['age'] = 'This input must contain <strong>Valid Age</strong>';
            $_SESSION['oldData']['age'] = $age;
        } else {
            $_SESSION['data']['age'] = $age;
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
            $_SESSION['data']['gender'] = $gender;
            $_SESSION['oldData']['gender'] = $gender;
        }
    } else {
        $_SESSION['errorMessages']['gender'] = 'Please Choose your <strong>Gendera</strong>';
    }

    // Validate Password
    if (isset($_POST['password'])) {
        $password = clean($_POST['password']);
        if (empty($password)) {
            $_SESSION['errorMessages']['password'] = 'Please enter <strong>Password</strong>';
        } elseif (strlen($password) < 8) {
            $_SESSION['errorMessages']['password'] = 'the length of Password must be <strong>8 Characters at least</strong>';
        } elseif (!filter_var($password, FILTER_VALIDATE_REGEXP, [
            'options' => ['regexp' => '^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$^']
        ])) {
            $_SESSION['errorMessages']['password'] = 'Your password must contain at least <strong> 8 characters</strong>, <strong>1 UPPERCASE letter</strong>, <strong>1 lowercase letter</strong>, <strong>1 number</strong> &amp; <strong>1 speci@l ch@r@cter</strong>';
        } else {
            $_SESSION['data']['password'] = sha1($password);
        }
    } else {
        $_SESSION['errorMessages']['password'] = 'Please enter <strong>Password</strong>';
    }

    // Validate Password Confirmation
    if (isset($_POST['password_confirmation'])) {
        $password_confirmation = clean($_POST['password_confirmation']);
        if (empty($password_confirmation)) {
            $_SESSION['errorMessages']['password_confirmation'] = 'Please enter the <strong>Password Again</strong>';
        } elseif ($password_confirmation !== $password) {
            $_SESSION['errorMessages']['password_confirmation'] = 'the two passwords <strong>Didn\'t Match</strong>';
        } else {
            $_SESSION['data']['password_confirmation'] = $password_confirmation;
        }
    } else {
        $_SESSION['errorMessages']['password_confirmation'] = 'Please enter the <strong>Password Again</strong>';
    }

    // Validate Country
    if (isset($_POST['country_id'])) {
        $country_id = clean($_POST['country_id']);
        if (!filter_var($country_id, FILTER_VALIDATE_INT)) {
            $_SESSION['errorMessages']['country_id'] = 'Please Choose your <strong>Country</strong>';
            $_SESSION['oldData']['country_id'] = $country_id;
        } else {
            $_SESSION['data']['country_id'] = $country_id;
            $_SESSION['oldData']['country_id'] = $country_id;
        }
    } else {
        $_SESSION['errorMessages']['country_id'] = 'Please Choose your <strong>Country</strong>';
    }

    // Validate City
    if (isset($_POST['city_id'])) {
        $city_id = clean($_POST['city_id']);
        if (empty($city_id)) {
            $_SESSION['data']['city_id'] = Null;
            $_SESSION['oldData']['city_id'] = null;
        } elseif (!filter_var($city_id, FILTER_VALIDATE_INT)) {
            $_SESSION['errorMessages']['city_id'] = 'Please Choose your <strong>City</strong>';
            $_SESSION['oldData']['city_id'] = $city_id;
        } else {
            $_SESSION['data']['city_id'] = $city_id;
            $_SESSION['oldData']['city_id'] = $city_id;
        }
    }

    // Validate Role
    if (isset($_POST['role_id'])) {
        $role_id = clean($_POST['role_id']);
        if (empty($role_id)) {
            $_SESSION['errorMessages']['role_id'] = 'Please Choose your <strong>Role</strong>';
        } elseif (!filter_var($role_id, FILTER_VALIDATE_INT)) {
            $_SESSION['errorMessages']['role_id'] = 'Please Choose your <strong>Role</strong>';
            $_SESSION['oldData']['role_id'] = $role_id;
        } elseif (!in_array($role_id, [1, 2])) {
            $_SESSION['errorMessages']['role_id'] = 'Please Choose your <strong>Role</strong>';
            $_SESSION['oldData']['role_id'] = $role_id;
        } else {
            $_SESSION['data']['role_id'] = $role_id;
            $_SESSION['oldData']['role_id'] = $role_id;
        }
    } else {
        $_SESSION['errorMessages']['role_id'] = 'Please Choose your <strong>Role</strong>';
    }

    if (isset($_FILES["profile_img"])) {
        // print_r($_FILES["profile_img"]);

        // Check if image file is a actual image or fake image
        if (empty($_FILES["profile_img"]["tmp_name"]) || !getimagesize($_FILES["profile_img"]["tmp_name"])) {
            if (isset($_SESSION['data']['role_id']) && $_SESSION['data']['role_id'] == 1) {
                $_SESSION['data']['profile_img'] = 'default_teacher.png	';
            } else {
                $_SESSION['data']['profile_img'] = 'default_student.png	';
            }
        } else {
            $target_dir = dirname(__DIR__) ."/first_project/uploads/";
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
                $_SESSION['data']['profile_img'] = $newName;
                if (!$check) {
                    // print_r($check);
                    // return false;
                }
            }
        }
    } else {
        if ($_SESSION['data']['role_id'] == 1) {
            $_SESSION['data']['profile_img'] = 'default_teacher.png	';
        } else {
            $_SESSION['data']['profile_img'] = 'default_student.png	';
        }
    }

    // check validation success and insert user
    if (empty($_SESSION['errorMessages'])) {
        if ($_SESSION['data']['role_id'] == 1) {
            $insertQuery = "INSERT INTO `teachers`(`first_name`, `last_name`, `age`, `phone`, `email`, `password`, `gender`, `country_id`, `city_id`, `profile_img`) VALUES (?,?,?,?,?,?,?,?,?,?)";
        } else {
            $insertQuery = "INSERT INTO `students`(`first_name`, `last_name`, `age`, `phone`, `email`, `password`, `gender`, `country_id`, `city_id`, `profile_img`) VALUES (?,?,?,?,?,?,?,?,?,?)";
        }
        $stmt = mysqli_prepare($con, $insertQuery);
        mysqli_stmt_bind_param($stmt, "ssisssiiis", $_SESSION['data']['first_name'], $_SESSION['data']['last_name'], $_SESSION['data']['age'], $_SESSION['data']['phone'], $_SESSION['data']['email'], $_SESSION['data']['password'], $_SESSION['data']['gender'], $_SESSION['data']['country_id'], $_SESSION['data']['city_id'], $_SESSION['data']['profile_img']);
        mysqli_stmt_execute($stmt);

        // check insert success
        if ($stmt) {

            $_SESSION['successMessages'] = 'You registered successfully';

            // create login session
            $_SESSION['user']['id']           =   mysqli_insert_id($con);
            $_SESSION['user']['first_name']   =   $_SESSION['data']['first_name'];
            $_SESSION['user']['last_name']    =   $_SESSION['data']['last_name'];
            $_SESSION['user']['email']        =   $_SESSION['data']['email'];
            $_SESSION['user']['profile_img']  =   $_SESSION['data']['profile_img'];
            $_SESSION['user']['role_id']      =   $_SESSION['data']['role_id'];


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
            if ($_SESSION['user']['role_id'] == 1) {
                header("Location: teacher/");
                exit();
            } else {
                header("Location: student/");
                exit();
            }
        }
    }
}

?>

<body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-color="bg-chartbg" data-col="2-columns">
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <!-- Top Bar-->
    <?php
    include(dirname(__DIR__) .'/first_project/includes/top-bar.php');
    ?>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <!-- Side Bar -->
    <div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true" data-img="theme-assets/images/backgrounds/02.jpg">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item m-auto text-center"><a class="navbar-brand" href="/nti/first_project/"><img class="brand-logo" alt="Chameleon admin logo" src="theme-assets/images/logo/logo.png" />
                        <h3 class="brand-text">Courses<span class="text-danger">4</span><span class="text-primary">U</span></h3>
                    </a></li>
                <li class="nav-item d-md-none"><a class="nav-link close-navbar"><i class="ft-x"></i></a></li>
            </ul>
        </div>
        <!-- <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item"><a href="index.html"><i class="ft-pie-chart"></i><span class="menu-title" data-i18n="">Dashboard</span></a>
                </li>
                <li class="nav-item"><a href="charts.html"><i class="ft-home"></i><span class="menu-title" data-i18n="">Home</span></a>
                </li>
            </ul>
        </div> -->
        <div class="navigation-background"></div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-wrapper-before"></div>
            <div class="content-header row">
                <div class="col-12 text-center my-2">
                    <h2 class="text-white font-weight-bold">Register Form</h2>
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
                                            <input type="text" id="fisrtName" class="form-control" placeholder="Enter Your First Name" name="first_name" value=<?= isset($_SESSION['oldData']['first_name']) ? '"' .  $_SESSION['oldData']['first_name'] . '"' : "" ?> required>
                                            <?= (isset($_SESSION['errorMessages']['first_name'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['first_name'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Last Name -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="lastName" class="font-weight-bold">Last Name</label>
                                            <input type="text" id="lastName" class="form-control" placeholder="Enter Your Last Name" name="last_name" value=<?= isset($_SESSION['oldData']['last_name']) ? '"' .  $_SESSION['oldData']['last_name'] . '"' : "" ?>>
                                            <?= (isset($_SESSION['errorMessages']['last_name'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['last_name'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- E-mail -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="email" class="font-weight-bold">E-mail</label>
                                            <input type="text" id="email" class="form-control" placeholder="Enter Your E-mail" name="email" value=<?= isset($_SESSION['oldData']['email']) ? '"' .  $_SESSION['oldData']['email'] . '"' : "" ?> required>
                                            <?= (isset($_SESSION['errorMessages']['email'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['email'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Contact Namber -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="contactNumber" class="font-weight-bold">Contact Number</label>
                                            <input type="text" id="contactNumber" class="form-control" placeholder="Enter Your Contact Number" name="phone" value=<?= isset($_SESSION['oldData']['phone']) ? '"' .  $_SESSION['oldData']['phone'] . '"' : "" ?>>
                                            <?= (isset($_SESSION['errorMessages']['phone'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['phone'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Age -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="age" class="font-weight-bold">Age</label>
                                            <input type="number" min='0' max='100' id="age" class="form-control" placeholder="Enter Your Age" name="age" value=<?= isset($_SESSION['oldData']['age']) ? '"' .  $_SESSION['oldData']['age'] . '"' : "" ?>>
                                            <?= (isset($_SESSION['errorMessages']['age'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['age'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Gender -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="gender" class="font-weight-bold">Gender</label>
                                            <select class="form-control" name="gender" id="gender" required>
                                                <option class="text-muted" value="">Choose Your Gender</option>
                                                <option value="1" <?= isset($_SESSION['oldData']['gender']) && $_SESSION['oldData']['gender'] == '1' ? 'selected' : '' ?>>Male</option>
                                                <option value="2" <?= isset($_SESSION['oldData']['gender']) && $_SESSION['oldData']['gender'] == '2' ? 'selected' : '' ?>>Female</option>
                                            </select>
                                            <?= (isset($_SESSION['errorMessages']['gender'])) ? "<div class='badge badge-danger mt-1'>" . $_SESSION['errorMessages']['gender'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Password -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="password" class="font-weight-bold">Password</label>
                                            <input type="password" id="password" class="form-control" placeholder="Enter Your Password" name="password" required>
                                            <?= (isset($_SESSION['errorMessages']['password'])) ? "<div class='badge badge-danger mt-1 mw-100'>" . $_SESSION['errorMessages']['password'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Password Confirmation -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="passwordConfirmation" class="font-weight-bold">Password Confirmation</label>
                                            <input type="password" id="passwordConfirmation" class="form-control" placeholder="Enter Your Password Again" name="password_confirmation" required>
                                            <?= (isset($_SESSION['errorMessages']['password_confirmation'])) ? "<div class='badge badge-danger mt-1 mw-100'>" . $_SESSION['errorMessages']['password_confirmation'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Role -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="role" class="font-weight-bold">Role</label>
                                            <select class="form-control" name="role_id" id="role" required>
                                                <option class="text-muted" value="">Teacher or Student</option>
                                                <option value="1" <?= isset($_SESSION['oldData']['role_id']) && $_SESSION['oldData']['role_id'] == '1' ? 'selected' : '' ?>>Teacher</option>
                                                <option value="2" <?= isset($_SESSION['oldData']['role_id']) && $_SESSION['oldData']['role_id'] == '2' ? 'selected' : '' ?>>Student</option>
                                            </select>
                                            <?= (isset($_SESSION['errorMessages']['role_id'])) ? "<div class='badge badge-danger mt-1 mw-100'>" . $_SESSION['errorMessages']['role_id'] . "</div>" : ''; ?>
                                        </div>

                                        <!-- Country -->
                                        <div class="col-md-4 form-group text-center">
                                            <label for="country" class="font-weight-bold">Country</label>
                                            <select class="form-control" name="country_id" id="country" required>
                                                <option class="text-muted" value="">Choose Your Country</option>
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
                                                <option class="text-muted" value="">Choose Your City</option>
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
    include(dirname(__DIR__) . '/first_project/includes/footer.php');
    ?>

    <?php
    include(dirname(__DIR__) . '/first_project/includes/scripts.php');
    ?>

    <script>
        $(function() {

            // Get Cities by ajax function 
            function getCities(country_id, selected = null) {
                $('#city').html(`<option class="text-muted" value="">Choose Your City</option>`);

                $.ajax({
                    url: 'ajax/getCity.php',
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