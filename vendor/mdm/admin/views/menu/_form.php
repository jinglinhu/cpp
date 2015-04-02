<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mdm\admin\models\Menu;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\Menu */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>
     <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => 128]) ?>
        </div>
        <div class="col-sm-6">
             <?= $form->field($model, 'parent_name')->widget('yii\jui\AutoComplete',[
                'options'=>['class'=>'form-control'],
                'clientOptions'=>[
                    'source'=>  Menu::find()->select(['name'])->column()
                ]
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'route')->widget('yii\jui\AutoComplete',[
                    'options'=>['class'=>'form-control'],
                    'clientOptions'=>[
                        'source'=> Menu::getSavedRoutes()
                    ]
                ]) ?>        
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'order')->input('number') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'icon')->textInput(['maxlength' => 15]) ?>
            <a href='/admin/menu/icon/' target="_blank" class="pull-right">图标示例</a>

        </div>
        <div class="col-sm-6">
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('rbac-admin', 'Create') : Yii::t('rbac-admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
