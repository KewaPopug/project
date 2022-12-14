<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Cabinet $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="cabinet-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cabinet')->textInput() ?>

    <?= $form->field($model, 'corps_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
