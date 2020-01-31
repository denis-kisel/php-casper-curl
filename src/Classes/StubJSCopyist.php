<?php


namespace DenisKisel\CasperCURL\Classes;


use DenisKisel\CasperCURL\Exceptions\CasperCURLException;
use DenisKisel\CasperCURL\Helpers\StringHelper;

class StubJSCopyist
{
    protected $storageDirPath = null;
    protected $storageFileTemplate = 'phantom-curl_{datetime}_{token}.js';
    protected $storageFileName = null;


    public function __construct($storageDirPath)
    {
        if (!is_dir($storageDirPath)) {
            mkdir($storageDirPath, '0777', true);
        }

        if (!is_dir($storageDirPath)) {
            throw new CasperCURLException("Storage dir is not created! [{$storageDirPath}]");
        }
        $this->storageDirPath = $storageDirPath;
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

    public function copy()
    {
        copy(__DIR__ . '/../../resources/stabs/casperjs.stub', $this->storageFilePath());
        return $this->storageFilePath();
    }
}
