<?php
use common\widgets\Box;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model yii\web\IdentityInterface */

$this->title = Yii::t('rbac-admin', 'Assignments');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['/user/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="assignment-index">
    <div class="col-sm-12">
        <?php $box = Box::begin(
            [
                'title' => Yii::t('rbac-admin', 'User') ." : ".Html::encode($model->{$usernameField}),
                'renderBody' => false,
                'options' => [
                    'class' => 'box-primary'
                ],
                'bodyOptions' => [
                    'class' => 'table-responsive'
                ],
            ]
        );
        $box->beginBody(); ?>
        <div class="col-lg-5">
        <?= Yii::t('rbac-admin', 'Avaliable') ?>:
        <?php
        echo Html::textInput('search_av', '', ['class' => 'role-search', 'data-target' => 'avaliable']) . '<br／><br／>';
        echo Html::listBox('roles', '', $avaliable, [
            'id' => 'avaliable',
            'multiple' => true,
            'size' => 20,
            'style' => 'width:100%']);
        ?>
    </div>
    <div class="col-lg-1">
        &nbsp;<br><br>
        <?php
        echo Html::a('>>', '#', ['class' => 'btn btn-success', 'data-action' => 'assign']) . '<br>';
        echo Html::a('<<', '#', ['class' => 'btn btn-success', 'data-action' => 'delete']) . '<br>';
        ?>
    </div>
    <div class="col-lg-5">
        <?= Yii::t('rbac-admin', 'Assigned') ?>:
        <?php
        echo Html::textInput('search_asgn', '', ['class' => 'role-search', 'data-target' => 'assigned']) . '<br>';
        echo Html::listBox('roles', '', $assigned, [
            'id' => 'assigned',
            'multiple' => true,
            'size' => 20,
            'style' => 'width:100%']);
        ?>
    </div>
        <?php 
        $box->endBody();
        Box::end(); ?>
    </div>
</div>
<?php
$this->render('_script',['id'=>$model->{$idField}]);
