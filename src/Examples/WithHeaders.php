<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

$storageDir = __DIR__ . '/../../../../storage/app/casperCURL/';
$casperCURL = new \DenisKisel\CasperCURL\CasperCURL($storageDir);
print($casperCURL->to('https://amazon.com')
    ->withHeaders([
        'User-Agent' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0',
        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'
    ])
    ->enableDebug()
    ->request()
);
