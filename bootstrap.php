<?php

require_once __DIR__ . '/vendor/autoload.php';

use Maxnnn1900\ProxySMSApi\ProxySMSApi;
use GuzzleHttp\Client as GuzzleClient;
use Http\Adapter\Guzzle7\Client as GuzzlePsr18Client;
use Nyholm\Psr7\Factory\Psr17Factory;

$config = require __DIR__ . '/config/config.php';

$httpClient = new GuzzlePsr18Client(new GuzzleClient());
$requestFactory = new Psr17Factory();

$proxySMSApi = new ProxySMSApi(
    $config['api_url'],
    $config['api_token'],
    $httpClient,
    $requestFactory
);

return $proxySMSApi;
