<?php


namespace DenisKisel\PhantomCURL\Classes;


use DenisKisel\PhantomCURL\Exceptions\PhantomCURLException;
use Illuminate\Support\Facades\File;

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
            throw new PhantomCURLException("Storage dir is not created! [{$storageDirPath}]");
        }
        $this->storageDirPath = $storageDirPath;
        $this->builder = $builder;
    }

    public function loadBuilder(Builder $builder)
    {
        $this->builder = $builder;
    }

    public function generate()
    {
        $content = view('phantom_curl::url-js', [
            'url' => $this->builder->url,
            'proxy' => $this->builder->proxy,
            'windowSize' => $this->builder->windowSize
        ]);

        File::put($this->storageFilePath(), $content);
    }

    public function storageFileName()
    {
        if (is_null($this->storageFileName)) {
            $fileName = str_replace('{datetime}', date('YmdHis'), $this->storageFileTemplate);
            $fileName = str_replace('{token}', bin2hex(random_bytes(6)), $fileName);
            $this->storageFileName = $fileName;
        }
        return $this->storageFileName;
    }

    public function storageFilePath()
    {
        return $this->storageDirPath . '/' . $this->storageFileName();
    }
}
