<?php

namespace hipanel\modules\hosting\widgets\backup;

use hipanel\widgets\Label;
use Yii;

class ObjectLabelWidget extends Label
{
    public $model = [];

    public function init ()
    {
        $object = $this->model->object;
        if ($object === 'db') {
            $class = 'info';
            $label = Yii::t('hipanel/hosting', 'Database');
        } else {
            $class = 'default';
            $label = Yii::t('hipanel/hosting', 'Domain');
        }

        $this->color = $class;
        $this->label = $label;
        parent::init();
    }
}
