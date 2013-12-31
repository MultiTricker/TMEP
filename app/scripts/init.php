<?php

  // Je lepší volat před každým zpracováním grafu

  // INIT
  if(isset($od))     { unset($od);  }    $od     = Array();
  if(isset($do))     { unset($do);  }    $do     = Array();
  if(isset($ydata))  { unset($ydata);  } $ydata  = Array();
  if(isset($ydata2)) { unset($ydata2); } $ydata2 = Array();
  if(isset($ydata3)) { unset($ydata3); } $ydata3 = Array();
  if(isset($labels)) { unset($labels); } $labels = Array();
  $teplota = ""; $vlhkost = ""; $rosnyBod = ""; $count = 0;

  // zjistime jednotku teploty
  $jednotkap = explode(" ", jednotkaTeploty(1, $u, 1));
  $jednotka = str_replace("&deg;", "°", $jednotkap[1]);