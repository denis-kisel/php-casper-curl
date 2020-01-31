<?php

namespace DenisKisel\CasperCURL;

use DenisKisel\CasperCURL\Classes\Builder;

class LCasperCURL
{
    /**
     * @param $url
     * @return Builder
     */
    public static function to($url)
    {
        $builder = new Builder(config('casper_curl.storage_path'));
        return $builder->to($url);
    }
}
