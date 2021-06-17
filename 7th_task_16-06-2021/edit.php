<?php
require('con.php');

// Declaration of cleaning function
function clean($request)
{
    $request = htmlspecialchars($request);
    $request = trim($request);
    $request = stripcslashes($request);

    return $request;
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (filter_var($_REQUEST['id'], FILTER_VALIDATE_INT)) {
        $id = filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT);

        $query = "SELECT * FROM `products` WHERE id = $id";

        $run = mysqli_query($con, $query);

        if ($run->num_rows < 1) {
            $_SESSION['errorMessage'] = 'Please choose the right product first';

            header("Location:index.php");
        } else {
            $result = mysqli_fetch_assoc($run);
        }
    }
}

// check if there is incame request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // validation of ID field 
    if (isset($_POST['id'])) {
        $id = clean($_POST['id']);

        if (empty($id)) {
            $_SESSION['errorMessages']['id'] = 'Please enter product\'s id before submit';
        } else {
            $_SESSION['errorData']['id'] = $id;
        }
    }

    // validation of Name field 
    if (isset($_POST['name'])) {
        $name = clean($_POST['name']);

        if (empty($name)) {
            $_SESSION['errorMessages']['name'] = 'Please enter product\'s name before submit';
        } else {
            $_SESSION['errorData']['name'] = $name;
        }
    }

    // validation of Price field 
    if (isset($_POST['price'])) {
        $price = clean($_POST['price']);

        if (empty($price)) {
            $_SESSION['errorMessages']['price'] = 'Please enter product\'s price before submit';
        } elseif (!filter_var($price, FILTER_VALIDATE_INT)) {
            $_SESSION['errorMessages']['price'] = 'You entered invalid price, Please try again';
            $_SESSION['errorData']['price'] = $price;
        } elseif ($price < 0) {
            $_SESSION['errorMessages']['price'] = 'Price must be greater than 0 EGP';
            $_SESSION['errorData']['price'] = $price;
        } else {
            $_SESSION['errorData']['price'] = $price;
        }
    }

    // validation of Code field 
    if (isset($_POST['code'])) {
        $code = clean($_POST['code']);

        if (empty($code)) {
            $_SESSION['errorMessages']['code'] = 'Please enter product\'s code before submit';
        } else {
            $_SESSION['errorData']['code'] = $code;
        }
    }

    // validation of Category field 
    if (isset($_POST['category'])) {
        $category = clean($_POST['category']);
        if (empty($category)) {
            $_SESSION['errorMessages']['category'] = 'Please enter product\'s category before submit';
        } else {
            $_SESSION['errorData']['category'] = $category;
        }
    }

    if (empty($_SESSION['errorMessages'])) {
        $query = "UPDATE `products` SET `name`='$name',`price`=$price,`code`='$code',`category`='$category' WHERE id = $id";

        $run = mysqli_query($con, $query);

        if ($run) {
            $_SESSION['successMessage'] = 'Product has been updated successfully';

            header("Location:index.php");
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
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

        <div class="form-div">
            <h2>Edit Form</h2>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">

                <!-- id -->
                <div class="form-group">
                    <div>
                        <input type="hidden" value='<?= (isset($_SESSION['errorData']['id'])) ? $_SESSION['errorData']['id'] : (isset($result) ? $result['id'] : ''); ?>' name="id">
                    </div>
                </div>


                <!-- Name -->
                <div class="form-group">
                    <label> Product Name </label>
                    <div>
                        <input type="text" class='<?= (isset($_SESSION['errorMessages']['name'])) ? "error" : "success"; ?>' value='<?= (isset($_SESSION['errorData']['name'])) ? $_SESSION['errorData']['name'] : (isset($result) ? $result['name'] : ''); ?>' name="name" placeholder="Please enter product's name">
                        <?= (isset($_SESSION['errorMessages']['name'])) ? "<p class='errorMessage'>" . $_SESSION['errorMessages']['name'] . "</p>" : ''; ?>
                    </div>
                </div>

                <!-- Price -->
                <div class="form-group">
                    <label> Price </label>
                    <div>
                        <input type="number" class='<?= (isset($_SESSION['errorMessages']['price'])) ? "error" : "success"; ?>' value=<?= (isset($_SESSION['errorData']['price'])) ? $_SESSION['errorData']['price'] : (isset($result) ? $result['price'] : "0"); ?> name="price" placeholder="Please enter product's price">
                        <?= (isset($_SESSION['errorMessages']['price'])) ? "<p class='errorMessage'>" . $_SESSION['errorMessages']['price'] . "</p>" : ''; ?>
                    </div>
                </div>

                <!-- Code -->
                <div class="form-group">
                    <label> Code </label>
                    <div>
                        <input type="text" class='<?= (isset($_SESSION['errorMessages']['code'])) ? "error" : "success"; ?>' value='<?= (isset($_SESSION['errorData']['code'])) ? $_SESSION['errorData']['code'] : (isset($result) ? $result['code'] : ''); ?>' name="code" placeholder="Please enter product's code">
                        <?= (isset($_SESSION['errorMessages']['code'])) ? "<p class='errorMessage'>" . $_SESSION['errorMessages']['code'] . "</p>" : ''; ?>
                    </div>
                </div>

                <!-- Category -->
                <div class="form-group">
                    <label> Category </label>
                    <div>
                        <input type="text" class='<?= (isset($_SESSION['errorMessages']['category'])) ? "error" : "success"; ?>' value='<?= (isset($_SESSION['errorData']['category'])) ? $_SESSION['errorData']['category'] : (isset($result) ? $result['category'] : ''); ?>' name="category" placeholder="Please enter product's category">
                        <?= (isset($_SESSION['errorMessages']['category'])) ? "<p class='errorMessage'>" . $_SESSION['errorMessages']['category'] . "</p>" : ''; ?>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit"> Send updates </button>
                </div>

            </form>
        </div>
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