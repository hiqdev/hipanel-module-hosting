<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\models;

/**
 * Class AccountValues
 * @package hipanel\modules\hosting\models
 */
class AccountValues extends \hipanel\base\Model
{
    use \hipanel\base\ModelTrait;

    const SCENARIO_DEFAULT = 'dumb';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'account';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['id'], 'integer'],
            [['no_suexec', 'allow_scripts', 'dont_enable_ssi'], 'boolean'],
            [
                [
                    'no_suexec', 'allow_scripts', 'dont_enable_ssi',
                    'port', 'global_apache_conf', 'global_nginx_conf',
                    'apache_conf', 'nginx_conf', 'nginx_listen',
                    'domain_prefix', 'docroot_postfix', 'cgibin_postfix',
                ],
                'safe',
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function primaryKey()
    {
        return ['id'];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarioActions()
    {
        return [
            'default' => 'set-ghost-options',
        ];
    }
}
