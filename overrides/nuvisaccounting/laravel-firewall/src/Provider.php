<?php

namespace NuvisAccounting\Firewall;

use NuvisAccounting\Firewall\Commands\UnblockIp;
use NuvisAccounting\Firewall\Events\AttackDetected;
use NuvisAccounting\Firewall\Listeners\BlockIp;
use NuvisAccounting\Firewall\Listeners\CheckLogin;
use NuvisAccounting\Firewall\Listeners\NotifyUsers;
use Illuminate\Auth\Events\Failed as LoginFailed;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Router $router
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $langPath = 'vendor/firewall';

        $langPath = (function_exists('lang_path'))
            ? lang_path($langPath)
            : resource_path('lang/' . $langPath);

        $this->publishes([
            __DIR__ . '/Config/firewall.php'                                            => config_path('firewall.php'),
            __DIR__ . '/Migrations/2019_07_15_000000_create_firewall_ips_table.php'     => database_path('migrations/2019_07_15_000000_create_firewall_ips_table.php'),
            __DIR__ . '/Migrations/2019_07_15_000000_create_firewall_logs_table.php'    => database_path('migrations/2019_07_15_000000_create_firewall_logs_table.php'),
            __DIR__ . '/Resources/lang'                                                 => $langPath,
        ], 'firewall');

        $this->registerMiddleware($router);
        $this->registerListeners();
        $this->registerTranslations($langPath);
        $this->registerCommands();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/firewall.php', 'firewall');

        $this->app->register(\Jenssegers\Agent\AgentServiceProvider::class);
    }

    /**
     * Register middleware.
     *
     * @param Router $router
     *
     * @return void
     */
    public function registerMiddleware($router)
    {
        $router->middlewareGroup('firewall.all', config('firewall.all_middleware'));
        $router->aliasMiddleware('firewall.agent', 'NuvisAccounting\Firewall\Middleware\Agent');
        $router->aliasMiddleware('firewall.bot', 'NuvisAccounting\Firewall\Middleware\Bot');
        $router->aliasMiddleware('firewall.ip', 'NuvisAccounting\Firewall\Middleware\Ip');
        $router->aliasMiddleware('firewall.geo', 'NuvisAccounting\Firewall\Middleware\Geo');
        $router->aliasMiddleware('firewall.lfi', 'NuvisAccounting\Firewall\Middleware\Lfi');
        $router->aliasMiddleware('firewall.php', 'NuvisAccounting\Firewall\Middleware\Php');
        $router->aliasMiddleware('firewall.referrer', 'NuvisAccounting\Firewall\Middleware\Referrer');
        $router->aliasMiddleware('firewall.rfi', 'NuvisAccounting\Firewall\Middleware\Rfi');
        $router->aliasMiddleware('firewall.session', 'NuvisAccounting\Firewall\Middleware\Session');
        $router->aliasMiddleware('firewall.sqli', 'NuvisAccounting\Firewall\Middleware\Sqli');
        $router->aliasMiddleware('firewall.swear', 'NuvisAccounting\Firewall\Middleware\Swear');
        $router->aliasMiddleware('firewall.url', 'NuvisAccounting\Firewall\Middleware\Url');
        $router->aliasMiddleware('firewall.whitelist', 'NuvisAccounting\Firewall\Middleware\Whitelist');
        $router->aliasMiddleware('firewall.xss', 'NuvisAccounting\Firewall\Middleware\Xss');
    }

    /**
     * Register listeners.
     *
     * @return void
     */
    public function registerListeners()
    {
        $this->app['events']->listen(AttackDetected::class, BlockIp::class);
        $this->app['events']->listen(AttackDetected::class, NotifyUsers::class);
        $this->app['events']->listen(LoginFailed::class, CheckLogin::class);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations($langPath)
    {
        $this->loadTranslationsFrom(__DIR__ . '/Resources/lang', 'firewall');

        $this->loadTranslationsFrom($langPath, 'firewall');
    }

    public function registerCommands()
    {
        $this->commands(UnblockIp::class);

        if (config('firewall.cron.enabled')) {
            $this->app->booted(function () {
                app(Schedule::class)->command('firewall:unblockip')->cron(config('firewall.cron.expression'));
            });
        }
    }
}
