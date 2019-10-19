<?php


namespace DenisKisel\PhantomCURL\Classes;


class WindowSize
{
    public $width = null;
    public $height = null;

    public function __construct($width = 1024, $height = 768)
    {
        $this->width = $width;
        $this->height = $height;
    }
}
