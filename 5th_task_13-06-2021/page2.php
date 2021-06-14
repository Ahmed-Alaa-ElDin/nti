<?php

session_start();

if (isset($_POST['logOut'])) {
    session_destroy();
    header("Refresh:0");
}

?>
<!-- Create 2 php files one of them has a form with the following inputs (name, email, password, address, gender, linkedin url) Validate inputs then store data into session, when user open the second file can show stored data. -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page 2</title>
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

        .details-div {
            margin-top: 1em;
            margin-bottom: 1em;
            background-color: #27ae60;
            box-shadow: 0px 0px 43px -10px rgba(0, 0, 0, 0.5);
            -webkit-box-shadow: 0px 0px 43px -10px rgba(0, 0, 0, 0.5);
            -moz-box-shadow: 0px 0px 43px -10px rgba(0, 0, 0, 0.5);
            padding: 1em 2em;
            border-radius: 20px;
        }

        h2 {
            margin: auto;
            margin-bottom: 0.75em;
            font-size: 1.75em;
            text-align: center;
            color: white;
        }

        table {
            width: 500px;
            text-align: center;
            color: #fff;
            border-spacing: 10px;
            pointer-events: none;
            user-select: none;
        }

        th {
            font-size: 1.25em;
            padding: 10px;
        }

        td {
            background-color: #fff;
            border-radius: 50px;
            color: #000;
        }

        .button {
            display: block;
            font-size: 1em;
            font-weight: bold;
            color: #fff;
            background-color: #e74c3c;
            padding: 0.5em 1em;
            text-align: center;
            margin: 1em auto 0.5em;
            border-radius: 5px;
            border: 0;
            transition: all 0.3s ease-in-out;
            cursor: pointer;
        }

        .button:hover {
            background-color: #c0392b;
        }

        .errorMessage {
            border-radius: 2px;
            border: 1px solid #fff;
            background-color: #ff7979;
            padding: 0.5em;
            margin-top: 0.25em;
            color: #fff;
            font-size: 1.5em;
            text-align: center;
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
        if (!isset($_SESSION['user'])) {
            echo "<p class='errorMessage'> You didn't log in, please log in and come again, you'll be directed to page 1 after 5 seconds </p>";
            header( "refresh:5;url=page1.php" );
            exit();
        } else {
        ?>
            <div class="details-div">
                <h2>Your Details</h2>
                <table>
                    <tr>
                        <th>Name</th>
                        <td><?= $_SESSION['user']['name'] ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= $_SESSION['user']['email'] ?></td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td><?= $_SESSION['user']['address'] ?></td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td><?= $_SESSION['user']['gender'] ?></td>
                    </tr>
                    <tr>
                        <th>LinkedIn</th>
                        <td><?= $_SESSION['user']['linkedIn'] ?></td>
                    </tr>
                </table>
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                    <input type="submit" class="button" name="logOut" value="Log Out">
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