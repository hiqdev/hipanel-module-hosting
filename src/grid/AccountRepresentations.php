<?php

namespace hipanel\modules\hosting\grid;

use hiqdev\higrid\representations\RepresentationCollection;
use Yii;

class AccountRepresentations extends RepresentationCollection
{
    protected function fillRepresentations()
    {
        $this->representations = array_filter([
            'common' => [
                'label' => Yii::t('hipanel', 'common'),
                'columns' => [
                    'checkbox',
                    'account',
                    'client',
                    'seller',
                    'server',
                    'state',
                    'type',
                ],
            ],
        ]);
    }
}
