<?php
    require_once 'handler/db_apiquery.php';
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

                echo 'Fahrplan: ' . DBAPI_Fahrplan::FahrplanIsAvailable();
                echo 'StaDa: ' . DBAPI_StaDa::StaDaIsAvailable();

                $filter = new StationFilter();
                $filter->limit = 100;
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

        <div id="footer">
            Version <?php echo DB_VERSION ?>
        </div>

        <script type="text/javascript">
            // Überlappung vom Body mit Footer verhindern
            document.getElementById("main-div").style.marginBottom = document.getElementById("footer").clientHeight + "px";
        </script>
    </body>
</html>