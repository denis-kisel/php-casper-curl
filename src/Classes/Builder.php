<?php


namespace DenisKisel\CasperCURL\Classes;

class Builder
{
    /**
     * @var null|CasperJS
     */
    protected $casperJS = null;
    protected $isDebug = false;


    public function __construct(String $storagePath)
    {
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

    public function withHeaders(Array $data)
    {
        $this->casperJS->addHeaders($data);
        return $this;
    }

    public function userAgent(String $agent)
    {
        $this->casperJS->addHeaders(['User-Agent' => $agent]);
        return $this;
    }

    public function withProxy($ip, $port, $schema = 'http', $login = null, $password = null)
    {
        Proxy::validateSchema($schema);
        $options['proxy'] = "{$ip}:{$port}";
        $options['proxy-type'] = $schema;

        if (!empty($login) && !empty($password)) {
            $options['proxy-auth'] = "{$login}:{$password}";
        }

        $this->casperJS->cliOptionRegister->add($options);
        return $this;
    }

    public function withCookie($fileName, $dir = '')
    {
        $filePath = $dir . $fileName;
        if (empty($dir)) {
            $filePath = Config::$storageDir . $fileName;
        }
        $this->casperJS->cliOptionRegister->add(['cookies-file' => $filePath]);
        return $this;
    }

    public function windowSize($width, $height)
    {
        $this->casperJS->windowSize->width = $width;
        $this->casperJS->windowSize->height = $height;
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
