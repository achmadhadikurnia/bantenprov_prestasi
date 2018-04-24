<?php

namespace Bantenprov\Prestasi;

use Illuminate\Support\ServiceProvider;
use Bantenprov\Prestasi\Console\Commands\PrestasiCommand;

/**
 * The PrestasiServiceProvider class
 *
 * @package Bantenprov\Prestasi
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class PrestasiServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->routeHandle();
        $this->configHandle();
        $this->langHandle();
        $this->viewHandle();
        $this->assetHandle();
        $this->migrationHandle();
        $this->publicHandle();
        $this->seedHandle();
        $this->publishHandle();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('prestasi', function ($app) {
            return new Prestasi;
        });

        $this->app->singleton('command.prestasi', function ($app) {
            return new PrestasiCommand;
        });

        $this->commands('command.prestasi');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'prestasi',
            'command.prestasi',
        ];
    }

    /**
     * Loading and publishing package's config
     *
     * @return void
     */
    protected function configHandle($publish = '')
    {
        $packageConfigPath = __DIR__.'/config';
        $appConfigPath     = config_path('bantenprov/prestasi');

        $this->mergeConfigFrom($packageConfigPath.'/prestasi.php', 'prestasi');
        $this->mergeConfigFrom($packageConfigPath.'/master-prestasi.php', 'master-prestasi');
        $this->mergeConfigFrom($packageConfigPath.'/jenis-prestasi.php', 'jenis-prestasi');

        $this->publishes([
            $packageConfigPath.'/prestasi.php' => $appConfigPath.'/prestasi.php',
            $packageConfigPath.'/master-prestasi.php' => $appConfigPath.'/master-prestasi.php',
            $packageConfigPath.'/jenis-prestasi.php' => $appConfigPath.'/jenis-prestasi.php',
        ], $publish ? $publish : 'prestasi-config');
    }

    /**
     * Loading package routes
     *
     * @return void
     */
    protected function routeHandle()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/routes.php');
    }

    /**
     * Loading and publishing package's translations
     *
     * @return void
     */
    protected function langHandle($publish = '')
    {
        $packageTranslationsPath = __DIR__.'/resources/lang';

        $this->loadTranslationsFrom($packageTranslationsPath, 'prestasi');

        $this->publishes([
            $packageTranslationsPath => resource_path('lang/vendor/prestasi'),
        ], $publish ? $publish : 'prestasi-lang');
    }

    /**
     * Loading and publishing package's views
     *
     * @return void
     */
    protected function viewHandle($publish = '')
    {
        $packageViewsPath = __DIR__.'/resources/views';

        $this->loadViewsFrom($packageViewsPath, 'prestasi');

        $this->publishes([
            $packageViewsPath => resource_path('views/vendor/prestasi'),
        ], $publish ? $publish : 'prestasi-views');
    }

    /**
     * Publishing package's assets (JavaScript, CSS, images...)
     *
     * @return void
     */
    protected function assetHandle($publish = '')
    {
        $packageAssetsPath = __DIR__.'/resources/assets';

        $this->publishes([
            $packageAssetsPath => resource_path('assets'),
        ], $publish ? $publish : 'prestasi-assets');
    }

    /**
     * Publishing package's migrations
     *
     * @return void
     */
    protected function migrationHandle($publish = '')
    {
        $packageMigrationsPath = __DIR__.'/database/migrations';

        $this->loadMigrationsFrom($packageMigrationsPath);

        $this->publishes([
            $packageMigrationsPath => database_path('migrations')
        ], $publish ? $publish : 'prestasi-migrations');
    }

    /**
     * Publishing package's publics (JavaScript, CSS, images...)
     *
     * @return void
     */
    public function publicHandle($publish = '')
    {
        $packagePublicPath = __DIR__.'/public';

        $this->publishes([
            $packagePublicPath => base_path('public')
        ], $publish ? $publish : 'prestasi-public');
    }

    /**
     * Publishing package's seeds
     *
     * @return void
     */
    public function seedHandle($publish = '')
    {
        $packageSeedPath = __DIR__.'/database/seeds';

        $this->publishes([
            $packageSeedPath => base_path('database/seeds')
        ], $publish ? $publish : 'prestasi-seeds');
    }

    /**
     * Publishing package's all files
     *
     * @return void
     */
    public function publishHandle()
    {
        $publish = 'prestasi-publish';

        $this->routeHandle($publish);
        $this->configHandle($publish);
        $this->langHandle($publish);
        $this->viewHandle($publish);
        $this->assetHandle($publish);
        // $this->migrationHandle($publish);
        $this->publicHandle($publish);
        $this->seedHandle($publish);
    }
}
