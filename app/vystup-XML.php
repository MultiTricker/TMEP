<?php

  //////////////////////////////////////////////////////////////////////////
  //// VLOZENI SOUBORU
  //////////////////////////////////////////////////////////////////////////

  require "./config.php";         // skript s nastavenim
  require "./scripts/db.php";        // skript s databazi
  require "./scripts/fce.php";       // skript s nekolika funkcemi

  //////////////////////////////////////////////////////////////////////////
  //// Nacteni hodnot
  //////////////////////////////////////////////////////////////////////////

  // Posledni mereni
  $dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT kdy, teplota, vlhkost FROM tme ORDER BY kdy DESC LIMIT 1");
  $posledni = MySQLi_fetch_assoc($dotaz);

  // Nejvyssi namerena teplota
  $dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT kdy, teplota FROM tme ORDER BY teplota DESC LIMIT 1");
  $nejvyssi = MySQLi_fetch_assoc($dotaz);

  // Nejnizsi namerena teplota
  $dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT kdy, teplota FROM tme ORDER BY teplota ASC LIMIT 1");
  $nejnizsi = MySQLi_fetch_assoc($dotaz);

  // Mame vlkhomer?
  if($vlhkomer == 1)
  {

    // Nejvyssi namerena vlhkost
    $dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT kdy, vlhkost FROM tme ORDER BY vlhkost DESC LIMIT 1");
    $nejvyssiVlhkost = MySQLi_fetch_assoc($dotaz);

    // Nejnizsi namerena vlhkost
    $dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT kdy, vlhkost FROM tme ORDER BY vlhkost ASC LIMIT 1");
    $nejnizsiVlhkost = MySQLi_fetch_assoc($dotaz);

  }

  // Nastavime hlavicku
  header ("Content-Type:text/xml");

  //////////////////////////////////////////////////////////////////////////
  //// XML
  //////////////////////////////////////////////////////////////////////////

  // Nemame vlhkomer?
  if($vlhkomer == 0)
  {
    echo '<?xml version="1.0" encoding="UTF-8"?> '; ?>
  <root xmlns="http://www.papouch.com/xml/TME/act">
    <sns location="<?php echo $umisteni; ?>" status="0" hi="0" lo="0" unit="0" val="<?php echo round($posledni['teplota'], 1)*10; ?>" min="-9999" max="9999"/>
  </root>
  <?php
  }
  else
  {
  // Mame vlhkomer
  echo '<?xml version="1.0" encoding="iso-8859-1"?> '; ?>

<root xmlns="http://www.papouch.com/xml/th2e/act">
  <sns id="1" type="1" status="0" unit="0" val="<?php echo round($posledni['teplota'], 1); ?>" w-min="" w-max="" e-min-val=" <?php echo round($nejnizsi['teplota'], 1); ?>" e-max-val=" <?php echo round($nejvyssi['teplota'], 1); ?>" e-min-dte="<?php echo datetimeToPapouch($nejnizsi['kdy']); ?>" e-max-dte="<?php echo datetimeToPapouch($nejvyssi['kdy']); ?>"/>
  <sns id="2" type="2" status="0" unit="3" val="<?php echo round($posledni['vlhkost'], 1); ?>" w-min="" w-max="" e-min-val=" <?php echo round($nejnizsiVlhkost['vlhkost'], 1); ?>" e-max-val=" <?php echo round($nejvyssiVlhkost['vlhkost'], 1); ?>" e-min-dte="<?php echo datetimeToPapouch($nejnizsiVlhkost['kdy']); ?>" e-max-dte="<?php echo datetimeToPapouch($nejvyssiVlhkost['kdy']); ?>"/>
  <sns id="3" type="3" status="0" unit="0" val="<?php echo round(rosnyBod($posledni['teplota'], $posledni['vlhkost']), 1); ?>" w-min="" w-max="" e-min-val="" e-max-val="" e-min-dte="" e-max-dte=""/>
  <status frm="1" location="<?php echo $umisteni; ?>" time="<?php echo datetimeToPapouch($posledni['kdy']); ?>"/>
</root>

<?php
  }