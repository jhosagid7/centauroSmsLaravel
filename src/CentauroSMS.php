<?php
namespace Mixzplit\CentauroSMS;
/**
 * Libreria de Integracion CentauroSMS v1.2
 * API para Integracion de Envios de SMS a cualquier Aplicacion Web
 * 
 * @autor Hernan Crespo
 *
 */
class CentauroSMS {

    private $client_id;
    private $client_secret;
    private $result_data;

    function __construct($client_id, $client_secret) {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
    }

    /**
     * Obtener numero de SMS disponibles
     */
    public function get_sms_disponibles() {
       $credenciales = $this->cParametros(array(
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
			'client_opcion' => 'sms_disponibles'));

       return $result_data = cSMSClient::post("/controllersms/", $credenciales, "application/x-www-form-urlencoded");		
    }
    /**
     * Envio de SMS Masivos normales
     */    
    public function set_sms_send($json,$msg) {
       $credenciales = $this->cParametros(array(
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
			'json' => base64_encode(urlencode($json)),
			'msg' => base64_encode(urlencode($msg)),
			'client_opcion' => 'send_sms'));

       return $result_data = cSMSClient::post("/controllersms/", $credenciales, "application/x-www-form-urlencoded");		
    }
    /**
     * Envio de SMS Masivos personalizados
     */     	
    public function set_sms_send_personalizado($json){
       $credenciales = $this->cParametros(array(
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'json' => base64_encode(urlencode($json)),
            'client_opcion' => 'send_sms_personalizado'));

       return $result_data = cSMSClient::post("/controllersms/", $credenciales, "application/x-www-form-urlencoded");     
    }  
    private function cParametros($params) {
        if (function_exists("http_build_query")) {
            return http_build_query($params, "", "&");
        } else {
            foreach ($params as $name => $value) {
                $elements[] = "{$name}=" . urlencode($value);
            }
            return implode("&", $elements);
        }
    }	
	
}


