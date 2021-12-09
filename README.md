# Zanjir's PHP Library
Official PHP library of Zanjir
 
## Requirements:

```
PHP >= 5.6
ext-curl
```



## Install


```
composer require zanjir/zanjir-php
```

## Create Payment

```php
<?php
require 'vendor/autoload.php'; // #Or require 'Zanjir/Zanjir.php';
$zanjir = new Zanjir\Zanjir();
    $params["amount"] = 1;
    $params["address"] = "OwnWalletAddress";
    $params["ticker"] = "ltc_litecoin"; 
    $params["callback"] = "https://MyWebSite.com/callback.php?id=xxxxx";
    $create = $zanjir->create($params);
```
