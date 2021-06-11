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

    // validation of Password field 
    if (isset($_POST['password'])) {
        $password = clean($_POST['password']);

        if (empty($password)) {
            $_SESSION['errorMessages']['password'] = 'Please enter your password before submit';
        } elseif (!filter_var($password, FILTER_VALIDATE_REGEXP, [
            'options' => ['regexp' => '^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$^']
        ])) {
            $_SESSION['errorMessages']['password'] = 'Your password must contain at least <strong> 8 characters</strong>, <strong>1 UPPERCASE letter</strong>, <strong>1 lowercase letter</strong>, <strong>1 number</strong> &amp; <strong>1 speci@l ch@r@cter</strong>';
        }
    }

    // validation of Address field 
    if (isset($_POST['address'])) {
        $address = clean($_POST['address']);
        if (empty($address)) {
            $_SESSION['errorMessages']['address'] = 'Please enter your address before submit';
        } else {
            $_SESSION['user']['address'] = $address;
            $_SESSION['errorData']['address'] = $address;
        }
    }


    // validation of Gender field 
    if (isset($_POST['gender'])) {
        $gender = clean($_POST['gender']);

        if (!in_array($gender, ['male', 'female'])) {
            $_SESSION['errorMessages']['gender'] = 'Please choose your gender before submit';
        } else {
            $_SESSION['user']['gender'] = $gender;
            $_SESSION['errorData']['gender'] = $gender;
        }
    } else {
        $_SESSION['errorMessages']['gender'] = 'Please choose your gender before submit';
    }

    // validation of URL field 
    if (isset($_POST['linkedIn'])) {
        $linkedIn = clean($_POST['linkedIn']);

        if (empty($linkedIn)) {
            $_SESSION['errorMessages']['linkedIn'] = 'Please enter your linkedIn url before submit';
        } elseif (!filter_var($linkedIn, FILTER_VALIDATE_URL)) {
            $_SESSION['errorMessages']['linkedIn'] = 'You entered invalid linkedIn url, Please try again';
            $_SESSION['errorData']['linkedIn'] = $linkedIn;
        } else {
            $_SESSION['user']['linkedIn'] = $linkedIn;
            $_SESSION['errorData']['linkedIn'] = $linkedIn;
        }
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
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">

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

                    <!-- Password -->
                    <div class="form-group">
                        <label> Password </label>
                        <div>
                            <input type="password" <?= (isset($_SESSION['errorMessages']['password'])) ? "class='error'" : "class='success'"; ?> name="password" placeholder="Please enter your password">
                            <?= (isset($_SESSION['errorMessages']['password'])) ? "<p class='errorMessage'>" . $_SESSION['errorMessages']['password'] . "</p>" : ''; ?>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="form-group">
                        <label> Address </label>
                        <div>
                            <input type="text" <?= (isset($_SESSION['errorMessages']['address'])) ? "class='error'" : "class='success'"; ?> <?= (isset($_SESSION['errorData']['address'])) ? "value='" . $_SESSION['errorData']['address'] . "'" : ''; ?> name="address" placeholder="Please enter your address">
                            <?= (isset($_SESSION['errorMessages']['address'])) ? "<p class='errorMessage'>" . $_SESSION['errorMessages']['address'] . "</p>" : ''; ?>
                        </div>
                    </div>

                    <!-- Gender -->
                    <div class="form-group">
                        <label> Gender </label>
                        <div>
                            <div class="radio-group">
                                <label>Male
                                    <input type="radio" name="gender" value="male" <?= (isset($_SESSION['errorData']['gender']) && $_SESSION['errorData']['gender'] == 'female') ? "" : 'checked'; ?>>
                                </label>
                                <label>Female
                                    <input type="radio" name="gender" value="female" <?= (isset($_SESSION['errorData']['gender']) && $_SESSION['errorData']['gender'] == 'female') ? "checked" : ''; ?>>
                                </label>
                            </div>
                            <?= (isset($_SESSION['errorMessages']['gender'])) ? "<p class='errorMessage'>" . $_SESSION['errorMessages']['gender'] . "</p>" : ''; ?>
                        </div>
                    </div>

                    <!-- LinkedIn -->
                    <div class="form-group">
                        <label> LinkedIn url </label>
                        <div>
                            <input type="text" <?= (isset($_SESSION['errorMessages']['linkedIn'])) ? "class='error'" : "class='success'"; ?> <?= (isset($_SESSION['errorData']['linkedIn'])) ? "value='" . $_SESSION['errorData']['linkedIn'] . "'" : ''; ?> name="linkedIn" placeholder="Please enter your LinkedIn url">
                            <?= (isset($_SESSION['errorMessages']['linkedIn'])) ? "<p class='errorMessage'>" . $_SESSION['errorMessages']['linkedIn'] . "</p>" : ''; ?>
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