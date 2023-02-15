<?php

echo "test";

if(isset($_POST['submit'])){

    $abfahrtsbahnhof = $_POST['stations'];
    $abfahrtsdatum = $_POST['dbaf-abfahrts-datepicker'];
    $ankunftsdatum = $_POST['dbaf-ankunfts-datepicker'];
    $onlyAbfahrt = $_POST['dbaf-date-toggler'];

    var_dump($abfahrtsbahnhof);
    var_dump($abfahrtsdatum);
    var_dump($ankunftsdatum);
    var_dump($onlyAbfahrt);

}

?>