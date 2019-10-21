<?php


namespace DenisKisel\CasperCURL\Classes;

class CasperCURLBuilder
{
    /**
     * @var null|Proxy
     */
    public $proxy = null;

    /**
     * @var null|CasperJS
     */
    protected $casperJS = null;

    /**
     * @var null|WindowSize
     */
    public $windowSize = null;

    protected $isDebug = false;


    public function __construct(String $storagePath)
    {
        $this->windowSize = new WindowSize();
        Config::$storageDir = $storagePath;
    }

    public function to(String $url)
    {
        $this->casperJS = new CasperJS($url);
        return $this;
    }

    public function method(String $method)
    {
        $this->casperJS->setHttpMethod($method);
        return $this;
    }

    public function withData(Array $data)
    {
        $this->casperJS->setData($data);
        return $this;
    }

    public function withProxy($ip, $port, $schema = 'http://', $login = null, $password = null)
    {
        $this->proxy = new Proxy($ip, $port, $schema, $login, $password);
        return $this;
    }

    public function windowSize($width, $height)
    {
        $this->windowSize->width = $width;
        $this->windowSize->height = $height;
        return $this;
    }

    public function request()
    {
        $this->casperJS->generate();
        return $this->casperJS->exec($this->isDebug);
    }

    public function enableDebug()
    {
        $this->isDebug = true;
        return $this;
    }
}
