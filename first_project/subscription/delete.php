<?php
// prerequisite variables
$title = 'Courses4U - Delete Course';

include(dirname(__DIR__) . '/includes/head.php');
include(dirname(__DIR__) . '/permission/isTeacher.php');

// Declaration of cleaning function
function clean($request)
{
    $request = htmlspecialchars($request);
    $request = trim($request);
    $request = stripcslashes($request);

    return $request;
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {

    $id = $_GET['id'];
    
    // excute delete query
    $deleteQuery = "DELETE FROM `subscriptions` WHERE `id` = $id";
    $result = mysqli_query($con, $deleteQuery);

    if (mysqli_affected_rows($con) == 1) {
        $_SESSION['successMessages'] = 'Subscription Deleted successfully';

        // redirect to all Subscription
        header("Location: all.php");
        exit();
    } else {
        $_SESSION['errorMessage']['SubscriptionNotFound'] = 'This Subscription isn\'t there';
        header('location: all.php');
        exit();
    };

}
