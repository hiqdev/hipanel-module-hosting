<?php

namespace hipanel\modules\hosting\grid;

use hiqdev\higrid\representations\RepresentationCollection;
use Yii;

class ServiceRepresentations extends RepresentationCollection
{
    protected function fillRepresentations()
    {
        $this->representations = array_filter([
            'common' => [
                'label' => Yii::t('hipanel', 'common'),
                'columns' => [
                    'seller_id',
                    'client_id',
                    'server',
                    'actions',
                    'object',
                    'ip',
                    'soft',
                    'state',
                ],
            ],
        ]);
    }
}
