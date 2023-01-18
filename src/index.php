<?php
    require_once 'handler/db_fahrplan.php.php';
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

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        
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

        <?php
            require_once 'partials/footer.php';
        ?>
    </body>
</html>