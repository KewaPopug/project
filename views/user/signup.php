<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap5\ActiveForm */
/* @var $model app\models\Signup*/
/* @var $modelProfile app\models\Profile*/


$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::errorSummary($model)?>
    <?= Html::errorSummary($modelProfile)?>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'retypePassword')->passwordInput() ?>
                <?= $form->field($modelProfile, 'first_name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($modelProfile, 'second_name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($modelProfile, 'position')->textInput(['maxlength' => true]) ?>
                <?= $form->field($modelProfile, 'number')->textInput() ?>
                <?= Html::checkboxList('Content', false, ['Content'])?>
                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
