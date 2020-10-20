<?php

namespace hipanel\modules\hosting\assets;

use yii\web\AssetBundle;

class TreeTable extends AssetBundle
{
    public $sourcePath = '@bower/jquery-treetable';

    public $css = [
        'css/jquery.treetable.css',
//        'css/jquery.treetable.theme.default.css',
    ];

    public $js = [
        'jquery.treetable.js',
    ];
}
