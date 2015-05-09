<?php

namespace Jeff\simditor;

use yii\web\AssetBundle;

class SimditorAsset extends AssetBundle
{
    public $sourcePath = "@bower";
    public $css = [
        'simditor/styles/simditor.css',
    ];
    public $js = [
        'simple-module/lib/module.js',
        'simple-hotkeys/lib/hotkeys.js',
        'simple-uploader/lib/uploader.js',
        'simditor/lib/simditor.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
