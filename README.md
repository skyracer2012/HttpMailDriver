# Laravel HTTP mail driver

[![Latest Version on Packagist](https://img.shields.io/packagist/v/skyracer2012/http-mail-driver.svg?style=flat-square)](https://packagist.org/packages/skyracer2012/http-mail-driver)
[![Total Downloads](https://img.shields.io/packagist/dt/skyracer2012/http-mail-driver.svg?style=flat-square)](https://packagist.org/packages/skyracer2012/http-mail-driver)

This package gives your the ability to send emails via HTTP requests. This is useful for sending emails via Mailchannels and their Cloudflare Workers partnerships.  
Note: There is currently no support for attachments due to Mailchannels not supporting them via their transactional message api.
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

## Cloudflare Mailchannel integration

This package was made to work in combination with the Cloudflare Worker Mailchannels partnership.
To use this, deploy a worker with the code of this gist:
[Cloudflare Pages Mailchannel via API] https://gist.github.com/skyracer2012/54e85953162f24ac8f8e0a0fa747f1e3

## Credits

-   [skyracer2012](https://github.com/skyracer2012)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
