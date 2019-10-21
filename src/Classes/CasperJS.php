<?php


namespace DenisKisel\CasperCURL\Classes;


use DenisKisel\CasperCURL\Helpers\StringHelper;

class CasperJS
{
    protected $url = null;
    protected $httpMethod = null;
    protected $data = null;
    protected $headers = [];
    protected $options = [];
    protected $body = '';

    /** @var StubJSCopyist */
    protected $stubJSCopyist = null;

    /** @var Proxy */
    protected $proxy = null;

    /** @var CliPhantomOptions */
    public $cliPhantomOptions = null;

    /** @var WindowSize */
    public $windowSize = null;

    public function __construct($url)
    {
        $this->url = $url;
        $this->httpMethod = HttpMethod::DEFAULT;
        $this->stubJSCopyist = new StubJSCopyist(Config::$storageDir);
        $this->cliPhantomOptions = new CliPhantomOptions();
        $this->windowSize = new WindowSize();
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

    public function addHeaders($headers)
    {
        array_merge($this->headers, $headers);
    }

    public function addOptions($options)
    {
        array_merge($this->options, $options);
    }

    public function addBody($script)
    {
        $this->body .= $script . PHP_EOL;
    }

    public function then($script)
    {
        $output = <<<EOF
    casper.then(function () {
        {$script}
    });
EOF;
        $this->addBody($output);
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

    public function renderOptions()
    {
        return '';
    }

    public function renderBody()
    {
        return $this->body;
    }

    public function generate()
    {
        $this->stubJSCopyist->copy();
        $content = file_get_contents($this->stubJSCopyist->storageFilePath());
        $content = str_replace('{url}', $this->getUrl(), $content);
        $content = str_replace('{httpMethod}', $this->getHttpMethod(), $content);
        $content = str_replace('{data}', $this->renderData(), $content);
        $content = str_replace('{headers}', $this->renderHeaders(), $content);
        $content = str_replace('{options}', $this->renderOptions(), $content);
        $content = str_replace('{windowSize}', $this->windowSize->render(), $content);
        $content = str_replace('{body}', $this->renderBody(), $content);

        file_put_contents($this->stubJSCopyist->storageFilePath(), $content);
        return $this->stubJSCopyist->storageFilePath();
    }

    public function exec($isDebug = false)
    {
        $filePath = Config::$storageDir . '/' . StringHelper::random(32);
        exec("casperjs {$this->cliPhantomOptions->render()} {$this->stubJSCopyist->storageFilePath()} >> {$filePath}");
        $result = file_get_contents($filePath);

        if (!$isDebug) {
            unlink($filePath);
            unlink($this->stubJSCopyist->storageFilePath());
        }

        return $result;
    }
}
