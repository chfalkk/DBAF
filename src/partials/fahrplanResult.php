<?php

    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])){

        $abfahrtsbahnhof = $_POST['stations'];
        $ankunftsbahnhof = null; //TODO

        $abfahrtsdatum = $_POST['dbaf-abfahrts-datepicker'];
        $ankunftsdatum = ($_POST['dbaf-ankunfts-datepicker'] == "") ? null : $_POST['dbaf-ankunfts-datepicker'];

        // Umwandlung in Bool
        // Checkboxen werden nicht übergeben, wenn sie auf false stehen
        $onlyAbfahrt = isset($_POST['dbaf-date-toggler']);

        $request = new FahrplanRequest("POST", $abfahrtsbahnhof, $ankunftsbahnhof, $abfahrtsdatum, $ankunftsdatum, $onlyAbfahrt);

        echo $request->HandleRequest();

    }
?>