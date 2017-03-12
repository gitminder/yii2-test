<?php

namespace app\packages\upload;
/**
 * Created by PhpStorm.
 * User: SERG
 * Date: 11.03.2017
 * Time: 19:35
 */
class FileInfo
{
    public $name;
    public $errorText;

    /**
     * FileInfo constructor.
     * @param $name
     */
    public function __construct($name, $errorText = "")
    {
        $this->name = $name;
        $this->errorText = $errorText;
    }

}