<?php

use hipanel\helpers\FontIcon;
use hipanel\modules\hosting\widgets\ip\IpTag;
use hipanel\widgets\ArraySpoiler;
use yii\helpers\Html;

/**
 * @var array $ips
 */
?>

<div class="row">
    <div class="col-md-12">
        <?php
            echo ArraySpoiler::widget([
                'data' => $ips,
                'formatter' => function ($v) {
                    $ip = Html::encode($v['ip']);
                    $html = $v['id'] ? Html::a($ip, ['@ip/view', 'id' => $v['id']]) : $ip;

                    if ($v['tags']) {
                        $tags = [' '];
                        foreach ($v['tags'] as $tag) {
                            $tags[] = IpTag::widget(['tag' => $tag]);
                        }
                        $html .= implode(' ', $tags);
                    }

                    if ($v['id']) {
                        $links = [' '];
                        $links[] = Html::a(FontIcon::i('fa-bars') . ' ' . Yii::t('hipanel', 'Details'), ['@ip/view', 'id' => $v['id']], ['class' => 'btn btn-default btn-xs']);
                        $links[] = Html::a(FontIcon::i('fa-pencil') . ' ' . Yii::t('hipanel', 'Update'), ['@ip/update', 'id' => $v['id']], ['class' => 'btn btn-default btn-xs']);
                        $html .= implode(' ', $links);
                    }

                    return $html;
                },
                'visibleCount' => count($ips),
            ]);
        ?>
    </div>
</div>
