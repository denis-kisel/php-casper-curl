<?php

namespace DenisKisel\CasperCURL;

use DenisKisel\CasperCURL\Classes\Builder;

class CasperCURL
{
    protected $storagePath = null;

    public function __construct($storagePath)
    {
        $this->storagePath = $storagePath;
    }

    /**
     * @param $url
     * @return Builder
     */
    public function to($url)
    {
        $builder = new Builder($this->storagePath);
        return $builder->to($url);
    }
}
