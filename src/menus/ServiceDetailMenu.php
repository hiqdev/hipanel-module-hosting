<?php

namespace hipanel\modules\hosting\menus;

use hiqdev\menumanager\Menu;

class ServiceDetailMenu extends Menu
{
    public $model;

    public function items()
    {
        $actions = ServiceActionsMenu::create(['model' => $this->model])->items();
        $items = array_merge($actions, []);
        unset($items['view']);

        return $items;
    }
}
