<?php
/* -----------------------------------------------------------
Copyright (c) 2020 Releva GmbH - https://www.releva.nz
Released under the MIT License (Expat)
[https://opensource.org/licenses/MIT]
--------------------------------------------------------------
*/
use Releva\Retargeting\Base\Exception\RelevanzException;
use Releva\Retargeting\Base\HttpResponse;
use Releva\Retargeting\Modified\ShopInfo;
use Releva\Retargeting\Modified\Configuration as ShopConfiguration;
/**
 * This controller generates some status informations about the shop
 * and the plugin which are used by the releva.nz service.
 */
class RelevanzCallbackController
{
    protected function discoverCallbacks() {
        $callbacks = [];
        $dir = new DirectoryIterator(__DIR__);
        foreach ($dir as $fileinfo) {
            $m = [];
            if (!preg_match('/^(Relevanz([A-Za-z0-9]+)Controller).php$/', $fileinfo->getFilename(), $m)) {
                continue;
            }
            require_once($fileinfo);
            $class = $m[1];
            $cbname = strtolower($m[2]);
            if (class_exists($class) && is_callable($class .'::discover')) {
                $callbacks[$cbname] = call_user_func($class .'::discover');
            }
        }
        return $callbacks;
    }

    public function actionDefault() {
        $data = [
            'plugin-version' => ShopConfiguration::getPluginVersion(),
            'shop' => [
                'system' => ShopInfo::getShopSystem(),
                'version' => ShopInfo::getShopVersion(),
            ],
            'environment' => ShopInfo::getServerEnvironment(),
            'callbacks' => $this->discoverCallbacks()
        ];
        return new HttpResponse(json_encode($data, JSON_PRETTY_PRINT | JSON_PRESERVE_ZERO_FRACTION), [
            'Content-Type: application/json; charset="utf-8"',
            'Cache-Control: must-revalidate',
        ]);
    }

}

