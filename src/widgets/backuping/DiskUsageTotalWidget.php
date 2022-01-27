<?php
declare(strict_types=1);

namespace hipanel\modules\hosting\widgets\backuping;

use hipanel\helpers\ArrayHelper;
use hipanel\modules\hosting\models\Backuping;
use Yii;
use yii\base\Widget;
use yii\bootstrap\Html;

final class DiskUsageTotalWidget extends Widget
{
    /**
     * @var Backuping[]
     */
    public array $rows = [];

    public function run(): string
    {
        $formatter = Yii::$app->formatter;
        $html = Html::beginTag('table', ['class' => 'table table-striped', 'style' => 'margin: 0 1em 1em; width: 50%;']);
        $html .= Html::beginTag('tbody');

        foreach (ArrayHelper::map($this->rows, 'id', 'total_du', 'object') as $groupName => $items) {
            $html .= Html::beginTag('tr');
            $html .= Html::tag('th', Yii::t('hipanel.hosting.objects', $groupName), ['class' => 'text-center']);
            $html .= Html::tag(
                'td',
                $formatter->asShortSize(array_sum(array_values($items)), 2),
                ['class' => 'text-left']
            );
            $html .= Html::endTag('tr');
        }

        $html .= Html::beginTag('tr');
        $html .= Html::tag('th');
        $html .= Html::tag(
            'th',
            $formatter->asShortSize(array_sum(array_column($this->rows, 'total_du')), 2),
            ['class' => 'text-left']
        );
        $html .= Html::endTag('tr');

        $html .= Html::endTag('tbody');
        $html .= Html::endTag('table');

        return $html;
    }
}
