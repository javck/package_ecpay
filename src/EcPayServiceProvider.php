<?php
namespace Javck\EcPay;

use Illuminate\Support\ServiceProvider;

class EcPayServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerConfigs();
        }
        $this->registerResources();
        if (ECPay::$useECPayRoute) {
            $this->loadRoutesFrom(__DIR__ . '/routes.php');
        }
    }

    protected function registerConfigs()
    {
        $publishablePath = dirname(__DIR__) .'/publishable';
        $this->publishes([
            $publishablePath . '/config/ecpay.php' => config_path('ecpay.php'),
            $publishablePath . '/Http/Controllers' => app_path('Http/Controllers'),
        ], 'ecpay');
    }

    protected function registerResources()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'ecpay');
    }
}