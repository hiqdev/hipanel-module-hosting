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

use hiqdev\higrid\representations\RepresentationCollection;
use Yii;

class PrefixRepresentations extends RepresentationCollection
{
    protected function fillRepresentations(): void
    {
        $this->representations = array_filter([
            'common' => [
                'label' => Yii::t('hipanel', 'common'),
                'columns' => [
                    'checkbox',
                    'actions',
                    'ip',
                    'type',
                    'vrf',
                    'role',
                    'site',
                    'utilization',
                    'note',
                ],
            ],
        ]);
    }
}
