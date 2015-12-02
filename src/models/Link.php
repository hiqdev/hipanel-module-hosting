<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\models;

use Yii;
use yii\web\JsExpression;

class Link extends \hipanel\base\Model
{
    use \hipanel\base\ModelTrait;

    public static function index() {
        return 'ips';
    }

    public static function type()
    {
        return 'ip';
    }

    public function rules () {
        return [
            [['id', 'ip_id', 'device_id', 'service_id', 'soft_id'], 'integer'],
            [['ip', 'service', 'soft', 'soft_type', 'soft_type_label', 'device_ptype'], 'safe'],
            [['device'], 'safe', 'on' => ['create', 'update']],
            [['service_id', 'ip_id', 'id'], 'integer', 'on' => ['create', 'update']],
            [['id'], 'required', 'on' => ['update', 'delete']],
            [['service_id'], 'required', 'when' => function ($model) {
                return !empty($this->server);
            }, 'whenClient' => new JsExpression("function (attribute, value) {
                return $(attribute).parent('.item').find('[data-attribute=server]').val();
            }"), 'on' => ['create', 'update']]
        ];
    }
}