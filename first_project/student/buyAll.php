<?php
include(dirname(__DIR__) . '/database/connect.php');
$expiry = date("Y-m-d", strtotime("+1 month", time()));
$query = "UPDATE `subscriptions` SET `join_date`='" . date('Y-m-d H:i:s') . "',`expiry_date`='$expiry',`status_id`=2 WHERE `student_id` = " . $_SESSION['user']['id'];
$result = mysqli_query($con , $query);

if(mysqli_affected_rows($con) > 0){
    $_SESSION['successMessages'] = 'You bought all course successfully';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
};
?>
