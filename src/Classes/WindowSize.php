<?php


namespace DenisKisel\CasperCURL\Classes;


class WindowSize
{
    public $width = null;
    public $height = null;

    public function __construct($width = 1920, $height = 1080)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function render()
    {
        return "casper.options.viewportSize = {width: {$this->width}, height: {$this->height}};";
    }
}
