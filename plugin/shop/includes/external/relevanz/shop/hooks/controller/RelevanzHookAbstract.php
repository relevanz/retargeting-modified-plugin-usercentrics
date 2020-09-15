<?php
/* -----------------------------------------------------------
Copyright (c) 2020 Releva GmbH - https://www.releva.nz
Released under the MIT License (Expat)
[https://opensource.org/licenses/MIT]
--------------------------------------------------------------
*/
use Releva\Retargeting\Modified\Configuration as ShopConfiguration;

class RelevanzHookAbstract {

    protected $credentials = [];

    final protected function init() {
        if (!defined('MODULE_RELEVANZ_STATUS')
            || (MODULE_RELEVANZ_STATUS != 'True')
        ) {
            return false;
        }

        $this->credentials = ShopConfiguration::getCredentials();

        if (!$this->credentials->isComplete()) {
            return false;
        }

        return true;
    }

}
