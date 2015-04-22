<?php

namespace hipanel\modules\hosting\widgets\db;

use hipanel\base\Re;
use hipanel\widgets\Label;

class State extends Label
{
    public $model = [];

    public function run () {
        $state = $this->model->state;
        if ($state=='ok') $class = 'info';
        elseif ($state=='blocked') $class = 'danger';
        else $class = 'warning';

        $this->zclass   = $class;
        $this->label    = Re::l($this->model->state_label);
        parent::run();
    }
}
