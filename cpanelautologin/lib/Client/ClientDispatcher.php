<?php

/**
 *
 * Evita redireccionar a la dirección IP en lugar del Hostname cuando activamos Cloudflare en cPanel usando WHMCS.
 * 
 * @package    cPanelAutoLogin
 * @author     Fernando Torres <fernando@clotr.com>
 * @version    1.1.1
 * 
 */

namespace WHMCS\Module\Addon\cpanelautologin\Client;

/**
 * Sample Client Area Dispatch Handler
 */
class ClientDispatcher {

    /**
     * Dispatch request.
     *
     * @param string $action
     * @param array $parameters
     *
     * @return array
     */
    public function dispatch($action, $parameters)
    {
        if (!$action) {
            // Default to index if no action specified
            $action = 'index';
        }

        $controller = new Controller();

        // Verify requested action is valid and callable
        if (is_callable(array($controller, $action))) {
            return $controller->$action($parameters);
        }
    }
}
