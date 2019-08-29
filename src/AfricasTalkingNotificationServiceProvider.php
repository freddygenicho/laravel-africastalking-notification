<?php

namespace FreddyGenicho\AfricasTalking;

use AfricasTalking\SDK\AfricasTalking;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Notification;
use FreddyGenicho\Africastalking\Channel\AfricasTalkingChannel;

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
            $service->extend('africasTalking', function () {
                return new AfricasTalkingChannel(
                    new AfricasTalking(config('africastalking.username'), config('africastalking.api_key'))
                );
            });
        });
    }
}
