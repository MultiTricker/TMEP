<?php

 //////////////////////////////////////////////////////////////////////////
 //// VLOZENI SOUBORU
 //////////////////////////////////////////////////////////////////////////

  require "../../config.php";         // skript s nastavenim
  require "../db.php";        // skript s databazi
  require "../fce.php";       // skript s nekolika funkcemi

 //////////////////////////////////////////////////////////////////////////
 //// JAZYK A JEDNOTKA
 //////////////////////////////////////////////////////////////////////////

  // pokud je povolene vlastni nastaveni...
  if($zobrazitNastaveni == 1)
  {

    // jazyk
    if(isset($_GET['ja']) AND ($_GET['ja'] == "cz" OR $_GET['ja'] == "en" OR
        $_GET['ja'] == "de" OR $_GET['ja'] == 'fr' OR $_GET['ja'] == 'pl') OR
        $_GET['ja'] == 'fi' OR $_GET['ja'] == 'sv' OR $_GET['ja'] == 'sk' OR
        $_GET['ja'] == 'ru')
    {
      $l = $_GET['ja'];
    }

    require_once "../language/".$l.".php";       // skript s jazykovou mutaci    

    // jednotka
    if(isset($_GET['je']) AND ($_GET['je'] == 'C' OR $_GET['je'] == 'F' OR
     $_GET['je'] == 'K' OR $_GET['je'] == 'R' OR $_GET['je'] == 'D' OR 
     $_GET['je'] == 'N' OR $_GET['je'] == 'Ro' OR $_GET['je'] == 'Re'))
    {
      $u = $_GET['je'];
    }

  }
  else
  {
    require_once "../language/".$l.".php";       // skript s jazykovou mutaci    
  }

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>

  <head>
    <title><?php echo $lang['titulekstranky']; ?></title>
    <meta HTTP-EQUIV="content-type" CONTENT="text/html; charset=UTF-8">
    <link rel="stylesheet" href="../../css/css.css" type="text/css">
    <meta NAME="description" CONTENT="<?php echo $lang['popisstranky']; ?>">
    <meta NAME="author" CONTENT="Michal Ševčík (http://multi.tricker.cz), František Ševčík (f.sevcik@seznam.cz)">
    <script src="../js/jquery.tools.ui.timer.colorbox.tmep.highcharts.js" type="text/javascript"></script>
    <link rel="shortcut icon" href="../../images/favicon.ico">
    <style type="text/css">body{ background: url("../../images/modal-bcg.png") top center repeat-x #f4f3e5; }</style>
  </head>

<body>