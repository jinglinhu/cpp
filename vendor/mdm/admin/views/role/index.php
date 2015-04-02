<?php

use yii\helpers\Html;
use common\widgets\GridView;
use yii\widgets\Pjax;
use yii\grid\ActionColumn;
use yii\rbac\Item;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var mdm\admin\models\AuthItemSearch $searchModel
 */
$this->title = Yii::t('rbac-admin', 'Roles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-index">
    <?php  if (Yii::$app->user->can('/admin/*')||Yii::$app->user->can('/admin/role/*')||Yii::$app->user->can('/admin/role/create')) { ?>
    <p>
        <?= Html::a(Yii::t('rbac-admin', 'Create Role'), ['create'], ['class' => 'btn btn-success pull-right']) ?>
    </p>
    <?php } ?>

    <?php
    Pjax::begin([
        'enablePushState'=>false,
    ]);
    $columns = [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'label' => Yii::t('rbac-admin', 'Name'),
            ],
            [
                'attribute' => 'description',
                'label' => Yii::t('rbac-admin', 'Description'),
            ],
            [
            'attribute' => Yii::t('rbac-admin', 'Assigned'),
            'format' => 'html',
            'value' => function ($model) {
                $assigned = [];
                $authManager = Yii::$app->getAuthManager();
                foreach ($authManager->getChildren($model->name) as $name => $child) {
                    if ($child->type == Item::TYPE_ROLE) {
                        $assigned['Roles'][$name] = $name;
                    } else {
                        $assigned[$name[0] === '/' ? 'Routes' : 'Permission'][$name] = $name;
                    }
                }
                $tmp = '';
                if($assigned){
                   foreach ($assigned as $k => $v) {
                        $tmp .= Yii::t('rbac-admin', $k).":<br/>";
                        foreach ($v as $sk => $sv) {
                             $tmp .= "&nbsp;&nbsp;&nbsp;&nbsp;".$sv ."<br/>";
                         } 
                   }
                }
               return $tmp;
                },
            ],
        ];

    $showActions = false;
    if (Yii::$app->user->can('/admin/*')||Yii::$app->user->can('/admin/role/*')||Yii::$app->user->can('/admin/role/upadte')) {
        $actions[] = '{update}';
        $showActions = $showActions || true;
    }
    if (Yii::$app->user->can('/admin/*')||Yii::$app->user->can('/admin/role/*')||Yii::$app->user->can('/admin/role/delete')) {
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
