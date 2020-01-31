<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

$storageDir = __DIR__ . '/../../../../storage/app/casperCURL/';
$casperCURL = new \DenisKisel\CasperCURL\CasperCURL($storageDir);
print($casperCURL->to('https://amazon.com')
    ->withProxy('123.1245.532.12', '80', 'http', 'test', 'test')
    ->enableDebug()
    ->request()
);
