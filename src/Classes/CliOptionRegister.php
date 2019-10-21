<?php


namespace DenisKisel\CasperCURL\Classes;


use DenisKisel\CasperCURL\Exceptions\CasperCURLException;

class CliOptionRegister
{
    const OPTION_PREFIX = '--';
    const AVAILABLE = [
        'debug', 'config', 'cookies-file',
        'disk-cache', 'disk-cache-path',
        'ignore-ssl-errors', 'load-images',
        'local-storage-path', 'local-storage-quota',
        'local-url-access', 'local-to-remote-url-access',
        'max-disk-cache-size', 'offline-storage-path',
        'offline-storage-quota', 'output-encoding',
        'remote-debugger-port', 'remote-debugger-autorun',
        'proxy', 'proxy-type', 'proxy-auth',
        'script-encoding', 'script-language', 'ssl-protocol',
        'ssl-certificates-path', 'ssl-client-certificate-file',
        'ssl-client-key-file', 'ssl-client-key-passphrase',
        'ssl-ciphers', 'web-security', 'webdriver', 'webdriver-selenium-grid-hub',
        'webdriver-logfile', 'webdriver-loglevel'
    ];
    protected $options = [];

    public function add(Array $options)
    {
        foreach ($options as $key => $value) {
            if (!in_array($key, self::AVAILABLE)) {
                $textFinder = new \SimilarText\Finder($key, self::AVAILABLE);
                throw new CasperCURLException("Option [{$key}] not found. Did you mean [{$textFinder->first()}]?");
            }
        }

        $this->options = array_merge($this->options, $options);
    }

    public function render()
    {
        if (!$this->options) {
            return '';
        }

        $output = '';
        foreach ($this->options as $key => $value) {
            $output .= self::OPTION_PREFIX . "{$key}={$value} ";
        }
        return $output;
    }
}
