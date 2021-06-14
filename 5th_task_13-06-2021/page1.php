<?php

session_start();

// Declaration of cleaning function
function clean($request)
{
    $request = htmlspecialchars($request);
    $request = trim($request);
    $request = stripcslashes($request);

    return $request;
}

// check if there is incame request
if ($_POST) {

    // validation of Name field 
    if (isset($_POST['name'])) {
        $name = clean($_POST['name']);
        if (empty($name)) {
            $_SESSION['errorMessages']['name'] = 'Please enter your name before submit';
        } else {
            $_SESSION['user']['name'] = $name;
            $_SESSION['errorData']['name'] = $name;
        }
    }

    // validation of E-mail field 
    if (isset($_POST['email'])) {
        $email = clean($_POST['email']);

        if (empty($email)) {
            $_SESSION['errorMessages']['email'] = 'Please enter your e-mail before submit';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['errorMessages']['email'] = 'You entered invalid e-mail, Please try again';
            $_SESSION['errorData']['email'] = $email;
        } else {
            $_SESSION['user']['email'] = $email;
            $_SESSION['errorData']['email'] = $email;
        }
    }

    // validation of Title field 
    if (isset($_POST['title'])) {
        $title = clean($_POST['title']);
        if (empty($title)) {
            $_SESSION['errorMessages']['title'] = 'Please enter your title before submit';
        } else {
            $_SESSION['user']['title'] = $title;
            $_SESSION['errorData']['title'] = $title;
        }
    }

    // Validation of CV field
    if (isset($_FILES['cv']) && $_FILES['cv']['size'] > 0) {
        $filePath       = 'uploads/';
        $fileTempPath   = $_FILES['cv']['tmp_name'];
        $fileName       = $_FILES['cv']['name'];
        $filetype       = $_FILES['cv']['type'];
        
        $completePath   = $filePath . time() . rand(1000,9999999) . basename($fileName);
        $fileType       = strtolower(pathinfo($completePath,PATHINFO_EXTENSION));

        if ($fileType == 'pdf') {
            move_uploaded_file($fileTempPath, $completePath);
            $_SESSION['user']['cv'] = $completePath;
        } else {
            $_SESSION['errorMessages']['cv'] = 'Please upload your C.V as PDF file';
        }
    } else {
        $_SESSION['errorMessages']['cv'] = 'Please upload your C.V before submit';
    }

}

if (!isset($_SESSION['errorMessages'])) {
    unset($_SESSION['errorData']);
} else {
    unset($_SESSION['user']);
}

?>
<!-- Create 2 php files one of them has a form with the following inputs (name, email, password, address, gender, linkedin url) Validate inputs then store data into session, when user open the second file can show stored data. -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page 1</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100vw;
            margin: 0;
        }

        .form-div {
            margin-top: 1em;
            margin-bottom: 1em;
            background-color: #2980b9;
            box-shadow: 0px 0px 43px -10px rgba(0, 0, 0, 0.5);
            -webkit-box-shadow: 0px 0px 43px -10px rgba(0, 0, 0, 0.5);
            -moz-box-shadow: 0px 0px 43px -10px rgba(0, 0, 0, 0.5);
            padding: 1em 2em;
            border-radius: 20px;
        }

        .form-div h2 {
            margin: auto;
            margin-bottom: 0.75em;
            text-align: center;
            color: white;
        }

        .form-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 0.75em auto;
        }

        .form-group>label {
            font-size: 1.2em;
            font-weight: bold;
            color: #fff;
            margin-right: 1em;
        }

        .form-group>button {
            font-size: 1em;
            font-weight: bold;
            color: #fff;
            background-color: #3498db;
            padding: 0.5em 1em;
            text-align: center;
            margin: 1em auto 0.5em;
            border-radius: 5px;
            border: 0;
            transition: all 0.3s ease-in-out;
            cursor: pointer;
        }

        .form-group>button:hover {
            background-color: #27ae60;
        }

        .radio-group {
            display: flex;
            justify-content: space-between;
            width: 50%;
            color: #fff;
            width: 300px;
        }

        .radio-group>label {
            font-weight: bold;
            cursor: pointer;
            margin: auto 2em;
        }

        .form-group input:not([type='radio']) {
            padding: 0.75em;
            border-radius: 10px;
            outline: none;
            border: 0;
            width: 300px;
            text-align: center;
        }

        .form-group input:not([type='radio']).error {
            border: 3px solid #ff7979;
        }

        .form-group input:not([type='radio']).success {
            border: 3px solid #3498db;
        }

        .errorMessage {
            border-radius: 2px;
            border: 1px solid #fff;
            background-color: #ff7979;
            padding: 0.5em;
            margin-top: 0.25em;
            color: #fff;
            font-size: 0.75em;
            text-align: center;
            max-width: 300px;
            border-radius: 20px;
        }

        .successMessage {
            border-radius: 2px;
            border: 1px solid #fff;
            background-color: #27ae60;
            padding: 0.5em;
            margin-top: 0.25em;
            color: #fff;
            font-size: 1.5em;
            text-align: center;
            border-radius: 20px;
        }
    </style>
