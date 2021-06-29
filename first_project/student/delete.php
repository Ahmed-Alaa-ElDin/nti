<?php
// prerequisite variables
$title = 'Courses4U - Delete Student';

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
    $deleteQuery = "DELETE FROM `students` WHERE `id` = $id";
    $result = mysqli_query($con, $deleteQuery);

    if (mysqli_affected_rows($con) == 1) {
        $_SESSION['successMessages'] = 'Student Deleted successfully';

        // redirect to all student
        header("Location: /nti/first_project/student/all.php");
        exit();
    } else {
        $_SESSION['errorMessage']['studentNotFound'] = 'This student isn\'t there';
        header('location: all.php');
        exit();
    };

}
