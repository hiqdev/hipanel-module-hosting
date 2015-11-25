<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\grid;

use hipanel\grid\MainColumn;
use hipanel\widgets\ArraySpoiler;
use Yii;
use yii\helpers\Html;

class IpGridView extends \hipanel\grid\BoxedGridView
{
    static public function defaultColumns()
    {
        return [
            'ip' => [
                'class'                 => MainColumn::className(),
                'filterAttribute'       => 'ip_like',
            ],
            'tags' => [
                'format' => 'html',
                'value' => function ($model) {
                    return ArraySpoiler::widget([
                        'data' => $model->tags
                    ]);
                }
            ],
            'counters' => [
                'format' => 'html',
                'value' => function ($model) {
                    $html = '';
                    foreach ($model->objects_count as $class => $count) {
//                        $html .= Html::a(
//                            $count['ok'] . '&nbsp;' . Html::tag('i', '', ['class' => 'fa fa-check']),
//                            ['@db', (new DbSearch)->formName() => ['server' => $model->server, 'service' => $model->name]],
//                            ['class' => 'btn btn-default btn-xs']
//                        );
                    }
                }
            ]
        ];
    }
}


/*
    foreach ($v['objects_count'] as $class => $stat) {
        $url = "/panel/{$class}s/?ip_like={$v['ip']}"; ?>
        <a href="<?= $url ?>" class="fa fa-check good-count"><?= $stat['ok'] ?></a>
        <? if ($stat['deleted']) { $url .= "&states=deleted"; ?>
            <a href="<?= $url ?>" class="fa fa-trash"><?= $stat['deleted'] ?></a>
        <? } ?>
    <? } ?>
 */