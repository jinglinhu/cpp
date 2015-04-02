<?php
use common\widgets\Box;
use common\widgets\GridView;
use kartik\tree\TreeView;
use backend\models\Organization;

$this->title = Yii::t('app', 'Organization');

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col-xs-12">
        <?php Box::begin(
            [
                'bodyOptions' => [
                    'class' => 'table-responsive'
                ],
            ]
        ); 
        echo TreeView::widget([
            // single query fetch to render the tree
            'query' => Organization::find()->addOrderBy('root, lft'), 
            'headingOptions' => ['label' => '组织机构'],
            'rootOptions' => ['style'=>"display:none"],
            'isAdmin' => true,         // optional (toggle to enable admin mode),only jinglin can modify Yii::$app->user->id === 2 ? true : 
            'displayValue' => 1,        // initial display value
            'softDelete' => true,       // defaults to true
            'fontAwesome' => false,
            'allowNewRoots' => false,
            'iconEditSettings'=> [
                'show' => 'none',
            ],
            'cacheSettings' => [        
                'enableCache' => true   // defaults to true
            ],
            'mainTemplate' => '<div class="row"><div class="col-sm-4">{wrapper}</div><div class="col-sm-8">{detail}</div></div>',
        ]);
        Box::end(); ?>
    </div>
</div>