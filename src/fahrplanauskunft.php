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

        <link rel="stylesheet" href="css/style.css">
        <link rel="icon" href="img/favicon.ico">
    </head>
    <body>
        <?php 
            require_once "partials/header.php";
        ?>

        <div id="dbaf-main-div">
            <h1>FAHRPLANAUSKUNFT</h1>

            <?php
                $handler = new MainHandler();
                $stations = $handler->GetAllStations();
            ?>

            <form action="" method="POST">
                <label for="stations">Bahnhof auswählen (<?php echo count($stations); ?> verfügbar):</label>
                <select name="stations" id="dbaf-dropdown-station">
                    <?php
                        foreach ($stations as $station) {
                            echo '<option value="volvo">' . $station . '</option>';
                        }
                    ?>
                </select>

                <input name="date" type="date">
            </form>
            
        </div> <!-- #main-div -->

        <?php
            require_once 'partials/footer.php';
        ?>
    </body>
</html>