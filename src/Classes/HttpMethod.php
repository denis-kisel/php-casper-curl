<?php


namespace DenisKisel\CasperCURL\Classes;


use DenisKisel\CasperCURL\Exceptions\CasperCURLException;

class HttpMethod
{
    const METHODS = [
        'GET', 'POST', 'PUT', 'DELETE'
    ];

    const DEFAULT = 'GET';

    public static function validate($method)
    {
        if (!in_array($method, self::METHODS)) {
            throw new CasperCURLException("Http Method [{$method}] is not available! ");
        }

        return true;
    }
}
