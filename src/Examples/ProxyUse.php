<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

require_once '../../../../vendor/autoload.php';
$app = require_once '../../../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

\DenisKisel\PhantomCURL\CasperCurl::to('google.com')->withProxy('123.1245.532.12', '80', 'http', 'test', 'test')->get();
