<?php

namespace hipanel\modules\hosting\widgets\account;

use hipanel\base\Re;
use hipanel\widgets\Label;

class Type extends Label
{
    public $model = [];

    public function run () {
        $type = $this->model->type;
        if ($type=='user') $class = 'info';
        else $type = 'warning';

        $this->zclass   = $class;
        $this->label    = Re::l($this->model->type_label);
        parent::run();
    }
}
