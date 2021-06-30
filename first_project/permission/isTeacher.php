<?php 
    if (!isset($_SESSION['user']['role_id']) || $_SESSION['user']['role_id'] != 1) {
        header('location: /nti/first_project/');
    }
?>