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
 * Sample Client Area Controller
 */
class Controller {

    /**
     * Index action.
     *
     * @param array $vars Module configuration parameters
     *
     * @return array
     */
    public function index($vars)
    {
        return;
    }


    public function cpanel()
    {      
        new Cpanel;
    }    
}
