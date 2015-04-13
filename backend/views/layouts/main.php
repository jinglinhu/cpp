<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title).'－集中采购网络交易平台' ?></title>
    <?php $this->head() ?>
</head>
<body class="skin-blue">
    <?php $this->beginBody() ?>
    <header class="header">
        <a href="<?= Yii::$app->homeUrl ?>" class="logo">
            <!-- Add the class icon to your logo image or logo icon to add the margining -->
          <!-- <?= Html::img(Yii::$app->homeUrl.'adminlte/img/zjsy_01.jpg', ['class' => 'img-circle', 'alt' => 'logo','width' => '55px', 'height' => '40px']) ?> -->
          CSCEC 中&nbsp;國&nbsp;建&nbsp;築
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only"><?= Yii::t('app', 'Toggle navigation') ?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <?= $this->render('//layouts/top-menu.php') ?>
        </nav>
    </header>
    <div class="wrapper row-offcanvas row-offcanvas-left">
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="left-side sidebar-offcanvas">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                             <?= Html::img(Yii::$app->homeUrl.Yii::$app->user->identity->avatar_url, ['class' => 'img-circle', 'alt' => 'admin']) ?>                       
                    </div>
                    <div class="pull-left info">
                        <p>
                            <?= Yii::t('app', 'Hello, {name}', ['name' => Yii::$app->user->identity->realname]) ?>
                        </p>
                        <a>
                            <i class="fa fa-circle text-success"></i> <?= Yii::t('app', 'Online') ?>
                        </a>
                    </div>
                </div>
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <?= $this->render('//layouts/sidebar-menu') ?>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Right side column. Contains the navbar and content of the page -->
        <aside class="right-side">
            <?php if(Yii::$app->controller->id != 'site'){?>
            <!-- Content Header (Page header) -->
            <section class="content-header">
                    <?= $this->title ?>
                    <?php if (isset($this->params['subtitle'])) : ?>
                        <small><?= $this->params['subtitle'] ?></small>
                    <?php endif; ?>
                <?= Breadcrumbs::widget(
                    [
                        'homeLink' => [
                            'label' => '<i class="fa fa-dashboard"></i> ' . Yii::t('app', 'Home'),
                            'url' => ['/']
                        ],
                        'encodeLabels' => false,
                        'tag' => 'ol',
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []
                    ]
                ) ?>
            </section>
            <?php }?>
            <!-- Main content -->
            <section class="content">
                <?= Alert::widget() ?>
                <?= $content ?>
            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

<script type="text/javascript">
$(function() {
    setInterval("GetTime()", 1);
  });

function GetTime() {
  var mon, day, now, hour, min, ampm, time, str, tz, end, beg, sec;
  /*
  mon = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug",
      "Sep", "Oct", "Nov", "Dec");
  */
  mon = new Array("1", "2", "3", "4", "5", "6", "7", "8","9", "10", "11", "12");
  /*
  day = new Array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");
  */
  day = new Array("周日", "周一", "周二", "周三", "周四", "周五", "周六");
  now = new Date();
  hour = now.getHours();
  min = now.getMinutes();
  sec = now.getSeconds();
  if (hour < 10) {
    hour = "0" + hour;
  }
  if (min < 10) {
    min = "0" + min;
  }
  if (sec < 10) {
    sec = "0" + sec;
  }
  $("#Timer").html(
      "<nobr>" + now.getFullYear() + "年" + mon[now.getMonth()] + "月"+ now.getDate() + "日，" + day[now.getDay()] + "，" + hour+ ":" + min + ":" + sec + "</nobr>");
    $('#Timer').addClass('animated bounceInRight');
  
}
</script>