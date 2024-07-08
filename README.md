# gpwebconfig
 
Laravel 11 or higher required

This package is so SecondLife residents can edit their inworld products through a webconfig. 
Designed to be used for GridPlay Productions. Frontend coding required!
```json
    "repositories": [{
            "type": "vcs", 
            "url": "https://github.com/gridplay/gpwebconfig"
        }
    ],
    "require": {
        "gridplay/gpwebconfig": "dev-main",
    }
```

```sh
php artisan vendor:publish --provider="WebConfig\WCServiceProvider"
```

```php
$array = ['resident' => $sluuid];
$length = 24;
$code = WebConfig::genCode($array, $length);
// $code generates a code of $length that lasts for default 10 minutes which can be configured in the gpwebconfig.php

// To validate code and get $array
if ($valid = WebConfig::ValidateCode($code)) {
	$sluuid = $valid['resident'];
}

if (WebConfig::getExpiration($code) < time()) {
	WebConfig::deleteCode($code);
}
```
