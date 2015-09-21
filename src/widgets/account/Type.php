<?php

namespace hipanel\modules\hosting\widgets\account;

use hipanel\widgets\Label;
use Yii;

class Type extends Label
{
    public $model = [];

    public function run () {
        $type = $this->model->type;
        if ($type=='user') $class = 'info';
        else $type = 'warning';

        $this->zclass   = $class;
        $this->label    = Yii::t('app', $this->model->type_label);
        parent::run();
    }
}