</head>

<body>
    <div class="container">

        <?php
        if (isset($_SESSION['user'])) {
            echo "<p class='successMessage'> You regestered &amp; loged in successfully, you'll be directed to page 2 after 5 seconds </p>";
            header( "refresh:5;url=page2.php" );
            exit();
        } else {
        ?>

            <div class="form-div">
                <h2>Input Form</h2>
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">

                    <!-- Name -->
                    <div class="form-group">
                        <label> Name </label>
                        <div>
                            <input type="text" <?= (isset($_SESSION['errorMessages']['name'])) ? "class='error'" : "class='success'"; ?> <?= (isset($_SESSION['errorData']['name'])) ? "value='" . $_SESSION['errorData']['name'] . "'" : ''; ?> name="name" placeholder="Please enter your name">
                            <?= (isset($_SESSION['errorMessages']['name'])) ? "<p class='errorMessage'>" . $_SESSION['errorMessages']['name'] . "</p>" : ''; ?>

                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label> E-Mail </label>
                        <div>
                            <input type="mail" <?= (isset($_SESSION['errorMessages']['email'])) ? "class='error'" : "class='success'"; ?> <?= (isset($_SESSION['errorData']['email'])) ? "value='" . $_SESSION['errorData']['email'] . "'" : ''; ?> name="email" placeholder="Please enter your email">
                            <?= (isset($_SESSION['errorMessages']['email'])) ? "<p class='errorMessage'>" . $_SESSION['errorMessages']['email'] . "</p>" : ''; ?>
                        </div>
                    </div>

                    <!-- Title -->
                    <div class="form-group">
                        <label> Title </label>
                        <div>
                            <input type="text" <?= (isset($_SESSION['errorMessages']['title'])) ? "class='error'" : "class='success'"; ?> <?= (isset($_SESSION['errorData']['title'])) ? "value='" . $_SESSION['errorData']['title'] . "'" : ''; ?> name="title" placeholder="Please enter your title">
                            <?= (isset($_SESSION['errorMessages']['title'])) ? "<p class='errorMessage'>" . $_SESSION['errorMessages']['title'] . "</p>" : ''; ?>
                        </div>
                    </div>

                    <!-- CV -->
                    <div class="form-group">
                        <label> C.V </label>
                        <div>
                            <input type="file" name="cv" id="" placeholder="Please enter your CV">
                            <!-- <input type="text" <?= (isset($_SESSION['errorMessages']['cv'])) ? "class='error'" : "class='success'"; ?> <?= (isset($_SESSION['errorData']['cv'])) ? "value='" . $_SESSION['errorData']['cv'] . "'" : ''; ?> name="cv" placeholder="Please enter your CV"> -->
                            <?= (isset($_SESSION['errorMessages']['cv'])) ? "<p class='errorMessage'>" . $_SESSION['errorMessages']['cv'] . "</p>" : ''; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit"> Send Request </button>
                    </div>

                </form>
            </div>
        <?php } ?>
    </div>

</body>

</html>

<?php

if (isset($_SESSION['errorMessages'])) {
    unset($_SESSION['errorMessages']);
}
if (isset($_SESSION['errorData'])) {
    unset($_SESSION['errorData']);
}


?>