<?php
    require_once "extensions/headerExtension.php";
?>

<!-- TODO: Darkmode -->
<!-- Note: Falls wir das entfernen, dann auch ja/navbar.js löschen -->
<!-- <script src="../js/navbar/navbar.js"></script> -->

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">DBAF</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="fahrplanauskunft.php">Fahrplanauskunft</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about_us.php">Über uns</a>
                </li>
            </ul>
        </div>

        <div class="mr-sm-2">
            <?php
                HeaderExtension::DisplayAPIStatus();
            ?>
        </div>

        <!-- TODO: Darkmode -->
        <!-- Note: Falls wir das entfernen, dann auch css/toggler.css löschen -->

        <!-- <div class="my-2 my-lg-0">
            <label class="switch">
                <input class="dbaf-input" type="checkbox" id="dbaf-darkmode-toggle">
                <span class="slider round"></span>
            </label>
        </div> -->
    </nav>
</header>