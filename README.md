# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/skyracer2012/http-mail-driver.svg?style=flat-square)](https://packagist.org/packages/skyracer2012/http-mail-driver)
[![Total Downloads](https://img.shields.io/packagist/dt/skyracer2012/http-mail-driver.svg?style=flat-square)](https://packagist.org/packages/skyracer2012/http-mail-driver)

This package gives your the ability to send emails via HTTP requests. This is useful for sending emails via Mailchannels and their Cloudflare Workers partnerships.

## Installation

You can install the package via composer:

```bash
composer require skyracer2012/http-mail-driver
```

After that, please set the value `HTTP_MAIL_URL` in your `.env` file to the URL of your HTTP Mail endpoint.
You should also define the `HTTP_MAIL_KEY` in your `.env` file which will be used to authenticate your requests in the Authorization header.

```dotenv
HTTP_MAIL_URL=https://example.com
HTTP_MAIL_KEY=secret
```

Next should should add the `http` entry to your `config/mail.php` file under the `mailers` array.

```php
'mailers' => [
    // other mailers
    'http' => [
        'transport' => 'http',
        'url' => env('HTTP_MAIL_URL'),
        'key' => env('HTTP_MAIL_KEY'),
    ],
],
```

Now you can set the default mailer to `http` in your `.env` file.

```dotenv
MAIL_MAILER=http
```


## Credits

-   [skyracer2012](https://github.com/skyracer2012)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
