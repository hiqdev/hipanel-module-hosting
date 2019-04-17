<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

use hipanel\widgets\BulkOperation;

echo BulkOperation::widget([
    'model' => $model,
    'models' => $models,
    'scenario' => 'disable-block',
    'affectedObjects' => Yii::t('hipanel:hosting', 'Affected accounts'),
    'formatterField' => 'login',
    'hiddenInputs' => ['id', 'login'],
    'visibleInputs' => ['comment'],
    'submitButton' => Yii::t('hipanel', 'Disable block'),
    'submitButtonOptions' => ['class' => 'btn btn-danger'],
    'dropDownInputs' => ['type' => $blockReasons],
]);
