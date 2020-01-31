<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

$storageDir = __DIR__ . '/../../../../storage/app/casperCURL/';
$casperCURL = new \DenisKisel\CasperCURL\CasperCURL($storageDir);
print($casperCURL->to('http://google.fr')
    ->casperThen('
        this.fill(\'form[action="/search"]\', { q: \'casperjs\' }, true);
        this.wait(2000, function () {
            this.capture(\'step_1.png\');
        });'
    )
    ->enableDebug()
    ->request()
);
