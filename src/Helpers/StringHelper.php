<?php


namespace DenisKisel\CasperCURL\Helpers;


class StringHelper
{
    public static function random($length = 6)
    {
        return bin2hex(random_bytes($length));
    }
}
