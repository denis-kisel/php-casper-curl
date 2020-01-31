<?php


namespace DenisKisel\CasperCURL\Classes;


use DenisKisel\CasperCURL\Exceptions\CasperCURLException;

class Proxy
{
    const HTTP_SCHEMA = 'http';
    const SOCKS_SCHEMA = 'socks5';
    const NONE_SCHEMA = 'none';

    public static function validateSchema($schema)
    {
        if (!in_array($schema, self::schemaTypes())) {
            throw new CasperCURLException("This schema [$schema] is not available!");
        }
    }

    public static function schemaTypes()
    {
        return [
            self::HTTP_SCHEMA,
            self::SOCKS_SCHEMA,
            self::NONE_SCHEMA
        ];
    }
}
