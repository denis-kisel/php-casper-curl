<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

$storageDir = __DIR__ . '/../../../../storage/app/casperCURL/';
$options = new \DenisKisel\CasperCURL\Classes\CliOptionRegister();
$options->add(['debug' => 'value']);
$options->render();
