<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

require_once '../../../../vendor/autoload.php';
$app = require_once '../../../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

\DenisKisel\CasperCURL\CasperCURL::to('google.com')->windowSize(2000, 1028)->get();
