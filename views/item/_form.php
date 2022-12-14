<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\Item $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="item-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map($categories, 'id', 'category'))->label('Категория') ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true])->label('Статус') ?>

    <?= $form->field($model, 'name_item')->textInput(['maxlength' => true])->label('Название') ?>

    <?= $form->field($model, 'number')->textInput(['maxlength' => true])->label('Инвентаризационный номер') ?>

    <?= Html::label('Corps', 'corps', ['class' => 'control-label']) ?>
    <?= Html::dropDownList('corps', '',
        ArrayHelper::map($corps, 'id', 'corps'),
        [
            'prompt' => 'Select country ...',
            'class' => 'form-control',
            'id' => 'corps',
            'onchange' => '
                                 $.post(
                                    "' . Url::toRoute('cabinet') . '",
                                    {id: $(this).val()},
                                    function(data){
                                      $("select#cabinet").html(data).attr("disabled", false);
                                    }
                                  );
                                ',
        ]); ?>


    <?= Html::label('Cabinet', 'cabinet', ['class' => 'control-label']) ?>
    <?= Html::dropDownList('cabinets', '',
        ArrayHelper::map($cabinets, 'id', 'cabinet'),
        [
            'prompt' => 'Select country ...',
            'class' => 'form-control',
            'id' => 'corps',
            'onchange' => '
                                 $.post(
                                    "' . Url::toRoute('cabinet') . '",
                                    {id: $(this).val()},
                                    function(data){
                                      $("select#cabinet").html(data).attr("disabled", false);
                                    }
                                  );
                                ',
        ]); ?>

<!--    <select class="cabinet" name="cabinet" id="cabinet">-->
<!--    </select>-->


<!--    <?//= $form->field($model, 'cabinet_id')->dropDownList($arrCabinets) ?>-->

<!--    <div class="form-group">-->


<!--    <div class="form-group">-->
<!--        <?//= Html::label('University', 'university', ['class' => 'control-label']) ?>-->
<!--        <?//= Html::dropDownList('', '',[],
//            [
//                'prompt' => 'Select university ...',
//                'id' => 'cabinet',
//                'class' => 'form-control',
//                'disabled' => $model->isNewRecord ? 'disabled' : false,
//            ]); ?>-->
<!--    </div>-->

<!--    <?//= $form->field($model, 'cabinet_id')->dropDownList(yii\helpers\ArrayHelper::map(app\models\Cabinet::find()->all(),'id','cabinet'), [
//        'prompt'=>'Выбрать',
//        'onchange'=>'
//                $.post("/item/lists?id='.'"+$(this).val(), function(data){
//                    $("select#corps-corps_id").html(data);
//                });',
//    ]) ?>-->

<!--    <div class="form-group">-->
<!--        <?//= Html::label('University', 'university', ['class' => 'control-label']) ?>-->
<!--        <?//= Html::dropDownList('', '',[],
//            [
//                'prompt' => 'Select university ...',
//                'id' => 'cabinet',
//                'class' => 'form-control',
//                'disabled' => $model->isNewRecord ? 'disabled' : false,
//            ]); ?>-->
<!--    </div>-->


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
