<?php
/* -----------------------------------------------------------
Copyright (c) 2020 Releva GmbH - https://www.releva.nz
Released under the MIT License (Expat)
[https://opensource.org/licenses/MIT]
--------------------------------------------------------------
*/
defined('DIR_WS_MOD_RELEVANZ') OR define(
    'DIR_WS_MOD_RELEVANZ',
    DIR_WS_CATALOG.str_replace(DIR_FS_DOCUMENT_ROOT, '', dirname(__DIR__).'/')
);

require_once(__DIR__.'/../autoload.php');
require_once(__DIR__.'/controller/RelevanzAdminModule.php');
new RelevanzAdminModule();
