<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <title><?= Html::encode($this->title).'－集中采购网络交易平台'; ?></title>
    <?= Html::csrfMetaTags(); ?>
    <?php $this->head(); ?>
</head>
<body class="bg-white" style="min-height: 790px">
<?php $this->beginBody() ?>
<?= Alert::widget() ?>
<?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>


