<?php

use yii\helpers\Html;
?>
<div class="navbar-nav navbar-left">
    <ul class="nav navbar-nav">
        <li class="dropdown user user-menu">
            <a >集中采购网络交易平台</a>
        </li>
    </ul>
</div>
<div class="navbar-right">
    <ul class="nav navbar-nav">
        <!-- User Account: style can be found in dropdown.less -->
        <li class=""><a><i class="glyphicon glyphicon-time"></i>&nbsp;<span class="text" id="Timer"></span></a></li>

        <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="glyphicon glyphicon-user"></i>
                <span><?= Yii::$app->user->identity->realname ?> <i class="caret"></i></span>
            </a>
            <ul class="dropdown-menu">

                <!-- User image -->
                <li class="user-header bg-light-blue">
                    <?php if (Yii::$app->user->identity->avatar_url) : ?>
                        <?= Html::img(Yii::$app->homeUrl.Yii::$app->user->identity->avatar_url, ['class' => 'img-circle', 'alt' => Yii::$app->user->identity->realname]) ?>
                    <?php endif; ?>
                    <p>
                        角色 -
                        <?                     
                        $roles = Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id);
                            $tmp = array();
                            if($roles){
                                foreach ($roles as $k => $v) {
                                    $tmp[] = $v->description;
                                }
                            }
                         echo implode(',',$tmp);?>
                        <small>创建于&nbsp;<?= date("Y-m-d",Yii::$app->user->identity->created_at )?></small>
                    </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <div class="pull-left">
                        <?= Html::a(
                            Yii::t('app', 'Home'),
                            ['/site/'],
                            ['class' => 'btn btn-default btn-flat']
                        ) ?>
                    </div>
                    <div class="pull-right">
                        <?= Html::a(
                            Yii::t('app', 'Logout'),
                            ['/site/logout/'],
                            ['class' => 'btn btn-default btn-flat']
                        ) ?>
                    </div>
                </li>
            </ul>
        </li>
    </ul>
</div>