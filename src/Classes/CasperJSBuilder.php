<?php


namespace DenisKisel\CasperCURL\Classes;


class CasperJSBuilder
{
    protected $url = null;
    protected $httpMethod = null;

    public function __construct($url)
    {
        $this->url = $url;
        $this->httpMethod = HttpMethod::DEFAULT;
    }


    public function setHttpMethod($method)
    {
        HttpMethod::validate($method);
        $this->httpMethod = $method;
    }

    public function getHttpMethod()
    {
        return $this->httpMethod;
    }


    public function getUrl()
    {
        return $this->url;
    }
}
