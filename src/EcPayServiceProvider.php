<?php
namespace Javck\Ecpay;

use Illuminate\Support\ServiceProvider;

class EcPayServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerConfigs();
        }
        $this->registerResources();
        if (EcPay::$useECPayRoute) {
            include dirname(__DIR__) . '/routes/ecpay.php';
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