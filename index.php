<?php
    require_once 'handler/db_fahrplan.php';
    require_once 'handler/db_stada.php';
    require_once 'handler/tableBuilder.php';
?>

<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DB API</title>

        <link rel="stylesheet" href="css/style.css">
        <link rel="icon" href="img/favicon.ico">
    </head>
    <body>
        <div id="main-div">
            <?php
                $query = new DBAPI_StaDa();
                
                $fahrplanAvailable = DBAPI_Fahrplan::FahrplanIsAvailable();
                $stadaAvailable = DBAPI_StaDa::StaDaIsAvailable();
                
                $sFahrplanAvailable = ($fahrplanAvailable) ? 'verfügbar' : 'nicht verfügbar'; 
                $sStadaAvailable = ($stadaAvailable) ? 'verfügbar' : 'nicht verfügbar';

                echo 'Fahrplan: ' . $sFahrplanAvailable;
                echo 'StaDa: ' . $sStadaAvailable;
                
                $filter = new StationFilter();
                $filter->limit = 10;
                $query->GetStations($filter);
                //$query->GetArrivalBoard(8011201, '2023-01-30');

                //if ($query->GetErrorMessage() != '') {
                //    echo $query->GetErrorMessage();
                //} else {
                    $result = $query->GetJSONResult();
                    echo TableBuilder::BuildTable('Locations', $result);
                //}
                
            ?>
        </div>

        <?php
            require_once 'partials/footer.php';
        ?>
    </body>
</html>