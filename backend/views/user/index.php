<?php
use common\widgets\Box;
use common\widgets\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\models\User;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users List');

$this->params['breadcrumbs'][] = $this->title;

$gridId = 'users-grid';
$gridConfig = [
        'id' => $gridId,
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'username',
                'format' => 'html',
                'value' => function ($model) {

                        if($model->avatar_url){
                            $avatar = $model->avatar_url;

                        }else{
                            $avatar = 'adminlte/img/default_head.jpg';
                        }
                        return Html::img(Yii::$app->homeUrl.$avatar, ['class' => 'img-circle pull-left', 'alt' => 'logo','width' => '30px', 'height' => '30px']). "&nbsp;&nbsp;" .$model->username ;
                    },
            ],
            'realname',
            'email:email',
            'mobile',
            [
                'attribute' => Yii::t('app', 'Organization'),
                'value' => function ($model) {
                        return  $model->organization->name ;
                    },
            ],
            [
                'attribute' => Yii::t('app', 'Position'),
                'value' => function ($model) {
                        return  $model->position ;
                    },
            ],
            [
            'attribute' => Yii::t('app', 'Role'),
            'format' => 'html',
            'value' => function ($model) {
                    $roles = Yii::$app->authManager->getRolesByUser($model->id);
                    $tmp = array();
                    if($roles){
                        foreach ($roles as $k => $v) {
                            $tmp[] = $v->description;
                        }
                    }
                    return implode('&nbsp;',$tmp);
                },
            ],
            "created_at:date",
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                        if ($model->status === $model::STATUS_ACTIVE) {
                            $class = 'label-success';
                        } elseif ($model->status === $model::STATUS_INACTIVE) {
                            $class = 'label-warning';
                        } else {
                            $class = 'label-danger';
                        }

                        return '<span class="label ' . $class . '">' . $model->statusLabel . '</span>';
                    },
            ],
           

        ],
    ];

$actions = [];
$showActions = false;

if (Yii::$app->user->can('/user/*')||Yii::$app->user->can('/user/update')) {
    $actions[] = '{update}';
    $showActions = $showActions || true;
}
if (Yii::$app->user->can('/user/*')||Yii::$app->user->can('/user/delete')) {
    $actions[] = '{delete}';
    $showActions = $showActions || true;
}
if ($showActions === true) {
    $gridConfig['columns'][] = [
        'class' => ActionColumn::className(),
        'template' => implode(' ', $actions)
    ];
}
?>
<div class="row">
    <div class="col-xs-12">

        <?php Box::begin(
            [
                'bodyOptions' => [
                    'class' => 'table-responsive'
                ],
                'grid' => $gridId
            ]
        ); 
        echo $this->render(
            '_search',
            [
                'model' => $searchModel,
                'arrayStatus' => $arrayStatus,
            ]
        ); ?>
        
        <?php 
            Pjax::begin(['formSelector' => 'form', 'enablePushState' => false]);

            echo GridView::widget($gridConfig); 

            Pjax::end();
        ?>
       
       <?php  Box::end(); ?>

        
    </div>
</div>