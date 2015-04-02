<?php
use common\widgets\Box;

$this->title = Yii::t('app', 'Create User Id');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create User Id');
?>
<div class="row">
    <div class="col-sm-12">
        <?php $box = Box::begin(
            [
                'renderBody' => false,
                'options' => [
                    'class' => 'box-primary'
                ],
                'bodyOptions' => [
                    'class' => 'table-responsive'
                ],
                'buttonsTemplate' => '{cancel}'
            ]
        );
        echo $this->render(
            '_form',
            [
                'model' => $model,
                'box' => $box,
                'arrayRoles' => $arrayRoles,
                'arrayUserRoles' => [],
            ]
        );
        Box::end(); ?>
    </div>
</div>