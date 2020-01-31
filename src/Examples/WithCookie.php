<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

$storageDir = __DIR__ . '/../../../../storage/app/casperCURL/';
$casperCURL = new \DenisKisel\CasperCURL\CasperCURL($storageDir);
print($casperCURL->to('https://amazon.com')
    ->withCookie('test.txt')
    ->enableDebug()
    ->request()
);
