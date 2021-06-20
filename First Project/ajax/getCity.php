<?php 
    include('../database/con.php');

    $citiesArray = [];

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['country_id']) && filter_var($_GET['country_id'], FILTER_VALIDATE_INT)) {
            $country_id = filter_var($_GET['country_id'], FILTER_SANITIZE_NUMBER_INT);
            
            $cityQuery = "SELECT * FROM `cities` WHERE `country_id` = $country_id";
            $citiesResults = mysqli_query($con, $cityQuery);
            
            if (mysqli_num_rows($citiesResults)) {
                while($city = mysqli_fetch_array($citiesResults,MYSQLI_ASSOC)) {
                    $citiesArray[] = $city;
                }
                $cities = json_encode($citiesArray);

                echo $cities;
            }
        }
    }

?>