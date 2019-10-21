
<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

$text = '{STATUS:200:STATUS}<html><body>sadf;aksdjfa;lsdkfja;sldkfj;sld</body></html>';
print_r(\DenisKisel\CasperCURL\Classes\ResponseFormat::format($text));

