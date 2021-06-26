    <?php
    include(dirname(__DIR__) . '/database/connect.php');
    ?>
    <!DOCTYPE html>
    <html class="loading" lang="en" data-textdirection="ltr">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <link rel="apple-touch-icon" href="/nti/first_project/theme-assets/images/logo/logo.png">
        <title><?= isset($title) ? $title : 'Courses4U' ?></title>
        <link rel="shortcut icon" type="image/x-icon" href="/nti/first_project/theme-assets/images/logo/logo.png">
        <link href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700" rel="stylesheet">
        <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">
        <?php
        
        include(dirname(__DIR__) . '/includes/styles.php');
        
        if (isset($style)) {
            echo '<style>' . $style . '</style>';
            
        }
        ?>
    </head>
