<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

$storageDir = __DIR__ . '/../../../../storage/app/casperCURL/';
$casperCURL = new \DenisKisel\CasperCURL\CasperCURL($storageDir);
print($casperCURL->to('https://amazon.com')
    ->method('POST')
    ->withData([
        'param1' => 'value1',
        'param2' => 'value2',
    ])
    ->enableDebug()
    ->request()
);
