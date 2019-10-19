<?php

namespace DenisKisel\PhantomCURL;

use DenisKisel\PhantomCURL\Classes\Builder;
use DenisKisel\PhantomCURL\Exceptions\PhantomCURLException;

class CasperCurl
{
    /**
     * @param $url
     * @return Builder
     */
    public static function to($url)
    {
        $builder = new Builder(config('phantom_curl.storage_path'));
        return $builder->to($url);
    }
}
