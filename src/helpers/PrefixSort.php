<?php

namespace hipanel\modules\hosting\helpers;

class PrefixSort
{
    public static function byKinship(array &$models): void
    {
        $result = [];
        function kinship(array $models, ?int $id, array &$result)
        {
            foreach ($models as $model) {
                if ($model->parent_id === $id) {
                    $result[] = $model;
                    kinship($models, $model->id, $result);
                }
            }
        }

        kinship($models, null, $result);
        $models = $result;
    }

    public static function byCidr(array &$models): void
    {
        usort($models, static function ($a, $b): int {
            return $a->getIPBlock()->getNetworkAddress()->numeric() <=> $b->getIPBlock()->getNetworkAddress()->numeric();
        });
    }
}

