<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="form-box" id="login-box">
    <div class="header"><?php echo Html::encode($this->title); ?></div>
    <?php $form = ActiveForm::begin(); ?>
    <div class="body bg-gray">
        <?= $form->field($model, 'username')->textInput(['placeholder' => $model->getAttributeLabel('username')])->label(false) ?>
        <?= $form->field($model, 'password')->passwordInput(['placeholder' => $model->getAttributeLabel('password')])->label(false) ?>
        <!-- <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), ['template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',]) ?> -->
        <?= $form->field($model, 'rememberMe')->checkbox() ?>
    </div>
    <div class="footer bg-gray">
        <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn bg-olive btn-block']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

