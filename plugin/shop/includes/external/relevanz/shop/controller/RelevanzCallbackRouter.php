<?php
/* -----------------------------------------------------------
Copyright (c) 2020 Releva GmbH - https://www.releva.nz
Released under the MIT License (Expat)
[https://opensource.org/licenses/MIT]
--------------------------------------------------------------
*/
use Releva\Retargeting\Base\HttpResponse;
use Releva\Retargeting\Base\Exception\RelevanzException;
use Releva\Retargeting\Modified\Configuration as ShopConfiguration;

class RelevanzCallbackRouter {
    protected $credentials = null;

    final protected function init() {
        if (!defined('MODULE_RELEVANZ_STATUS')
            || (MODULE_RELEVANZ_STATUS != 'True')
        ) {
            throw new RelevanzException('releva.nz module not installed.', 1554157518);
        }

        $this->credentials = ShopConfiguration::getCredentials();
        if (!$this->credentials->isComplete()) {
            throw new RelevanzException('releva.nz module is not configured.', 1554158425);
        }
    }

    protected function verifyAuth() {
        if (!isset($_REQUEST['auth']) || ($_REQUEST['auth'] !== $this->credentials->getAuthHash())) {
            return new HttpResponse('Missing authentification', [
                'HTTP/1.0 401 Unauthorized',
                'Content-Type: text/plain; charset="utf-8"',
                'Cache-Control: must-revalidate',
            ]);
        }

        return null;
    }

    final public function route() {
        try {
            $this->init();

            $controllerName = (isset($_GET['controller']) && preg_match('/^[a-z-]+$/', $_GET['controller']))
                ? ucfirst($_GET['controller'])
                : '';
            $controllerName = preg_replace_callback('/-(.?)/', function($matches) {
                 return ucfirst($matches[1]);
            }, $controllerName);

            if (empty($controllerName)) {
                throw new RelevanzException('No controller parameter specified.', 1554929569);
            }
            $controllerName = 'Relevanz'.$controllerName.'Controller';
            if (!file_exists(__DIR__.'/'.$controllerName.'.php')) {
                throw new RelevanzException('The specified controller does not exist.', 1554929571);
            }
            require_once(__DIR__.'/'.$controllerName.'.php');
            $c = new $controllerName();

            $actionName = (isset($_GET['action']) && preg_match('/^[a-z-]+$/', $_GET['action']))
                ? ucfirst($_GET['action'])
                : 'Default';
            $actionName = 'action'.preg_replace_callback('/-(.?)/', function($matches) {
                 return ucfirst($matches[1]);
            }, $actionName);

            if (method_exists($c, 'setCredentials')) {
                $c->setCredentials($this->credentials);
            }

            if (!method_exists($c, $actionName)) {
                throw new RelevanzException('The requested action is not defined.', 1554929585);
            }

            return call_user_func(array($c, $actionName));

        } catch (RelevanzException $e) {
            return new HttpResponse($e->getMessage(), [
                'HTTP/1.0 404 Not Found',
                'Content-Type: text/plain; charset="utf-8"',
                'Cache-Control: must-revalidate',
            ]);

        } catch (Exception $e) {
            return new HttpResponse($e->getMessage(), [
                'HTTP/1.0 500 Internal Server Error',
                'Content-Type: text/plain; charset="utf-8"',
                'Cache-Control: must-revalidate',
            ]);
        }
    }
}
