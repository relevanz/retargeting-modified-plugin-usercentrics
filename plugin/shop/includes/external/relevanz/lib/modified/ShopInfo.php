<?php
/* -----------------------------------------------------------
Copyright (c) 2020 Releva GmbH - https://www.releva.nz
Released under the MIT License (Expat)
[https://opensource.org/licenses/MIT]
--------------------------------------------------------------
*/
namespace Releva\Retargeting\Modified;

use Releva\Retargeting\Base\AbstractShopInfo;

class ShopInfo extends AbstractShopInfo
{
    const ROUTE_CALLBACK = 'relevanz.php?controller=callback&auth=:auth';
    const ROUTE_EXPORT   = 'relevanz.php?controller=export-products&auth=:auth';

    /**
     * Technical name of the shop system.
     *
     * @return string
     */
    public static function getShopSystem() {
        return 'modified';
    }

    /**
     * Version of the shop as a string.
     */
    public static function getShopVersion() {
        if (!file_exists(DIR_FS_CATALOG.DIR_ADMIN.'includes/version.php')
            || !is_readable(DIR_FS_CATALOG.DIR_ADMIN.'includes/version.php')
        ) {
            return null;
        }
        // including the file causes notices.
        $c = file_get_contents(DIR_FS_CATALOG.DIR_ADMIN.'includes/version.php');
        $m = [];
        if (!preg_match_all('/define\(\'([^\']+)\',\s*\'([^\']+)\'\);/', $c, $m, PREG_SET_ORDER)) {
            return null;
        }
        $r = [];
        foreach ($m as $define) {
            $r[$define[1]] = $define[2];
        }
        return $r['PROJECT_MAJOR_VERSION'].'.'.$r['PROJECT_MINOR_VERSION'].' rev '.$r['PROJECT_REVISION'].(
            (isset($r['PROJECT_SERVICEPACK_VERSION']) && !empty($r['PROJECT_SERVICEPACK_VERSION']))
                ? ' SP' . $r['PROJECT_SERVICEPACK_VERSION']
                : ''
        );
    }

    /**
     * Basically the result of the following sql query:
     *    SELECT @@version AS `version`, @@version_comment AS `server`
     */
    public static function getDbVersion() {
        $default = [
            'version' => null,
            'server' => null,
        ];
        $foo = xtc_db_query(
            'SELECT @@version AS `version`, @@version_comment AS `server`'
        );
        if (xtc_db_num_rows($foo, true) === 0) {
            return $default;
        }
        $row = xtc_db_fetch_array($foo, true);
        if (is_array($row)) {
            return $row;
        }
        return $default;
    }

    public static function getUrlCallback() {
        return HTTP_SERVER.str_replace('//', '/', DIR_WS_CATALOG.'/'.self::ROUTE_CALLBACK);
    }

    public static function getUrlProductExport() {
        return HTTP_SERVER.str_replace('//', '/', DIR_WS_CATALOG.'/'.self::ROUTE_EXPORT);
    }

}
