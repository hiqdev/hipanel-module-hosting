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
class AccountValues extends Account
{
    use \hipanel\base\ModelTrait;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['no_suexec', 'allow_scripts', 'dont_enable_ssi'], 'boolean'],
            [
                [
                    'id',
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
}
