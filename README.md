# exmo-api

Exmo (Bitcoin Exchange) API PHP client

## Getting Started
Install composer in your project: ```curl -s https://getcomposer.org/installer | php```

Create a composer.json file in your project root: ```{
    "require": {
        "exmo/api": "1.*"
    }
}```

Install via composer:```php composer.phar install```

```php
use Exmo\Api\Request;
...
$request = new Request('your_key', 'your_secret');
$result = $request->query('user_info');
...
```

## Documentation
[Exmo.com Trade API](https://wallet.exmo.com/en/api_doc#/authenticated_api)

## Release History
_1.0.0_

## License
Copyright (c) 2016 exmo-dev  
Licensed under the MIT license.
