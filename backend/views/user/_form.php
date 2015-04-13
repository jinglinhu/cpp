<?php
use backend\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\tree\TreeViewInput;
use backend\models\Organization;


$avatar_list = array();
foreach (Yii::$app->params['avatar_url'] as $v) {
    $avatar_list[$v] = Html::img(Yii::$app->homeUrl.$v, ['class' => 'img-circle','width' => '30px', 'height' => '30px']);
}

?>
<?php $form = ActiveForm::begin(); ?>
<?php $box->beginBody(); ?>
    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'username')->textInput(['maxlength' => 30,'readonly'=> !$model->isNewRecord ]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'realname')->textInput(['maxlength' => 20]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'repassword')->passwordInput(['maxlength' => 255]) ?>
        </div>
    </div>
    <div class="row">

        <div class="col-sm-3">
            <?= $form->field($model, 'email')->textInput(['maxlength' => 100]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'mobile')->textInput(['maxlength' => 20]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'position')->textInput(['maxlength' => 20]) ?>
        </div>
        <div class="col-sm-3">
         <?= $form->field($model, 'status')->dropDownList(User::getArrayStatus()) ?>
        </div>
    </div>
     <div class="row">
        <div class="col-sm-6">
            <?php 
                $error = $model->getErrors();   
                $style = '';
                if(isset($error['oid'])){
                    $style ='color:#a94442';
                ?>
                    <div class="help-block" style = 'color:#a94442'>请选择组织结构单位</div>     
                <?php 
                }
            ?>  
            <? echo TreeViewInput::widget([
                    // single query fetch to render the tree
                    'query' => Organization::find()->andWhere(['>=', 'lft', Yii::$app->user->identity->organization->lft])->andWhere(['<=', 'rgt', Yii::$app->user->identity->organization->rgt])->addOrderBy('root, lft'), 
                    'headingOptions'=>['label'=>'组织机构','style'=>$style],
                    'name' =>  'User[oid]', // input name
                    'value' => $model->oid,     // values selected (comma separated for multiple select)
                    'asDropdown' => false,   // will render the tree input widget as a dropdown.
                    'multiple' => true,     // set to false if you do not need multiple selection
                    'fontAwesome' => false,  // render font awesome icons
                    'rootOptions' => [
                        'style'=>'display:none'
                    ], 
                    //'options'=>['disabled' => true],
                ]);
            ?>
        </div>
         <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-12">
                <label class="control-label" for="user-avatar_url">头像</label>
                <?= Html::activeRadioList($model,'avatar_url', $avatar_list, ['separator'=>"&nbsp;",'encode'=>false]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <label class="control-label" for="user-avatar_url">角色</label>
                    <?= Html::CheckboxList('role',$arrayUserRoles, $arrayRoles,['separator'=>"<br/>",'encode'=>false]) ?>
                </div>
            </div>
        </div>
    </div>
    
<?php $box->endBody(); ?>
<?php $box->beginFooter(); ?>
<?= Html::submitButton(
    $model->isNewRecord ? Yii::t('app', 'Create User Id') : Yii::t('app', 'Update User Id'),
    [
        'class' => $model->isNewRecord ? 'btn btn-primary btn-large' : 'btn btn-success btn-large'
    ]
) ?>
<?php $box->endFooter(); ?>
<?php ActiveForm::end(); ?>