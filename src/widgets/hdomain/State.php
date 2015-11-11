<?php

namespace hipanel\modules\hosting\widgets\hdomain;

use hipanel\widgets\Label;
use Yii;

class State extends Label
{
    public $model = [];

    public function init()
    {
        $state = $this->model->state;
        if ($state == 'ok') {
            $class = 'info';
        } elseif ($state == 'blocked') {
            $class = 'danger';
        } else {
            $class = 'warning';
        }

        $this->color = $class;
        $this->label = Yii::t('app', $this->model->state_label);
        parent::init();
    }
}
