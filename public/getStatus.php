<?php

/** @var Maxnnn1900\ProxySMSApi\ProxySMSApi $proxySmsApi */
$proxySmsApi = require __DIR__ . '/../bootstrap.php';

$response = $proxySmsApi->getStatus('10869836');

header('Content-Type: application/json');
echo json_encode($response, JSON_PRETTY_PRINT);
