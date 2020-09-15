<?php
/* -----------------------------------------------------------
Copyright (c) 2020 Releva GmbH - https://www.releva.nz
Released under the MIT License (Expat)
[https://opensource.org/licenses/MIT]
--------------------------------------------------------------
*/
namespace Releva\Retargeting\Modified;

/**
 * An own exception class to differenciate own exceptions from system exceptions.
 */
class Helper {
    public static function loadLanguage() {
        $langCode = (isset($_SESSION['language_code']) && preg_match('/^[a-z]{2}$/', $_SESSION['language_code']))
            ? strtolower($_SESSION['language_code'])
            : '';
        $langCode = empty($langCode) ? 'de' : $langCode;
        if (file_exists(__DIR__.'/../../lang/'.$langCode.'.php')) {
            require_once(__DIR__.'/../../lang/'.$langCode.'.php');
        } else {
            require_once(__DIR__.'/../../lang/de.php');
        }
    }
}
