<?php

/*
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

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
