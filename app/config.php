<?php

  //////////////////////////////////////////
  // ZAKLADNI NASTAVENI / BASIC SETTINGS
  //////////////////////////////////////////

  $dbServer = "localhost"; // CZ: server, kde bezi databaze
                           // EN: server address, where DB is running

  $dbUzivatel = "";     // CZ: uzivatelske jmeno pro prihlaseni do databaze
                        // EN: username for DB

  $dbHeslo = "";    // CZ: heslo pro prihlaseni do databaze
                    // EN: password for DB

  $dbDb = "";       // CZ: nazev databaze
                    // EN: database name

  $GUID = "temp"; // CZ: nazev retezce, pod kterym teplomer odesila aktualni teplotu
                     // naprosto stejny retezec je nutno nastavit v nastaveni HTTP GET
                     // v utilite pro nastaveni teplomeru od Papoucha
                     // EN: string name, which is sended by TME and which contains
                     // measured temperatur (value is saved in DB) - this name must
                     // be the same also in TME settings, otherwise temperature
                     // will NOT be saved

  $vlhkomer = 1; // CZ: zobrazovat hodnoty o vlkhosti?
                 // Pokud nemate vlkhomer, nastavte 0.
                 // EN: show measurements about humidity?
                 // If you do not have TME with humidity meter, set it to 0.

  //////////////////////////////////////////
  // Ostatni / Other settings
  //////////////////////////////////////////

  $ip = "";     // CZ: IP adresa, ze ktere bude mozno pridavat hodnoty do DB kvuli ochrane
                // je potreba zadat IP, pod kterou pozadavek na stranku doopravdy prichazi
                // tedy tu IP, pod kterou na internetu vystupujete... nutno ozkouset
                // EN: IP address, from which are measurements by TME sended... it
                // should be your public IP, from which you are visible on the internet
                // (or your private local address, if webserver and TME are on the same
                // local network)

  $umisteni = "Na zahradě"; // CZ: Umisteni teplomeru (text na strance teplomeru)
                      // EN: Thermoter location (showed as text on webpage)

  $l = "cz"; // CZ: vychozi jazyk - cz, en, de, fr...
             // EN: default language - cz, en, de, fr...

  $u = "C"; // CZ: vychozi jednotka, C - Celsius, F - Fahrenheit, K - Kelvin,
            //     R - Rankine, D - Delisle, N - Newton, Re - Reaumur, Ro - Romer
            // EN: default temp. scale, C - Celsius, F - Fahrenheit, K - Kelvin,
            //     R - Rankine, D - Delisle, N - Newton, Re - Reaumur, Ro - Romer

  $obnoveniStranky = 0;  // CZ: Obnoveni stranky po X vterinach... (0 znamena zadne obnoveni)
                         // EN: Page refresh after X seconds... (0 for no refresh)

  $zobrazitNastaveni = 1;  // CZ: Zda bude zobrazen radek s moznosti
                           //     prepinat jednotku a jazyk
                           // EN: If line with ability to change temp. scale and
                           //     language will show up

  $presmerovavatMobily = 1;  // CZ: Pokud si uživatel stránku prohlíží z mobilu,
                             //     přesměrovat jej rovnou na mobilní verzi?
                             // EN: If user uses mobile device,
                             //     redirect him automatically on mobile version?
