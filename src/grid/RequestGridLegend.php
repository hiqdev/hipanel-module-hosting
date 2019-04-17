<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\grid;

use DateTime;
use hipanel\widgets\gridLegend\BaseGridLegend;
use hipanel\widgets\gridLegend\GridLegendInterface;

class RequestGridLegend extends BaseGridLegend implements GridLegendInterface
{
    public function items()
    {
        return [
            [
                'label' => ['hipanel:hosting', 'Scheduled time:'],
                'tag' => 'h4',
            ],
            [
                'label' => ['hipanel:hosting', 'Already'],
                'color' => '#E0E0E0',
                'rule' => ((new DateTime($this->model->time)) < (new DateTime())),
                'columns' => ['time'],
            ],
            [
                'label' => ['hipanel:hosting', 'Deferred'],
                'color' => '#AAAAFF',
                'rule' => ((new DateTime($this->model->time)) > (new DateTime())),
                'columns' => ['time'],
            ],
            [
                'label' => ['hipanel:hosting', 'State:'],
                'tag' => 'h4',
            ],
            [
                'label' => ['hipanel:hosting', 'New'],
                'color' => '#FFFF99',
                'rule' => $this->model->state === 'new',
                'columns' => ['state'],
            ],
            [
                'label' => ['hipanel:hosting', 'In progress'],
                'color' => '#AAFFAA',
                'rule' => $this->model->state === 'progress',
                'columns' => ['state'],
            ],
            [
                'label' => ['hipanel:hosting', 'Done'],
                'columns' => ['state'],
            ],
            [
                'label' => ['hipanel:hosting', 'Error'],
                'color' => '#FFCCCC',
                'rule' => $this->model->state === 'error',
                'columns' => ['state'],
            ],
            [
                'label' => ['hipanel:hosting', 'Buzzed'],
                'color' => '#FFCCCC',
                'rule' => $this->model->state === 'buzzed',
                'columns' => ['state'],
            ],
        ];
    }
}
