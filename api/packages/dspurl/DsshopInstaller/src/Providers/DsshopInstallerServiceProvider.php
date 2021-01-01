<?php

namespace Dspurl\DsshopInstaller\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Dspurl\DsshopInstaller\Middleware\canInstall;
use Dspurl\DsshopInstaller\Middleware\canUpdate;

class DsshopInstallerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->publishFiles();
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
    }

    /**
     * Bootstrap the application events.
     *
     * @param \Illuminate\Routing\Router $router
     */
    public function boot(Router $router)
    {
        $router->middlewareGroup('install', [CanInstall::class]);
        $router->middlewareGroup('update', [CanUpdate::class]);
    }

    /**
     * Publish config file for the installer.
     *
     * @return void
     */
    protected function publishFiles()
    {
        $this->publishes([
            __DIR__ . '/../Config/installer.php' => base_path('config/installer.php'),
        ], 'dsshoplinstaller');

        $this->publishes([
            __DIR__ . '/../assets' => public_path('installer'),
        ], 'dsshoplinstaller');

        $this->publishes([
            __DIR__ . '/../Views' => base_path('resources/views/vendor/installer'),
        ], 'dsshoplinstaller');

        $this->publishes([
            __DIR__ . '/../Lang' => base_path('resources/lang'),
        ], 'dsshoplinstaller');
    }
}
