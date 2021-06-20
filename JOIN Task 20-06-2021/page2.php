<?php

$serverName = 'localhost';
$dbName = 'join_task';
$userName = 'root';
$userPass = '';

$con = mysqli_connect($serverName, $userName, $userPass, $dbName);

$query = "SELECT `users`.*, `departments`.`name` AS `department_name`, `nationalIds`.`number` FROM `users` LEFT JOIN `departments` ON `users`.`department_id` = `departments`.`id` LEFT JOIN `nationalIds` ON `users`.`nationalID_id` =  `nationalIds`.`id`";

$results = mysqli_query($con, $query);

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
            width: 100%;
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
            padding: 10px;
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
        <div class="details-div">
            <table>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>National ID</th>
                    <th>Department</th>
                </tr>
                <?php
                $num = 1;
                while ($person = mysqli_fetch_assoc($results)) {
                ?>
                    <tr>
                        <td><?= $num ?></td>
                        <td><?= $person['name'] ?></td>
                        <td><?= $person['phone'] ?></td>
                        <td><?= $person['number'] ?></td>
                        <td><?= $person['department_name'] ?></td>
                    </tr>
                <?php
                $num++;
                }
                ?>
            </table>
        </div>
    </div>

</body>

</html>