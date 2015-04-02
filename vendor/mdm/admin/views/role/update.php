<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var mdm\admin\models\AuthItem $model
 */
$this->title = Yii::t('rbac-admin', 'Update Role');
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-update">

	<?php
    echo $this->render('_form', [
        'model' => $model,
        'avaliable' => $avaliable,
        'assigned' => $assigned
    ]);
    ?>
</div>
