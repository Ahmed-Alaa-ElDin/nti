<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $_SESSION['errorMessages'] = 'Please Login First';
        echo 'log';
        exit();
    }
    // $_SESSION['errorMessages'] = 'Please Login First';
    // header('location: /nti/first_project/login.php');
} else {
    $serverName = 'localhost';
    $dbName = 'courses4U';
    $userName = 'root';
    $userPass = '';

    $con = mysqli_connect($serverName, $userName, $userPass, $dbName);

    if (!$con) {
        die('Error:' . mysqli_connect_error());
    }

    $query = "SELECT COUNT(*) AS `count` FROM `subscriptions` WHERE `course_id` = $_POST[course_id] AND `student_id` = " . $_SESSION['user']['id'] . " AND `status_id` = 1";
    $result = mysqli_query($con, $query);

    // echo mysqli_fetch_assoc($result)['count'] ;
    if (mysqli_fetch_assoc($result)['count'] == 0) {
        $query = "INSERT INTO `subscriptions`(`course_id`, `student_id`, `status_id`) VALUES ($_POST[course_id]," . $_SESSION['user']['id'] . ",1)";
        $result = mysqli_query($con, $query);
        echo 'added';
    }

}
