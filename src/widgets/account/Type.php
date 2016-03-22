<?php

namespace hipanel\modules\hosting\widgets\account;

use hipanel\widgets\Label;
use Yii;

class Type extends Label
{
    public $model = [];

    public function init () {
        $type = $this->model->type;
        if ($type=='user') $class = 'info';
        else $class = 'warning';

        $this->color = $class;
        $this->label = Yii::t('hipanel/hosting', $this->model->type_label);
        parent::init();
    }
}
