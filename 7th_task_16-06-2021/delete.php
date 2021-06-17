<?php
require('con.php');

if (isset($_REQUEST['id'])) {
    if (filter_var($_REQUEST['id'], FILTER_VALIDATE_INT)) {
        $id = filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT);

        $query = "DELETE FROM `products` WHERE id = $id";

        $run = mysqli_query($con, $query);

        if ($run->num_rows > 0) {
            $_SESSION['successMessage'] = 'Product has been deleted successfully';
            
            header("Location:index.php");
        } else {
            $_SESSION['errorMessage'] = 'Please choose the right product first';

            header("Location:index.php");
        }
    }
} else {
    $_SESSION['errorMessage'] = 'Please choose the right product first';

    header("Location:index.php");
}
