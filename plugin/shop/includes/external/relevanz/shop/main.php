<?php
/* -----------------------------------------------------------
Copyright (c) 2020 Releva GmbH - https://www.releva.nz
Released under the MIT License (Expat)
[https://opensource.org/licenses/MIT]
--------------------------------------------------------------
*/
require_once(__DIR__.'/../autoload.php');
require_once(__DIR__.'/controller/RelevanzCallbackRouter.php');

$module = new RelevanzCallbackRouter();
echo $module->route()->out();
