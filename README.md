# CentauroSmsLaravel
Component / Package para API Centauro SMS Laravel

### Instalacion

```php
composer require mixzplit/centauro-sms-dev
```

Tambien se puede agregar al archivo composer.json de nuestro proyecto en la seccion require

```php
mixzplit/centauro-sms-dev
```

Agregar el Provider y Alias en config/app.php

Providers
```php
    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
	Mixzplit\CentauroSMS\Providers\CentauroSmsServiceProvider::class,

    ],
```
Aliases
```php
    'aliases' => [

        /*
         * Laravel Framework Service Providers...
         */
	'CentauroSMS' => Mixzplit\CentauroSMS\Facades\CentauroSMS::class,

    ],
```

### Configuración

Despues de agregar los providers y aliases debemos crear o publicar el archivo de configuracion de credenciales para poder usar el servicio de envio de mensajes de texto. Para generar el archivo de configuracion ejecutamos el siguiente comando artisan:

```php
php artisan vendor:publish
```

El comando generar el archivo ```php app/CentauroSMS.php ```, aqui podra agregar las credenciales de la API, que se pueden obtener en http://www.centaurosms.com.ve y poseer un plan de SMS activo, validos para Venezuela ó Colombia. El archivo contiene lo siguiente:

```php
	return [
		'centauro_key'     => env('CENTAURO_KEY', 'CENTAURO_CODE_KEY'),
		'centauro_secret' => env('CENTAURO_SECRET', 'CENTAURO_CODE_SECRET')
	];
```

Tambien puede configurar sus credenciales para mas seguridad en su archivo .env (Recomendado) agregando las variables de entorno ´´´php CENTAURO_KEY´´´  y  ´´´php CENTAURO_SECRET´´´ y colocando los codigos correspondientes.

### Como usuar

´´´php

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use CentauroSMS;

class SmsController extends Controller
{

    public function send()
    {
        //Mensajes a un solo Destinatario
        $destinatarios = array("id" => "0","cel" => '04140000000',"nom" => 'Julian Pacheco');
        $msg = 'Mensaje';
        $js = json_encode($destinatarios);
        $result = CentauroSMS::set_sms_send($js,$msg); // Comando para enviar SMS Normales
        if($result['status']=='200'){

            $nombre = $result['response'][0]['datos'][0]['Nom'];
            $celular = $result['response'][0]['datos'][0]['Cel'];
            $Messageid = $result['response'][0]['datos'][0]['Messageid'];
            $StatusText = $result['response'][0]['datos'][0]['StatusText'];
            $Msg = $result['response'][0]['datos'][0]['Msg'];

            return response()->json([
                    'nombre' => $nombre, 
                    'celular' => $celular,
                    'mensaje_id' => $Messageid,
                    'status_text' => $StatusText,
                    'mensaje' => $Msg, 
                    'status' => 'OK', 200
                ]);
        }else{
            //RESPUESTA DE ERROR DEL SERVER
            if ($result['status']=='305'){ 
                return response()->json(['mensaje' => "No tiene SMS disponibles para realizar este envio", 'status' => 305, 305]);
            }
            if ($result['status']=='304'){ 
                return response()->json(['mensaje' => "Los parametros no son correctos por favor no modifique la API", 'status' => 304, 304]);
            }
            if ($result['status']=='303'){ 
                return response()->json(['mensaje' => "Error grave no se recibio parametro de la API", 'status' => 303, 303]);
            }
            if ($result['status']=='302'){ 
                return response()->json(['mensaje' => "Servidores fuera de linea", 'status' => 302, 302]);
            }
            if ($result['status']=='301'){ 
                return response()->json(['mensaje' => "Error de credenciales", 'status' => 301, 301]);
            }
            if ($result['status']=='300'){ 
                return response()->json(['mensaje' => "No se recibieron los parametros necesarios", 'status' => 300, 300]);
            }

        }
        
    }


}

´´´

### Mas información

Puede conseguir mas informacion y funciones de uso en el repositorio original del desarrollador https://github.com/hdcr1985/CentauroSMS
