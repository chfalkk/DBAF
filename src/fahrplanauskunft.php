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

        <script src="js/fahrplanInputHelper.js"></script>
    </head>
    <body>
        <?php 
            require_once "partials/header.php";
            require_once "./ressources/iconRessources.php";
            require_once "./extensions/htmlExtension.php";
        ?>

        <div id="dbaf-main-div">
            
        <?php HTMLExtension::BuildSectionHeading("FAHRPLANAUSKUNFT") ?>

            <?php
                // Instanzierung des Handlers
                $handler = new MainHandler();
                $stations = $handler->GetAllStations();
            
                // Display WARN-BOX wenn API nicht erreichbar
                if(!DBAPI_Fahrplan::FahrplanIsAvailable()){
                    HTMLExtension::BuildWarnPanel("Die Fahrplan-API ist zur Zeit nicht erreichbar!");
                }
            ?>

            <div class="dbaf-form">

            <?php
                $formHeading = sprintf("Bahnhof auswählen (%s verfügbar):", count($stations));
                HTMLExtension::BuildSubSectionHeading($formHeading);
            ?>

            <form action="" method="POST">

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="dbaf-station-picker">Abfahrtsbahnhof:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">
                                <?php echo IconRessources::$GeoDot ?>
                            </span>
                        </div>

                        <select class="form-control" id="dbaf-station-picker" name="stations" placeholder="Stationen" aria-label="Stationen">
                            <?php
                                foreach ($stations as $station) {
                                    echo '<option value="volvo">' . $station . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-row">

                <!-- ABFAHRTS-DATUM -->
                <div class="form-group col-md-6">
                    <label for="dbaf-abfahrts-datepicker">Abfahrtsdatum:</label>
                    <div class="input-group md-3">
                        <input type="datetime-local" class="form-control" id="dbaf-abfahrts-datepicker" name="dbaf-abfahrts-datepicker" placeholder="--Bitte wählen Sie ein Datum aus--"/>
                    </div>
                </div>

                <!-- ANKUNFTS-DATUM -->
                <div class="form-group col-md-6">
                <label for="dbaf-ankunfts-datepicker" id="dbaf-ankunfts-datepicker-label">Ankunftsdatum:</label>
                    <div class="input-group md-3">
                        <input type="datetime-local" class="form-control" id="dbaf-ankunfts-datepicker" name="dbaf-ankunfts-datepicker" placeholder="--Bitte wählen Sie ein Datum aus--"/>
                    </div>
                </div>
            </div>

            <!-- AUSWAHL NUR START-DATUM -->
            <div class="form-row">
                <div class="form-group">
                    <input type="checkbox" id="dbaf-date-toggler" class="dbaf-check" name="dbaf-date-toggler" aria-label="Auswahl, ob nur nach dem Startdatum gesucht werden soll.">
                    Nur nach dem Startdatum suchen
                    </input>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-dbaf"><?php echo IconRessources::$Suchen ?> Fahrpläne suchen</button>

            </form>
            </div>
            
        </div> <!-- #main-div -->

        <?php
            require_once 'partials/footer.php';
        ?>
    </body>
</html>