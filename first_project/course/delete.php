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
    $deleteQuery = "DELETE FROM `courses` WHERE `id` = $id";
    $result = mysqli_query($con, $deleteQuery);

    if (mysqli_affected_rows($con) == 1) {
        $_SESSION['successMessages'] = 'Course Deleted successfully';

        // redirect to all course
        header("Location: all.php");
        exit();
    } else {
        $_SESSION['errorMessage']['courseNotFound'] = 'This course isn\'t there';
        header('location: all.php');
        exit();
    };

}
