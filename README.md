# PingID OAuth2 Provider for Laravel Socialite

```bash
composer require leroy-merlin-br/pingid-socialite-provider
```

## Installation & Basic Usage

Please see the [Base Installation Guide](https://socialiteproviders.com/usage/), then follow the provider specific instructions below.

### Add configuration to `config/services.php`

```php
'pingid' => [
  'base_url' => env('PINGID_BASE_URL'),
  'client_id' => env('PINGID_CLIENT_ID'),  
  'client_secret' => env('PINGID_CLIENT_SECRET'),  
  'redirect' => env('PINGID_REDIRECT_URI'),
  'logout_redirect' => env('PINGID_LOGOUT_REDIRECT_URI'),
],
```

### Add provider event listener

Configure the package's listener to listen for `SocialiteWasCalled` events.

Add the event to your `listen[]` array in `app/Providers/EventServiceProvider`. See the [Base Installation Guide](https://socialiteproviders.com/usage/) for detailed instructions.

```php
protected $listen = [
    \SocialiteProviders\Manager\SocialiteWasCalled::class => [
        // ... other providers
        \SocialiteProviders\PingID\PingIDExtendSocialite::class,
    ],
];
```

### Usage

You should now be able to use the provider like you would regularly use Socialite (assuming you have the facade installed):

```php
return Socialite::driver('pingid')->redirect();
```

### Returned User fields

- ``id``
- ``name``
- ``email`` 
- ``user``
