<?php
/* -----------------------------------------------------------
Copyright (c) 2020 Releva GmbH - https://www.releva.nz
Released under the MIT License (Expat)
[https://opensource.org/licenses/MIT]
--------------------------------------------------------------
*/
$_relevanz_hook = DIR_FS_EXTERNAL.'/relevanz/shop/hooks/'.basename(__DIR__).'.php';
if (file_exists($_relevanz_hook)) {
    require($_relevanz_hook);
}
unset($_relevanz_hook);
