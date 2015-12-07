<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */
use hipanel\helpers\FontIcon;
use hipanel\modules\hosting\widgets\ip\IpTag;
use hipanel\widgets\ArraySpoiler;
use yii\helpers\Html;

?>

<div class="row">
    <div class="col-md-12">
        <?php
            echo ArraySpoiler::widget([
                'data' => $ips,
                'formatter' => function ($v) {
                    $html = '';

                    if ($v['id']) {
                        $html .= Html::a($v['ip'], ['@ip/view', 'id' => $v['id']]);
                    } else {
                        $html .= $v['ip'];
                    }

                    if ($v['tags']) {
                        $tags = [' '];
                        foreach ($v['tags'] as $tag) {
                            $tags[] = IpTag::widget(['tag' => $tag]);
                        }
                        $html .= implode(' ', $tags);
                    }

                    if ($v['id']) {
                        $links = [' '];
                        $links[] = Html::a(FontIcon::i('fa-bars') . ' ' . Yii::t('app', 'Details'), ['@ip/view', 'id' => $v['id']], ['class' => 'btn btn-default btn-xs']);
                        $links[] = Html::a(FontIcon::i('fa-pencil') . ' ' . Yii::t('app', 'Update'), ['@ip/update', 'id' => $v['id']], ['class' => 'btn btn-default btn-xs']);
                        $html .= implode(' ', $links);
                    }

                    return $html;
                },
                'visibleCount' => count($ips),
            ]);
        ?>
    </div>
</div>
