<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting;

class Plugin extends \hiqdev\pluginmanager\Plugin
{
    protected $_items = [
        'menus' => [
            [
                'class' => 'hipanel\modules\hosting\SidebarMenu',
            ],
        ],
        'modules' => [
            'hosting' => [
                'class' => 'hipanel\modules\hosting\Module',
            ],
        ],
    ];

}
