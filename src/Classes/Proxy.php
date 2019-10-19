<?php


namespace DenisKisel\PhantomCURL\Classes;


class Proxy
{
    public $ip = null;
    public $port = null;
    public $schema = 'http';
    public $login = null;
    public $password = null;

    public function __construct($ip, $port, $schema = 'http', $login = null, $password = null)
    {
        $this->ip = $ip;
        $this->port = $port;
        $this->schema = $schema;
        $this->login = $login;
        $this->password = $password;
    }
}
