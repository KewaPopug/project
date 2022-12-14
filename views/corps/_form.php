<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Corps $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="corps-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'corps')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
