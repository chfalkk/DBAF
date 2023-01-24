<?php

    require_once "./extensions/headerExtensions.php";

?>

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
        <a class="nav-link" href="#">Fahrplanauskunft</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Über uns</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Test [DEV ONLY - REMOVE LATER]</a>
      </li>
    </ul>
    <div class="form-inline my-2 my-lg-0 dbaf-icon-div">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Settings <i class="fa-solid fa-gear"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
            <label class="switch">
                <input type="checkbox">
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
  </div>
</nav>

<script src="./js/navbar/navbar.js"></script>