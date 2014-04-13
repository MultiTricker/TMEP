<?php

  echo "<div class='hlava'"; if($zobrazitNastaveni == 0){ echo " style='height: 30px;'"; } echo ">
        <div id='nadpis'><h1>".$lang['hlavninadpis']."</h1></div>";

  if($zobrazitNastaveni == 1)
  {

  echo "<div id='menu'>
  <nav>
	<ul>
		<li><a href='{$_SERVER['PHP_SELF']}?ja=cz&amp;je={$_GET['je']}'><span class=\"vlajka\" title='CZ'></span></a>
			<ul>
        <li><a href='{$_SERVER['PHP_SELF']}?ja=cz&amp;je={$_GET['je']}'><span class=\"vlajka\" title='CZ'></span></a></li>
        <li><a href='{$_SERVER['PHP_SELF']}?ja=sk&amp;je={$_GET['je']}'><span class=\"vlajka sk\" title='SK'></span></a></li>
        <li><a href='{$_SERVER['PHP_SELF']}?ja=en&amp;je={$_GET['je']}'><span class=\"vlajka en\" title='EN'></span></a></li>
        <li><a href='{$_SERVER['PHP_SELF']}?ja=de&amp;je={$_GET['je']}'><span class=\"vlajka de\" title='DE'></span></a></li>
        <li><a href='{$_SERVER['PHP_SELF']}?ja=ru&amp;je={$_GET['je']}'><span class=\"vlajka ru\" title='RU'></span></a></li>
        <li><a href='{$_SERVER['PHP_SELF']}?ja=pl&amp;je={$_GET['je']}'><span class=\"vlajka pl\" title='PL'></span></a></li>
        <li><a href='{$_SERVER['PHP_SELF']}?ja=fr&amp;je={$_GET['je']}'><span class=\"vlajka fr\" title='FR'></span></a></li>
        <li><a href='{$_SERVER['PHP_SELF']}?ja=fi&amp;je={$_GET['je']}'><span class=\"vlajka fi\" title='FI'></span></a></li>
        <li><a href='{$_SERVER['PHP_SELF']}?ja=sv&amp;je={$_GET['je']}'><span class=\"vlajka sv\" title='SV'></span></a></li>
			</ul>
		</li>
		<li><a href='{$_SERVER['PHP_SELF']}?je=C&amp;ja={$_GET['ja']}' title='Celsius'>Celsius</a>
			<ul>
        <li><a href='{$_SERVER['PHP_SELF']}?je=C&amp;ja={$_GET['ja']}' title='Celsius'>Celsius</a></li>
        <li><a href='{$_SERVER['PHP_SELF']}?je=F&amp;ja={$_GET['ja']}' title='Fahrenheit'>Fahrenheit</a></li>
        <li><a href='{$_SERVER['PHP_SELF']}?je=K&amp;ja={$_GET['ja']}' title='Kelvin'>Kelvin</a></li>
        <li><a href='{$_SERVER['PHP_SELF']}?je=R&amp;ja={$_GET['ja']}' title='Rankine'>Rankine</a></li>
        <li><a href='{$_SERVER['PHP_SELF']}?je=D&amp;ja={$_GET['ja']}' title='Delisle'>Delisle</a></li>
        <li><a href='{$_SERVER['PHP_SELF']}?je=N&amp;ja={$_GET['ja']}' title='Newton'>Newton</a></li>
        <li><a href='{$_SERVER['PHP_SELF']}?je=Re&amp;ja={$_GET['ja']}' title='Reaumur'>Reaumur</a></li>
        <li><a href='{$_SERVER['PHP_SELF']}?je=Ro&amp;ja={$_GET['ja']}' title='Romer'>Romer</a></li>
			</ul>
		</li>
	</ul>
</nav>
</div>";

  }

  echo "</div>
  
        <div id='tri' class='row'>";

        // Aktualne
        echo "<div class='col-md-3'>
                <div class='sloupekAktualne'>
                <div class='ajaxrefresh'>";
                  require_once dirname(__FILE__)."/ajax/aktualne.php";
            echo "</div>
                  </div>
                  </div>";

        // Drive touto dobou
        echo "<div class='col-md-3'>
                <div class='drivetoutodobouted'>";
                  require_once dirname(__FILE__)."/ajax/drive-touto-dobou.php";
          echo "</div>
              </div>";

      // Info tabulka
echo "<div class='col-md-5'>
          <table class='tabulkaVHlavicce'>
            <tr class='radek'>
              <td colspan='2'>{$lang['statistika']}</td>
            </tr>
            <tr>
              <td align='right'>{$lang['umisteni']}</td>
              <td>{$umisteni}</td>
            </tr>
            <tr>
              <td align='right'><a href='./scripts/modals/pocetMereni.php?je={$_GET['je']}&amp;ja={$_GET['ja']}' class='modal'>{$lang['pocetmereni']}</a></td>
              <td><div class='pocetmereni'>".number_format($pocetMereni['pocet'], 0, "", " ")."</div></td>
            </tr>
            <tr>
              <td align='right'>{$lang['merenood']}:</td>
              <td>".formatData($pocetMereni['kdy'])."</td>
            </tr>
            <tr>
              <td align='right'><a href='./scripts/modals/nejTeploty.php?je={$_GET['je']}&amp;ja={$_GET['ja']}' class='modal'>{$lang['nejvyssiteplota']}:</a></td>
              <td>".jednotkaTeploty($nejvyssi['teplota'], $u, 1)." - ".formatData($nejvyssi['kdy'])."</td>
            </tr>
            <tr>
              <td align='right'><a href='./scripts/modals/nejTeploty.php?je={$_GET['je']}&amp;ja={$_GET['ja']}' class='modal'>{$lang['nejnizsiteplota']}:</a></td>
              <td>".jednotkaTeploty($nejnizsi['teplota'], $u, 1)." - ".formatData($nejnizsi['kdy'])."</td>
            </tr>
          </table>
        </div>

        </div>";