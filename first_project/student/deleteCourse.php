
<?php
include(dirname(__DIR__) . '/database/connect.php');
$query = "UPDATE `subscriptions` SET `expiry_date`='" . date('Y-m-d H:i:s') . "',`status_id`= 3 WHERE `id` = " . $_GET['id'];
$result = mysqli_query($con , $query);

if(mysqli_affected_rows($con) > 0){
    $_SESSION['successMessages'] = 'You deleted this course successfully';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
};
?>
