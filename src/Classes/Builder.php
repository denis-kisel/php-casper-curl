<?php


namespace DenisKisel\CasperCURL\Classes;

use DenisKisel\CasperCURL\Helpers\StringHelper;

class Builder
{
    public $url = null;
    public $httpMethod = 'GET';
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
     * @var null|WindowSize
     */
    public $windowSize = null;


    public function __construct($storagePath)
    {
        $this->JSGenerator = new JSGenerator($storagePath, $this);
        $this->windowSize = new WindowSize();
        $this->storagePath = $storagePath;
    }

    public function to($url)
    {
        $this->url = $url;
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
        $this->JSGenerator->generate();

        $filePath = $this->storagePath . '/' . StringHelper::random(32);
        exec('casperjs ' . $this->JSGenerator->storageFilePath() . ' >> ' . $filePath);
        $result = file_get_contents($filePath);

        unlink($filePath);
        unlink($this->JSGenerator->storageFilePath());

        return $result;
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
