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

use WHMCS\Module\Addon\cpanelautologin\Client\ClientDispatcher;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

function cpanelautologin_config()
{
    return [
        // Display name for your module
        'name' => 'cPanelAutologin',
        // Description displayed within the admin interface
        'description' => 'Evita redireccionar a la dirección IP en lugar del Hostname cuando activamos Cloudflare en cPanel usando WHMCS',
        // Module author name
        'author' => '<a href="http://clotr.com" targer="_blank">clotr.com</a>',
        // Default language
        'language' => 'english',
        // Version number
        'version' => '1.0'
    ];
}

function cpanelautologin_clientarea($vars)
{
    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

    $dispatcher = new ClientDispatcher();
    return $dispatcher->dispatch($action, $vars);
}
