<?php
// prerequisite variables
$title = 'Courses4U - Delete Teacher';

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
    $deleteQuery = "DELETE FROM `teachers` WHERE `id` = $id";
    $result = mysqli_query($con, $deleteQuery);

    if ($result) {
        $_SESSION['successMessages'] = 'Profile Deleted successfully';

        // redirect to all teacher
        header("Location: /nti/first_project/teacher/all.php");
        exit();
    } else {
        $_SESSION['errorMessage']['teacherNotFound'] = 'This teacher isn\'t there';
        header('location: all.php');
        exit();
    };

}
