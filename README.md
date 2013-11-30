# Config Loader #

Symfony 2 config component extra loaders.

[![Latest Stable Version](https://poser.pugx.org/ebidtech/compress/v/stable.png)](https://packagist.org/packages/ebidtech/compress)
 [![Build Status](https://travis-ci.org/ebidtech/compress.png?branch=v0.2)](https://travis-ci.org/ebidtech/compress) [![Coverage Status](https://coveralls.io/repos/ebidtech/compress/badge.png?branch=master)](https://coveralls.io/r/ebidtech/compress?branch=master)

## Requirements ##

* PHP >= 5.4

## Installation ##

The recommended way to install is through composer.

Just create a `composer.json` file for your project:

``` json
{
    "require": {
        "ebidtech/config-loader": "@stable"
    }
}
```

**Tip:** browse [`ebidtech/config-loader`](https://packagist.org/packages/ebidtech/config-loader) page to choose a stable version to use, avoid the `@stable` meta constraint.

And run these two commands to install it:

```bash
$ curl -sS https://getcomposer.org/installer | php
$ composer install
```

Now you can add the autoloader, and you will have access to the library:

```php
<?php

require 'vendor/autoload.php';
```

## Usage ##


## Contributing ##

See CONTRIBUTING file.

## Credits ##

* Ebidtech developer team, config loader Lead developer [Eduardo Oliveira](https://github.com/entering) (eduardo.oliveira@ebidtech.com).
* [All contributors](https://github.com/ebidtech/config-loader/contributors)

## License ##

Config loader library is released under the MIT License. See the bundled LICENSE file for details.

