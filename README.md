# Config Loader #

Symfony 2 config component extra loaders.

[![Latest Stable Version](https://poser.pugx.org/ebidtech/config-loader/v/stable.png)](https://packagist.org/packages/ebidtech/config-loader) [![Build Status](https://travis-ci.org/ebidtech/config-loader.png?branch=master)](https://travis-ci.org/ebidtech/config-loader) [![Coverage Status](https://coveralls.io/repos/ebidtech/config-loader/badge.png)](https://coveralls.io/r/ebidtech/config-loader) [![Dependency Status](https://www.versioneye.com/user/projects/5299e146632bac33e8000014/badge.png)](https://www.versioneye.com/user/projects/5299e146632bac33e8000014)
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

You should read about [Symfony 2 config component](http://symfony.com/doc/2.3/components/config/introduction.html).

Example of simple use:
```php
use EBT\ConfigLoader\YamlFileLoader;

$yamlLoader = new YamlFileLoader();
// this will read the file and return it as array
$content = $yamlLoader->load(__DIR__ . '/test.yml');
```

## Contributing ##

See CONTRIBUTING file.

## Credits ##

* Ebidtech developer team, config loader Lead developer [Eduardo Oliveira](https://github.com/entering) (eduardo.oliveira@ebidtech.com).
* [All contributors](https://github.com/ebidtech/config-loader/contributors)

## License ##

Config loader library is released under the MIT License. See the bundled LICENSE file for details.

