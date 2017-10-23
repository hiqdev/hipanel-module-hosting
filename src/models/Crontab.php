<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

/**
 * @see    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\models;

class Crontab extends \hipanel\base\Model
{
    use \hipanel\base\ModelTrait;

    /** {@inheritdoc} */
    public function rules()
    {
        return [
            [['id', 'account_id', 'server_id', 'client_id'], 'integer'],
            [['crontab', 'account', 'server', 'client'], 'safe'],
            [['state', 'state_label'], 'safe'],
            [['exists'], 'boolean'],

            // Update
            [['id'], 'integer', 'on' => ['update']],
            [['crontab'], 'string', 'on' => ['update']],

            [['id'], 'integer', 'on' => ['request-fetch', 'get-request-state']],
        ];
    }

    /** {@inheritdoc} */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([]);
    }

    /**
     * @return int
     */
    public function getCronRecordCount()
    {
        $count = 0;
        $regex = '/^(\s+)?(#.*)?$/';
        foreach (explode("\n", $this->crontab) as $line) {
            if (!preg_match($regex, trim($line))) {
                ++$count;
            }
        }

        return $count;
    }
}
