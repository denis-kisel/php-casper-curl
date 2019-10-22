<?php

require_once '../../../../vendor/autoload.php';
$app = require_once '../../../../bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = \Illuminate\Http\Request::capture()
);

print_r(\DenisKisel\CasperCURL\LCasperCURL::to('google.com')->enableDebug()->request());
