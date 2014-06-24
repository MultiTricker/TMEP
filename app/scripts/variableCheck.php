<?php

  if($zobrazitNastaveni == 1)
  {

    // jazyk
    if(isset($_GET['ja']) AND ($_GET['ja'] == "cz" OR $_GET['ja'] == "en" OR
        $_GET['ja'] == "de" OR $_GET['ja'] == 'fr' OR $_GET['ja'] == 'pl' OR
      $_GET['ja'] == 'fi' OR $_GET['ja'] == 'sv' OR $_GET['ja'] == 'sk' OR
      $_GET['ja'] == 'ru'))
    {
      $l = $_GET['ja'];
    }

    require_once dirname(__FILE__)."/language/".$l.".php";       // skript s jazykovou mutaci

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
    require_once dirname(__FILE__)."/language/".$l.".php";       // skript s jazykovou mutaci
  }
