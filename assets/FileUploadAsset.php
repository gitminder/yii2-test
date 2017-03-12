<?php
/**
 * Created by PhpStorm.
 * User: SERG
 * Date: 12.03.2017
 * Time: 18:43
 */

namespace app\assets;


use yii\web\AssetBundle;

class FileUploadAsset extends AssetBundle
{
    public $basePath = '@webroot'; //алиас каталога с файлами, который соответствует @web
    public $baseUrl = '@web';//Алиас пути к файлам
    public $css = [
        'css/fileupload.css',
    ];
    public $js = [
        'js/vendor/jquery.ui.widget.js',
        'js/jquery.iframe-transport.js',
        'js/jquery.fileupload.js',
        'js/fileupload.js',
    ];

}