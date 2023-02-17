<?php
    // require_once 'handler/db_fahrplan.php';
    // require_once 'handler/db_stada.php';
    // require_once 'handler/tableBuilder.php';
?>

<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DBAF - Home</title>

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
            require_once 'partials/header.php';
            require_once "./ressources/iconRessources.php";
            require_once "./extensions/htmlExtension.php";
        ?>

        <div id="dbaf-main-div">
            
            <!-- TODO: Content -->
            <?php HTMLExtension::BuildSectionHeading("HOME-PAGE") ?>

            <div class="dbaf-clearfix">
                
                <div class="dbaf-tile-container">
                    <div class='dbaf-tile'>
                        <article>
                            <a href='fahrplanauskunft.php'>
                                <div class='overlay'>
                                    <p>
                                        Fahrplanauskunft aufrufen
                                    </p>
                                </div>
                            </a>
                            <img src="img/fahrplanauskunft.png">
                        </article>
                    </div>
                </div>

                <div class="dbaf-tile-container">
                    <div class='dbaf-tile'>
                        <article>
                            <a href='fahrplanauskunft.php'>
                                <div class='overlay'>
                                    <p>
                                        Fahrplanauskunft aufrufen
                                    </p>
                                </div>
                            </a>
                            <img src="img/fahrplanauskunft.png">
                        </article>
                    </div>
                </div>
            </div>

            <?php HTMLExtension::BuildPanel(PanelType::Info, "Dev-Note: Ich würde mich an den vorherigen Buch-Projekten der anderen Gruppen \"inspirieren\" und Kacheln mit Bildern erstellen, welche zu den einzelnen Websites verweisen (z.B. Fahrplanauskunft)") ?>

        </div> <!-- #main-div -->

        <?php
            require_once 'partials/footer.php';
        ?>
    </body>
</html>