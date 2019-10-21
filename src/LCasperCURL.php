<?php

namespace DenisKisel\CasperCURL;

use DenisKisel\CasperCURL\Classes\CasperCURLBuilder;

class LCasperCURL
{
    /**
     * @param $url
     * @return CasperCURLBuilder
     */
    public static function to($url)
    {
        $builder = new CasperCURLBuilder(config('casper_curl.storage_path'));
        return $builder->to($url);
    }
}
