<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\widgets\combo;

use hiqdev\combo\Combo;
use yii\helpers\ArrayHelper;

/**
 * Class Account.
 */
class AccountPathCombo extends Combo
{
    /** {@inheritdoc} */
    public $type = 'hosting/accountPath';

    /** {@inheritdoc} */
    public $name = 'path';

    /** {@inheritdoc} */
    public $url = '/hosting/account/get-directories-list';

    /** {@inheritdoc} */
    public $_return = ['id', 'login', 'server', 'path'];

    /** {@inheritdoc} */
    public function getFilter()
    {
        return ArrayHelper::merge(parent::getFilter(), [
            'account' => 'hosting/account',
            'server' => 'server/server',
        ]);
    }

    /** {@inheritdoc} */
    public function getPluginOptions($options = [])
    {
        return parent::getPluginOptions([
            'clearWhen' => ['hosting/account'],
            'activeWhen' => ['hosting/account'],
        ]);
    }
}
