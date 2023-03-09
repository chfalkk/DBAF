<?php
    require_once('handler/db_mainhandler.php');
?>

<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DBAF - Fahrplanauskunft</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
        <link rel="stylesheet" href="css/lib/bootstrap.min.css">
        
        <script src="js/lib/jquery-3.6.3.min.js"></script>
        <script src="js/lib/popper.min.js"></script>
        <script src="js/lib/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.3.js"></script>

        <link rel="stylesheet" href="css/style.css">
        <link rel="icon" href="img/favicon.ico">

        <!-- <script src="js/fahrplanInputHelper.js"></script>
        <script src="js/fahrplanSearch.js"></script> -->
        <script src="js/fahrplanSuche.js"></script>

        <!-- DEVEXTREME LIBS -->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <!-- DevExtreme theme -->
        <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/22.2.4/css/dx.light.css">
        <!-- DevExtreme library -->
        <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/22.2.4/js/dx.all.js"></script>

    </head>
    
    <body class="dx-viewport">

    <?php include "./partials/header.php" ?>
    
    <div id="dbaf-main-div" class="dbaf-form">
        <div class="dbaf-form-item" id="dbaf-fahrplan-form"></div>
    </div>

    </body>

</html>