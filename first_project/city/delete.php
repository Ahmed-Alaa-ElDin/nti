<?php
// prerequisite variables
$title = 'Courses4U - Delete City';

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
    $deleteQuery = "DELETE FROM `cities` WHERE `id` = $id";
    $result = mysqli_query($con, $deleteQuery);

    if (mysqli_affected_rows($con) == 1) {
        $_SESSION['successMessages'] = 'City Deleted successfully';

        // redirect to all city
        header("Location: /nti/first_project/city/all.php");
        exit();
    } else {
        $_SESSION['errorMessage']['cityNotFound'] = 'This city isn\'t there';
        header('location: all.php');
        exit();
    };

}
