<?php

namespace hipanel\modules\hosting\assets;

use yii\web\AssetBundle;

class CrontabFetchAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@hipanel/modules/hosting/assets/CrontabFetchAssets';

    /**
     * @var array
     */
    public $js = [
        'js/CrontabFetchPlugin.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
