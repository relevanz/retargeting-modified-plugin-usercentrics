<?php
/* -----------------------------------------------------------
Copyright (c) 2020 Releva GmbH - https://www.releva.nz
Released under the MIT License (Expat)
[https://opensource.org/licenses/MIT]
--------------------------------------------------------------
*/
if (defined('MODULE_RELEVANZ_STATUS')
    && (MODULE_RELEVANZ_STATUS == 'True')
) {
    require_once(__DIR__.'/../autoload.php');
    Releva\Retargeting\Modified\Helper::loadLanguage();

    $add_contents[BOX_HEADING_PARTNER_MODULES]['releva.nz'][0] = array(
        'admin_access_name' => 'relevanz',   //Eintrag fuer Adminrechte
        'filename' => 'relevanz.php',        //Dateiname der neuen Admindatei
        'boxname' => 'releva.nz',            //Anzeigename im Menue
        'parameters' => '',                  //zusaetzliche Parameter z.B. 'set=export'
        'ssl' => '',                         //SSL oder NONSSL, kein Eintrag = NONSSL
        'has_subs' => 1                      //wenn Menueeintrag Unterpunkte hat
    );

    $add_contents[BOX_HEADING_PARTNER_MODULES]['releva.nz'][1] = array(
        'admin_access_name' => 'relevanz',
        'filename' => 'relevanz.php',
        'boxname' => 'releva.nz - '.RELEVANZ_TAB_STATS,
        'parameters' => 'tab=stats',
        'ssl' => ''
    );

    $add_contents[BOX_HEADING_PARTNER_MODULES]['releva.nz'][2] = array(
        'admin_access_name' => 'relevanz',
        'filename' => 'relevanz.php',
        'boxname' => 'releva.nz - '.RELEVANZ_TAB_CONF,
        'parameters' => 'tab=conf',
        'ssl' => ''
    );
}
