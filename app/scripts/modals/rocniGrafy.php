<?php

  // Hlavicka
  require "head.php";

  // Osetreni vstupu
  if(!isset($_GET['rok']) OR !is_numeric($_GET['rok']))
  { $_GET['rok'] = date("Y");}

  echo "<h3>{$_GET['rok']}</h3>";

  //////////////////////////
  // GRAF TEPLOTA
  
  echo "<div id='rocniTeplota' class='grafModal'></div>";
  require "../grafy/teplota/rocni.php";

  //////////////////////////
  // GRAF VLHKOST

  if($vlhkomer == 1)
  {

    echo "<div id='rocniVlhkost' class='grafModal'></div>";
    require "../grafy/vlhkost/rocni.php";

  }

  // Paticka
  require "foot.php";