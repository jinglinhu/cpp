<?php

use yii\helpers\Html;
use common\widgets\GridView;
use yii\widgets\Pjax;
use yii\grid\ActionColumn;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Menu */

$this->title = Yii::t('rbac-admin', 'Menus');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>
    <?php  if (Yii::$app->user->can('/admin/*')||Yii::$app->user->can('/admin/menu/*')||Yii::$app->user->can('/admin/menu/create')) { ?>
    <p>
        <?= Html::a(Yii::t('rbac-admin', 'Create Menu'), ['create'], ['class' => 'btn btn-success pull-right']) ?>
    </p>

    <?php } ?>
    <?php
    Pjax::begin(['formSelector' => 'form', 'enablePushState' => false]);
    
    $columns = [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'menuParent.name',
                'filter' => Html::activeTextInput($searchModel, 'parent_name', [
                    'class' => 'form-control', 'id' => null
                ]),
                'label' => Yii::t('rbac-admin', 'Parent'),
            ],
            'route',
            'order',
            [
                'attribute' => 'icon',
                'format' => 'html',
                'value' => function ($model) {
                    return  '<i class="fa '.$model->icon.'"></i>';
                },
            ],
        ];

    $showActions = false;
    if (Yii::$app->user->can('/admin/*')||Yii::$app->user->can('/admin/menu/*')||Yii::$app->user->can('/admin/menu/upadte')) {
        $actions[] = '{update}';
        $showActions = $showActions || true;
    }
    if (Yii::$app->user->can('/admin/*')||Yii::$app->user->can('/admin/menu/*')||Yii::$app->user->can('/admin/menu/delete')) {
        $actions[] = '{delete}';
        $showActions = $showActions || true;
    }

    if ($showActions === true) {
        $columns[] = [
            'class' => ActionColumn::className(),
            'template' => implode(' ', $actions)
        ];
    }
    $boxButtons = !empty($boxButtons) ? implode(' ', $boxButtons) : null;

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
    ]);

    Pjax::end();
    ?>

</div>
