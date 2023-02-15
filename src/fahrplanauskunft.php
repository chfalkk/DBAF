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
        <?php //IMPORTS
            require_once "partials/header.php";
            require_once "./ressources/iconRessources.php";
            require_once "./extensions/htmlExtension.php";
            require_once "./handler/db_fahrplan.php";
        ?>

        <div id="dbaf-main-div">
            
        <?php HTMLExtension::BuildSectionHeading("FAHRPLANAUSKUNFT") ?>

            <?php
                // Instanzierung des Handlers
                $handler = new MainHandler();
                $stations = $handler->GetAllStations();
            
                // Display WARN-BOX wenn API nicht erreichbar
                if(!DBAPI_Fahrplan::FahrplanIsAvailable()){
                    HTMLExtension::BuildPanel(PanelType::Warn, "Die Fahrplan-API ist zur Zeit nicht erreichbar");
                }
            ?>

            <div class="dbaf-form">

            <?php
                $formHeading = sprintf("Bahnhof auswählen (%s verfügbar):", count($stations));
                HTMLExtension::BuildSubSectionHeading($formHeading);
            ?>

            <form method="POST">

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="dbaf-station-picker">Abfahrtsbahnhof:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">
                                <?php echo IconRessources::$GeoDot ?>
                            </span>
                        </div>

                        <select class="form-control" id="dbaf-station-picker" name="stations" placeholder="Stationen" aria-label="Stationen" required>
                            <?php
                                foreach ($stations as $station) {
                                    echo '<option value="'.$station.'">' . $station . '</option>';
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
                        <input type="datetime-local" class="form-control" id="dbaf-abfahrts-datepicker" name="dbaf-abfahrts-datepicker" placeholder="--Bitte wählen Sie ein Datum aus--" required/>
                    </div>

                    <div class="btn btn-dbaf btn-sm dbaf-btn-div" id="dbaf-today-btn-abfahrt"><?php echo IconRessources::$Kalender ?> Aktuelles Datum auswählen</div>
                </div>

                <!-- ANKUNFTS-DATUM -->
                <div class="form-group col-md-6">
                <label for="dbaf-ankunfts-datepicker" id="dbaf-ankunfts-datepicker-label">Ankunftsdatum:</label>
                    <div class="input-group md-3">
                        <input type="datetime-local" class="form-control" id="dbaf-ankunfts-datepicker" name="dbaf-ankunfts-datepicker" placeholder="--Bitte wählen Sie ein Datum aus--"/>
                    </div>

                    <div class="btn btn-dbaf btn-sm dbaf-btn-div" id="dbaf-today-btn-ankunft"><?php echo IconRessources::$Kalender ?> Aktuelles Datum auswählen</div>
                </div>
            </div>

            <!-- CHECKBOX UM ANKUNFT ZU TOGGLEN -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <div class="input-group md-3">
                        <input type="checkbox" class="dbaf-check" id="dbaf-date-toggler" name="dbaf-date-toggler">
                        <label class="form-check-label" for="dbaf-date-toggler"> Nur nach dem Abfahrtsdatum suchen</label>
                    </div>
                </div>
            </div>

            <button type="submit" name="submit" class="btn btn-primary btn-dbaf"><?php echo IconRessources::$Suchen ?> Fahrpläne suchen</button>

            </form>
            </div>
            
        </div> <!-- #main-div -->

        <!-- RESPONSE-SEKTION -->
        <div>
            <?php require "./partials/fahrplanResult.php";?> 
        </div>

        <?php
            require_once 'partials/footer.php';
        ?>
    </body>
</html>