<?php
/* -----------------------------------------------------------
Copyright (c) 2020 Releva GmbH - https://www.releva.nz
Released under the MIT License (Expat)
[https://opensource.org/licenses/MIT]
--------------------------------------------------------------
*/
require_once(__DIR__.'/../../autoload.php');
require_once(__DIR__.'/controller/RelevanzHookAbstract.php');
require_once(__DIR__.'/controller/RelevanzHeaderBodyHook.php');

$relevanzHC = new RelevanzHeaderBodyHook();
$relevanzHC->run();
