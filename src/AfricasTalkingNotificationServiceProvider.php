<?php

namespace FreddyGenicho\AfricasTalking;

use AfricasTalking\SDK\AfricasTalking;
use FreddyGenicho\AfricasTalking\Channel\AfricasTalkingChannel;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Notification;
use mysql_xdevapi\Exception;

class AfricasTalkingNotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/africastalking.php', 'africastalking'
        );

        $this->app->when(AfricasTalkingChannel::class)
            ->needs(AfricasTalking::class)
            ->give(function () {
                if (!config('africastalking.username')) {
                    throw new \Exception('Africastalking `username`. Missing');
                }

                if (!config('africastalking.api_key')) {
                    throw new \Exception('Africastalking `api_key`. Missing');
                }

                return new AfricasTalking(config('africastalking.username'), config('africastalking.api_key'));
            });

        $this->app->alias(AfricasTalking::class, 'africasTalking');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $this->publishes([__DIR__ . '/config/africastalking.php' => config_path('africastalking.php'),]);

        Notification::resolved(function (ChannelManager $service) {
            $service->extend('africasTalking', function ($app) {
                return new AfricasTalkingChannel($app->make('africasTalking'));
            });
        });
    }
}
