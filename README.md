Doctrine Cache adapter for the Rollerworks URIEncoder Component
===============================================================

This package provides a Doctrine Cache adapter for the [Rollerworks URIEncoder Component][1].

## Installation

To install this package, add `rollerworks/uri-encoder-doctrine-cache` to your composer.json

```bash
$ php composer.phar require rollerworks/uri-encoder-doctrine-cache
```

Then, you can install the new dependencies by running Composer's `update`
command from the directory where your `composer.json` file is located:

```bash
$ php composer update rollerworks/uri-encoder-doctrine-cache
```

Now, Composer will automatically download all required files, and install them
for you.

## Usage

```php

require 'vendor/autoload.php';

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\ChainCache;
use Rollerworks\Component\UriEncoder\Encoder as UriEncoder;
use Rollerworks\Component\UriEncoder\Cache\DoctrineCache;

// The Doctrine cache library.
$doctrineCache = new ChainCache(
    [
        // Include the ArrayCache as the ChainCache will populate all the previous cache layers.
        // So if the `FilesystemCache` has a match it will populate the faster ArrayCache.
        new ArrayCache(),

        // Add an simple cache for fast access, eg. the rollerworks session-cache library.
        // https://github.com/rollerworks/Cache
    ]
);

// Rollerworks\Component\UriEncoder\CacheAdapterInterface
$cacheDriver = new DoctrineCache($doctrineCache);

$stringEncode = 'This string is not safe, for direct usage & must encoded';

$base64Encoder = new UriEncoder\Base64UriEncoder();
$cacheEncoder = new UriEncoder\CacheEncoderDecorator($cacheDriver, $base64Encoder);

$safeValue = $cacheEncoder->encodeUri($stringEncode);

// $safeString now contains a base64 encoded string
// and the result is cached using the cacheDriver.

$originalValue = $cacheEncoder->decodeUri($safeValue);
```

[1]: https://github.com/rollerworks/rollerworks-uri-encoder
