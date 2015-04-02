<?php
use mdm\admin\components\MenuHelper;
use common\widgets\Menu;

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
    
echo Menu::widget(
    [
        'options' => [
            'class' => 'sidebar-menu'
        ],
        'items' => $items
    ]
);