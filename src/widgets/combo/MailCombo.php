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

class MailCombo extends Combo
{
    /** {@inheritdoc} */
    public $type = 'hosting/mail';

    /** {@inheritdoc} */
    public $name = 'mail';

    /** {@inheritdoc} */
    public $url = '/hosting/mail/search';

    /** {@inheritdoc} */
    public $_return = ['id', 'account', 'server', 'client'];

    /** {@inheritdoc} */
    public $_rename = ['text' => 'mail'];

    public $activeWhen = ['server/server'];

    /** {@inheritdoc} */
    public function getFilter()
    {
        return ArrayHelper::merge(parent::getFilter(), [
            'server' => 'server/server',
            'account' => 'hosting/account',
            'state' => ['format' => 'ok'],
        ]);
    }

    /** {@inheritdoc} */
    public function getPluginOptions($options = [])
    {
        return parent::getPluginOptions(ArrayHelper::merge([
            'activeWhen' => $this->activeWhen,
        ], $options));
    }
}
