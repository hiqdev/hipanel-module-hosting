<?php

use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\hosting\widgets\combo\AccountCombo;
use hipanel\modules\server\widgets\combo\ServerCombo;
?>

<div class="col-md-4"><?= $search->field('account')->widget(AccountCombo::className()) ?></div>
<!-- /.col-md-4 -->
<div class="col-md-4"><?= $search->field('server')->widget(ServerCombo::className(), ['formElementSelector' => '.form-group']) ?></div>
<!-- /.col-md-4 -->
<div class="col-md-4"><?= $search->field('client_id')->widget(ClientCombo::classname(), ['formElementSelector' => '.form-group']) ?></div>
<!-- /.col-md-4 -->