<?php

namespace DenisKisel\CasperCURL;

use DenisKisel\CasperCURL\Classes\CasperCURLBuilder;

class CasperCURL
{
    protected $storagePath = null;

    public function __construct($storagePath)
    {
        $this->storagePath = $storagePath;
    }

    /**
     * @param $url
     * @return CasperCURLBuilder
     */
    public function to($url)
    {
        $builder = new CasperCURLBuilder($this->storagePath);
        return $builder->to($url);
    }
}
