<?php


namespace DenisKisel\CasperCURL\Classes;


use DenisKisel\CasperCURL\Exceptions\CasperCURLException;
use DenisKisel\CasperCURL\Helpers\StringHelper;

class JSGenerator
{
    protected $storageDirPath = null;
    protected $storageFileTemplate = 'phantom-curl_{datetime}_{token}.js';
    protected $storageFileName = null;

    /**
     * @var null|Builder
     */
    protected $builder = null;

    public function __construct($storageDirPath, $builder)
    {
        if (!is_dir($storageDirPath)) {
            mkdir($storageDirPath, '0777', true);
        }

        if (!is_dir($storageDirPath)) {
            throw new CasperCURLException("Storage dir is not created! [{$storageDirPath}]");
        }
        $this->storageDirPath = $storageDirPath;
        $this->builder = $builder;
    }

    public function generate()
    {
        copy(__DIR__ . '/../../resources/stabs/casperjs.stub', $this->storageFilePath());

        $content = file_get_contents($this->storageFilePath());
        $content = str_replace('{url}', $this->builder->url, $content);
        $content = str_replace('{options}', '', $content);
        $content = str_replace('{body}', '', $content);

        file_put_contents($this->storageFilePath(), $content);
    }

    public function storageFileName()
    {
        if (is_null($this->storageFileName)) {
            $fileName = str_replace('{datetime}', date('YmdHis'), $this->storageFileTemplate);
            $fileName = str_replace('{token}', StringHelper::random(6), $fileName);
            $this->storageFileName = $fileName;
        }
        return $this->storageFileName;
    }

    public function storageFilePath()
    {
        return $this->storageDirPath . '/' . $this->storageFileName();
    }
}
