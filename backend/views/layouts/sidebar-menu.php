<?php
use mdm\admin\components\MenuHelper;
use common\widgets\Menu;

$items_site[] =[
    'label' => '首页',
    'url' =>['/site/index'],
    'icon' => 'fa-dashboard',
];
$callback = function ($menu) {
     $return =[
         'label' => $menu['name'],
         'url' => [$menu['route']],
         'icon'=> $menu['icon'],
         'items' => $menu['children']
        ];

     if($return['items']){
        $return['options'] = ['class'=>'treeview'];
     }
     return $return;
 };

$items = MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback);


$items = array_merge($items_site,$items);

#print_r($items);exit;
echo Menu::widget(
    [
        'options' => [
            'class' => 'sidebar-menu'
        ],
        'items' => $items
    ]
);