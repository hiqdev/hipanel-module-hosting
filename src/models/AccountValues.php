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

use Yii;

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
            [['no_suexec', 'allow_scripts', 'dont_enable_ssi', 'block_send'], 'boolean'],
            [
                [
                    'id', 'per_hour_limit', 'block_send',
                    'no_suexec', 'allow_scripts', 'dont_enable_ssi',
                    'port', 'global_apache_conf', 'global_nginx_conf',
                    'apache_conf', 'nginx_conf', 'nginx_listen',
                    'domain_prefix', 'docroot_postfix', 'cgibin_postfix',
                ],
                'safe',
                'on' => ['default', 'set-ghost-options', 'set-mail-settings'],
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'no_suexec'             => Yii::t('hipanel:hosting:account', 'No Suexec'),
            'allow_scripts'         => Yii::t('hipanel:hosting:account', 'Allow scripts'),
            'dont_enable_ssi'       => Yii::t('hipanel:hosting:account', 'Dont enable Ssi'),
            'port'                  => Yii::t('hipanel:hosting:account', 'Port'),
            'global_apache_conf'    => Yii::t('hipanel:hosting:account', 'Global Apache configuration'),
            'global_nginx_conf'     => Yii::t('hipanel:hosting:account', 'Global Nginx configuration'),
            'apache_conf'           => Yii::t('hipanel:hosting:account', 'Apache configuration'),
            'nginx_conf'            => Yii::t('hipanel:hosting:account', 'Nginx configuration'),
            'domain_prefix'         => Yii::t('hipanel:hosting:account', 'Domain prefix'),
            'nginx_listen'          => Yii::t('hipanel:hosting:account', 'Nginx listen'),
            'docroot_postfix'       => Yii::t('hipanel:hosting:account', 'Document root postfix'),
            'cgibin_postfix'        => Yii::t('hipanel:hosting:account', 'Cgibin postfix'),
            'block_send'            => Yii::t('hipanel:hosting', 'Block outgoing post'),
            'per_hour_limit'        => Yii::t('hipanel:hosting', 'Maximum letters per hour'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function primaryKey()
    {
        return ['id'];
    }
}
