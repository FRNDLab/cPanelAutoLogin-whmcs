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

if (!defined('WHMCS'))
    die('You cannot access this file directly.');


function cPanelAutoLogin($vars) {

    if ($vars['modulename'] === 'cpanelExtended' || $vars['modulename'] === 'cpanel') {


    $serviceid = $vars['serviceid'];

    $html = <<<HTML
    <div class="full-screen-module-container" id="layers">
       <div class="h4 lu-m-b-3x lu-m-t-2x">Inicie sesión con un clic</div>
       <div class="lu-tiles lu-row row--eq-height">
          <div class="lu-col-xs-6 lu-col-md-20p">
             <a href="/index.php?m=cpanelautologin&action=cpanel&serviceid={$serviceid}&service=cpanel" target="_blank" class="lu-tile lu-tile--btn">
                <div class="lu-i-c-6x">
                   <img src="/modules/addons/cpanelautologin/assets/img/icon-cpanel.png" alt="">
                </div>
                <div class="lu-tile__title">cPanel</div>
             </a>
          </div>
          <div class="lu-col-xs-6 lu-col-md-20p">
             <a href="/index.php?m=cpanelautologin&action=cpanel&serviceid={$serviceid}&service=FileManager" target="_blank" class="lu-tile lu-tile--btn">
                <div class="lu-i-c-6x">
                   <img src="/modules/addons/cpanelautologin/assets/img/icon-FileManager.png" alt="">
                </div>
                <div class="lu-tile__title">File Manager</div>
             </a>
          </div>
          <div class="lu-col-xs-6 lu-col-md-20p">
             <a href="/index.php?m=cpanelautologin&action=cpanel&serviceid={$serviceid}&service=phpmyadmin" target="_blank" class="lu-tile lu-tile--btn">
                <div class="lu-i-c-6x">
                   <img src="/modules/addons/cpanelautologin/assets/img/icon-phpmyadmin.png" alt="">
                </div>
                <div class="lu-tile__title">phpMyAdmin</div>
             </a>
          </div>
       </div>
    </div>
    HTML;

    return array(
        "cPanelAutoLogin" => $html
    );

   } else {
      return;
   }

}

add_hook('ClientAreaProductDetailsPreModuleTemplate', 1, 'cPanelAutoLogin');    
