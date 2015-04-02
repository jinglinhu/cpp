<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\tree\TreeViewInput;
use backend\models\Organization;


/* @var $this yii\web\View */
/* @var $model backend\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
     <div class="row">
        <div class="col-sm-2">
            <?= $form->field($model, 'id') ?>
        </div>
        <div class="col-sm-2">
             <?= $form->field($model, 'username') ?>
        </div>
        <div class="col-sm-2">
             <?= $form->field($model, 'realname') ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'email') ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'mobile') ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'position') ?>
        </div>
    </div>
         <div class="row">
            <div class="col-sm-2">
                <label class="control-label" for="user-avatar_url"><?=Yii::t('app', 'Created At')?></label>
                <?php 
                echo DatePicker::widget(
                    [
                        'model' => $model,
                        'attribute' => 'created_at',
                        'options' => [
                            'class' => 'form-control'
                        ],
                        'clientOptions' => [
                            'dateFormat' => 'dd.mm.yy',
                        ]
                    ]
                );
                ?>
            </div>
            <div class="col-sm-2">
                <label class="control-label" for="user-avatar_url"><?=Yii::t('app', 'Status')?></label>
                <?php 
                   echo Html::activeDropDownList(
                        $model,
                        'status',
                        $arrayStatus,
                        ['class' => 'form-control','prompt' => Yii::t('app', 'Please Filter')]
                    );
                ?>
            </div>
            <div class="col-sm-4">
                <label class="control-label" for="user-avatar_url"><?=Yii::t('app', 'Organization')?></label>
                <?php
                echo TreeViewInput::widget([
                    // single query fetch to render the tree
                    'query' => Organization::find()->andWhere(['>=', 'lft', Yii::$app->user->identity->organization->lft])->andWhere(['<=', 'rgt', Yii::$app->user->identity->organization->rgt])->addOrderBy('root, lft'),
                    'headingOptions'=>['label'=>''],
                    'name' =>  'UserSearch[oid]', // input name
                    'value' => $model->oid,     // values selected (comma separated for multiple select)
                    'asDropdown' => true,   // will render the tree input widget as a dropdown.
                    'multiple' => false,     // set to false if you do not need multiple selection
                    'fontAwesome' => false,  // render font awesome icons
                    'rootOptions' => [
                        'style'=>'display:none'
                    ], 
                    //'options'=>['disabled' => true],
                ]);
                ?>
            </div>
            <div class="col-sm-2">
            </div>
            <div class="col-sm-2">
            </div>
            <div class="col-sm-2">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                 <span class = 'pull-right'>
                <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('app', 'Reset'),['/user/index/'], ['class' => 'btn btn-default']) ?>
                 <?php 
                if (Yii::$app->user->can('/user/*')||Yii::$app->user->can('/user/create')) {

                    echo Html::a(Yii::t('app', 'Create User'),['/user/create/'],['class' => 'btn btn-success']); 
                }
                ?>
                </span>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
<hr/>
