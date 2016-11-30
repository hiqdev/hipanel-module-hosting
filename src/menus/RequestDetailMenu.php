<?php

namespace hipanel\modules\hosting\menus;

use hiqdev\menumanager\Menu;

class ReauestDetailMenu extends Menu
{
    public $model;

    public function items()
    {
        $actions = RequestActionsMenu::create(['model' => $this->model])->items();
        $items = array_merge($actions, []);
        unlink($items['view']);

        return $items;
    }
}
