<?php


namespace DenisKisel\PhantomCURL\Classes;


use DenisKisel\PhantomCURL\Exceptions\PhantomCURLException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Builder
{
    public $url = null;
    public $httpMethod = 'GET';

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

    protected function send()
    {
        $this->JSGenerator->generate();

        $filePath = config('phantom_curl.storage_path') . '/' . Str::random(32);
        exec(config('phantom_curl.phantomjs_bin') . ' ' . $this->JSGenerator->storageFilePath() . ' >> ' . $filePath);
        $result = File::get($filePath);

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

    //HTTP METHODS
    public function get()
    {
        return $this->send();
    }

//    public function post()
//    {
//        return $this->send();
//    }
//
//    public function patch()
//    {
//        return $this->send();
//    }
//
//    public function put()
//    {
//        return $this->send();
//    }
//
//    public function delete()
//    {
//        return $this->send();
//    }
}
