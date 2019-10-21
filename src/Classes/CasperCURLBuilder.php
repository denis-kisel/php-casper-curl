<?php


namespace DenisKisel\CasperCURL\Classes;

use DenisKisel\CasperCURL\Helpers\StringHelper;

class CasperCURLBuilder
{
    protected $storagePath = null;

    /**
     * @var null|Proxy
     */
    public $proxy = null;

    /**
     * @var null|JSGenerator
     */
    protected $JSGenerator = null;

    /**
     * @var null|CasperJSBuilder
     */
    protected $casperJSBuilder = null;

    /**
     * @var null|WindowSize
     */
    public $windowSize = null;

    protected $enableDebug = false;


    public function __construct($storagePath)
    {
        $this->JSGenerator = new JSGenerator($storagePath);
        $this->windowSize = new WindowSize();
        $this->storagePath = $storagePath;
    }

    public function to($url)
    {
        $this->casperJSBuilder = new CasperJSBuilder($url);
        return $this;
    }

    public function method($method)
    {
        $this->casperJSBuilder->setHttpMethod($method);
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
        $this->JSGenerator->generate($this->casperJSBuilder);
        $filePath = $this->storagePath . '/' . StringHelper::random(32);
        exec('casperjs ' . $this->JSGenerator->storageFilePath() . ' >> ' . $filePath);
        $result = file_get_contents($filePath);

        if (!$this->enableDebug) {
            unlink($filePath);
            unlink($this->JSGenerator->storageFilePath());
        }

        return $result;
    }

    public function enableDebug()
    {
        $this->enableDebug = true;
        return $this;
    }

//    /**
//     * @ignore
//     */
//    public function withData(Array $data)
//    {
//        return $this;
//    }
//
//    /**
//     * @ignore
//     */
//    public function withHeader(Array $header)
//    {
//        return $this;
//    }
//
//    /**
//     * @ignore
//     */
//    public function withHeaders(Array $headers)
//    {
//        return $this;
//    }
}
