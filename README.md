# laravel-africastalking-notification

Laravel AfricasTalking Notification Channel

[![Latest Version](https://img.shields.io/github/release/freddygenicho/laravel-africastalking-notification.svg?style=flat-square)](https://github.com/benwilkins/laravel-fcm-notification/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

Use this package to send sms notifications via Africastaclking. Laravel 5.3+ required.

## Install

This package can be installed through Composer.

``` bash
composer require freddygenicho/laravel-africastalking-notification
```

If installing on < Laravel 5.5 then add the service provider:

```php
// config/app.php
'providers' => [
    ...
    FreddyGenicho\AfricasTalking\AfricasTalkingNotificationServiceProvider::class,
    ...
];
```

First, publish configuration files
```php
php artisan vendor:publish --provider="FreddyGenicho\AfricasTalking\AfricasTalkingNotificationServiceProvider"
```
This will publish the africastalking configuration file into the config directory as africastalking.php. This file contains all the configurations required to use the package.

## Example Usage

Use Artisan to create a notification:

```bash
php artisan make:notification SomeNotification
```

Return `[fcm]` in the `public function via($notifiable)` method of your notification:

```php
/**
* @param $notifiable
* @return array
*/
public function via($notifiable)
{
    return ['africasTalking'];
}
```

Add the method `public function toAfricasTalking($notifiable)` to your notification, and return an instance of `AfricasTalkingMessage`: 

```php
use FreddyGenicho\AfricasTalking\Message\AfricasTalkingMessage;

...
/**
* Get the AfricasTalking representation of the notification.
* @param $notifiable
* @return AfricasTalkingMessage
*/
public function toAfricasTalking($notifiable)
{
   return (new AfricasTalkingMessage())
          ->message('Hello world');
}
```

In order to let your Notification know which phone are you sending/calling to, the channel will look for the `phone_number` attribute of the Notifiable model. If you want to override this behaviour, add the `routeNotificationForAfricasTalking` method to your Notifiable model.

```php
public function routeNotificationForAfricasTalking()
{
    return '+25412345678';
}
```
## Security

If you discover any security related issues, please email fredygenicho@gmail.com instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

