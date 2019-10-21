<?php


namespace DenisKisel\CasperCURL\Classes;


use DenisKisel\CasperCURL\Helpers\StringHelper;

class CasperJS
{
    protected $url = null;
    protected $httpMethod = null;
    protected $data = null;
    protected $headers = [];

    /** @var StubJSCopyist */
    protected $stubJSCopyist = null;

    public function __construct($url)
    {
        $this->url = $url;
        $this->httpMethod = HttpMethod::DEFAULT;
        $this->stubJSCopyist = new StubJSCopyist(Config::$storageDir);
    }


    public function setHttpMethod($method)
    {
        HttpMethod::validate($method);
        $this->httpMethod = $method;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function setHeaders($headers)
    {
        array_push($this->headers, $headers);
    }

    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function renderData()
    {
        if (is_null($this->data)) {
            return '';
        }

        $jsonData = json_encode($this->data);
        return "data: {$jsonData},";
    }

    public function renderHeaders()
    {

        if (!$this->headers) {
            return '';
        }

        $jsonHeaders = json_encode($this->headers, JSON_UNESCAPED_SLASHES);
        return "headers: {$jsonHeaders}";
    }

    public function generate()
    {
        $this->stubJSCopyist->copy();
        $content = file_get_contents($this->stubJSCopyist->storageFilePath());
        $content = str_replace('{url}', $this->getUrl(), $content);
        $content = str_replace('{httpMethod}', $this->getHttpMethod(), $content);
        $content = str_replace('{data}', $this->renderData(), $content);
        $content = str_replace('{headers}', $this->renderHeaders(), $content);
        $content = str_replace('{options}', '', $content);
        $content = str_replace('{body}', '', $content);

        file_put_contents($this->stubJSCopyist->storageFilePath(), $content);
        return $this->stubJSCopyist->storageFilePath();
    }

    public function exec($isDebug = false)
    {
        $filePath = Config::$storageDir . '/' . StringHelper::random(32);
        exec('casperjs ' . $this->stubJSCopyist->storageFilePath() . ' >> ' . $filePath);
        $result = file_get_contents($filePath);

        if (!$isDebug) {
            unlink($filePath);
            unlink($this->stubJSCopyist->storageFilePath());
        }

        return $result;
    }
}