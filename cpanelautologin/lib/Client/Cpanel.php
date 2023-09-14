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

use WHMCS\Authentication\CurrentUser;
use WHMCS\Database\Capsule;

class cpanel
{
    private $currentUser;
    private $serviceid;
    private $service;
    private $serverhostname;
    private $cpanel_user;
    private $serverid;
    private $accesshash;
    private $ipaddress;
    private $currentservice;
    private $session_url;

    public function __construct($vars=null)
    {

        $currentUser = new CurrentUser;
        $serviceid = $_GET['serviceid'];        
        $service = $_GET['service'];
        $services = array(
            "cpanel" => array(
                "service" => "cpaneld",
                "app" => null
            ),
            "FileManager" => array(
                "service" => "cpaneld",
                "app" => "FileManager_Home"
            ),
            "phpmyadmin" => array(
                "service" => "cpaneld",
                "app" => "Database_phpMyAdmin"
            ),
            "webmail" => array(
                "service" => "webmaild",
                "app" => null
            )
        );

        if (!$currentUser->isAuthenticatedUser()) {
            die('Debes iniciar sesion para ver esta pagina');
        }

        if (!$serviceid) {
            die('Debes especificar numero de servicio');
        }elseif (!is_numeric($serviceid)) {
            die('El formato del numero de servicio es incorrecto.');
        }  
        
        if (!array_key_exists($service, $services)) {
            die('El tipo de servicio es incorrecto');
        }

        $this->currentservice = $services[$service];
        $this->serviceid = $serviceid;
        $this->currentUser = $currentUser->client();

        $this->ProductInfo();
        $this->GetServerApi();
        $this->callcPanel();

        header("Location: $this->session_url");
        die();        
    }    

    function ProductInfo() {

        $command = 'GetClientsProducts';
        $postData = array(
            'clientid' => (int)$this->currentUser->id,
            'serviceid' => (int)$this->serviceid
        );     

        $result = localAPI($command, $postData);                          
        
        if ($result['result'] != 'success') {
            die('Ha ocurrido un error, contactanos support@clotr.com');
        }

        if ($result['totalresults'] <= 0) {
            die('No hemos encontrado el servicio solicitado.');
        }

        if ($result['products']['product'][0]['status'] != 'Active') {
            die('El servicio no esta activo');
        } 
        
        $product = $result['products']['product'][0];
        $this->serverid = $product['serverid'];
        $this->cpanel_user = $product['username'];        

        return $result;
    }

    function GetServerApi() {

        $r = Capsule::table('tblservers')->where('id', $this->serverid);        
        $r = $r->first();

        if (!$r->active) {
            die('El servidor no esta activo.');
        }

        $this->serverhostname = $r->hostname;
        $this->ipaddress = $r->ipaddress;
        $this->accesshash = $r->accesshash;

    }

    function callcPanel() {


        $whmusername = "root";

        $app = $this->currentservice['app'] ? '&app='.$this->currentservice['app'] : '';

        $query = "https://$this->serverhostname:2087/json-api/create_user_session?api.version=1&user=$this->cpanel_user&service={$this->currentservice['service']}$app";

        $curl = curl_init();                                     // Create Curl Object.
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);       // Allow self-signed certificates...
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);       // and certificates that don't match the hostname.
        curl_setopt($curl, CURLOPT_HEADER, false);               // Do not include header in output
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);        // Return contents of transfer on curl_exec.
        $header[0] = "Authorization: whm $whmusername:$this->accesshash";
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);         // Set the username and password.
        curl_setopt($curl, CURLOPT_URL, $query);                 // Execute the query.
        $result = curl_exec($curl);
        if ($result == false) {
            error_log("curl_exec threw error \"" . curl_error($curl) . "\" for $query");
            die('Ha ocurrido un error, contactanos support@clotr.com');
                                                            // log error if curl exec fails                                                            
        }
        
        
        $decoded_response = json_decode( $result, true );  

        $session_url = $decoded_response['data']['url'];
        $session_url = preg_replace('/([0-9]+\\.[0-9]+\\.[0-9]+)\\.[0-9]+/', $this->serverhostname, $session_url);
 
        
        curl_close($curl);

        $this->session_url = $session_url;

    }
}