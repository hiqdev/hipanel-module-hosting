<?php

namespace hipanel\modules\hosting\widgets\ip;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\View;
use hipanel\modules\hosting\models\Ip;

class ApplyPtrChange extends Widget
{
    /** @var Ip */
    public $model;

    /** @var string */
    public $attribute = 'ptr';

    public function init(): void
    {
        $this->view->registerJs(
            <<<'JS'
                $('.apply-ptr-change').popover({html: true});
                $(document).on('click', function (e) {
                    $('[data-toggle="popover"], [data-original-title]').each(function () {
                        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                            (($(this).popover('hide').data('bs.popover')||{}).inState||{}).click = false
                        }
                    });
                });
JS
            ,
            View::POS_READY
        );
        $this->view->registerCss(
            <<<'CSS'
            .apply-ptr-change {
                border-bottom: 1px #72afd2 dashed;
                font-style: italic;
            }
            
            .apply-ptr-change:hover {
                text-decoration: none;
            }

CSS
        );
    }

    public function run(): string
    {
        return Html::tag(
            'a',
            Html::encode($this->model->{$this->attribute}) ?? Yii::t('hipanel', 'Empty'),
            [
                'class' => 'apply-ptr-change',
                'href' => '#',
                'data' => [
                    'container' => 'body',
                    'toggle' => 'popover',
                    'content' => Yii::t(
                        'hipanel:hosting',
                        'In order to change you need to {apply}',
                        [
                            'apply' => Html::a(
                                Yii::t('hipanel:hosting', 'apply for change of PTR records'),
                                ['@ticket/create'],
                                ['target' => '_blank']
                            ),
                        ]
                    ),
                    'placement' => 'top',
                ],
            ]
        );
    }
}
