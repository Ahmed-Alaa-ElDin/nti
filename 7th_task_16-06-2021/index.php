<?php
require('con.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search'])) {
        $search = $_GET['search'];
        $query = "SELECT * FROM `products` WHERE `name` LIKE '%$search%'";

        $run = mysqli_query($con, $query);
} else {
    $query = "SELECT * FROM `products`";
    
    $run = mysqli_query($con, $query);
}



?>
<!-- Create 2 php files one of them has a form with the following inputs (name, email, password, address, gender, linkedin url) Validate inputs then store data into session, when user open the second file can show stored data. -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
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

        .searchDiv {
            display: flex;
            margin: 1em auto;
            width: 50vw;
            justify-content: center;
            justify-items:center;
        }

        h2 {
            margin: auto;
            margin-bottom: 0.75em;
            font-size: 1.75em;
            text-align: center;
            color: white;
        }

        table {
            margin: auto;
            max-width: 80vw;
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

        td:not(.action) {
            padding: 5px 10px;
            background-color: #fff;
            border-radius: 50px;
            color: #000;
        }

        input {
            padding: 0.5em;
            border-radius: 10px;
            outline: none;
            border: 0;
            width: 300px;
            text-align: center;

        }

        .addButton,
        .editButton,
        .deleteButton,
        .searchButton {
            display: inline-block;
            font-weight: bold;
            color: #fff;
            text-decoration: none;
            padding: 0.5em 1em;
            text-align: center;
            border-radius: 5px;
            border: 0;
            transition: all 0.3s ease-in-out;
            cursor: pointer;
            pointer-events: all;
        }

        .addButtonDiv {
            text-align: center;
            margin-bottom: 1em;
        }

        .addButton {
            background-color: #3498db;
        }

        .addButton:hover {
            background-color: #2980b9;
        }

        .editButton {
            background-color: #34495e;
        }

        .editButton:hover {
            background-color: #2c3e50;
        }

        .deleteButton {
            background-color: #e74c3c;
        }

        .deleteButton:hover {
            background-color: #c0392b;
        }

        .searchButton {
            background-color: #ecf0f1;
            color: #000;
            width: max-content;
        }

        .searchButton:hover {
            background-color: #bdc3c7;
        }


        .errorMessage {
            background-color: #ff7979;
            border-radius: 2px;
            border: 1px solid #fff;
            padding: 0.5em 1em;
            margin-top: 0.25em;
            color: #fff;
            font-size: 1em;
            font-weight: bold;
            text-align: center;
            border-radius: 20px;
            width: max-content;
            margin: auto;

        }

        .successMessage {
            background-color: #27ae60;
            border-radius: 2px;
            border: 1px solid #fff;
            padding: 0.5em 1em;
            margin-top: 0.25em;
            color: #fff;
            font-size: 1em;
            font-weight: bold;
            text-align: center;
            border-radius: 20px;
            width: max-content;
            margin: auto;
        }
    </style>
</head>

<body>
    <?php
    if (isset($_SESSION['successMessage'])) {
    ?>
        <div class="successMessage"><?= $_SESSION['successMessage'] ?></div>
    <?php
    }
    ?>

    <?php
    if (isset($_SESSION['errorMessage'])) {
    ?>
        <div class="errorMessage"><?= $_SESSION['errorMessage'] ?></div>
    <?php
    }
    ?>

    <div class="container">
        <div class="details-div">
            <div class="addButtonDiv">
                <a href="create.php" class="addButton">Add New Product</a>
            </div>

            <div class="searchDiv">
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get">
                    <input type="search" name="search" value="<?php 
                    if (isset($_GET['search'])) {
                        echo $_GET['search'];
                    }
                    ?>" placeholder="Enter search word">
                    <input type="submit" value="Search" class="searchButton">
                </form>
            </div>

            <h2>All Products</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Code</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
                <?php
                while ($product = mysqli_fetch_assoc($run)) {
                ?>
                    <tr>
                        <th><?= $product['id'] ?></th>
                        <td><?= $product['name'] ?></td>
                        <td><?= $product['price'] ?> EGP</td>
                        <td><?= $product['code'] ?></td>
                        <td><?= $product['category'] ?></td>
                        <td class="action">
                            <div style="padding: 0em 1em;">
                                <a href="edit.php?id=<?= $product['id'] ?>" class="editButton">Edit</a>
                                <a href="delete.php?id=<?= $product['id'] ?>" class="deleteButton">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </table>
        </div>
    </div>

</body>

</html>

<?php

if (isset($_SESSION['errorMessage'])) {
    unset($_SESSION['errorMessage']);
}
if (isset($_SESSION['successMessage'])) {
    unset($_SESSION['successMessage']);
}


?>