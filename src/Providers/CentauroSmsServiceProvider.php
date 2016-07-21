<?php 
namespace Mixzplit\CentauroSMS\Providers;

use Illuminate\Support\ServiceProvider;
use Mixzplit\CentauroSMS\CentauroSMS;

class CentauroSmsServiceProvider extends ServiceProvider 
{

	protected $cs_centauro_key;
	protected $cs_centauro_secret;

	public function boot()
	{
		
		$this->publishes([__DIR__.'/config/CentauroSMS.php' => config_path('CentauroSMS.php')]);

		$this->cs_centauro_key     = config('CentauroSMS.centauro_key');
		$this->cs_centauro_secret  = config('CentauroSMS.centauro_secret');
	}

	public function register()
	{
		$this->app->singleton('CentauroSMS', function(){
			return new CentauroSMS($this->cs_centauro_key, $this->cs_centauro_secret);
		});
	}
}