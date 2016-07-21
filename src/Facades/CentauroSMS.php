<?php 
namespace Mixzplit\CentauroSMS\Facades;

use Illuminate\Support\Facades\Facade;

class CentauroSMS extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'CentauroSMS';
    }
}