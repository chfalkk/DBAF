<?php

    require_once "./extensions/headerExtensions.php";

?>


<script src="../js/navbar/navbar.js"></script>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">DBAF <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="fahrplanauskunft.php">Fahrplanauskunft</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about_us.php">Über uns</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="test.php">Test [DEV ONLY - REMOVE LATER]</a>
      </li>
    </ul>

  <div class="mr-sm-2">
      <?php HeaderExtensions::DisplayAPIStatus() ?>
  </div>

    <div class="my-2 my-lg-0">
      <label class="switch">
        <input class="dbaf-input" type="checkbox" id="dbaf-darkmode-toggle">
        <span class="slider round"></span>
      </label>
    </div>
  </div>
</nav>