<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\Item $model */
/** @var app\models\Item $modelCabinet */
/** @var yii\widgets\ActiveForm $form */
/** @var yii\widgets\ActiveForm $categories */
/** @var yii\widgets\ActiveForm $corps */
/** @var yii\widgets\ActiveForm $cabinets */
/** @var yii\widgets\ActiveForm $users */
/* @var $arrKey*/

$this->title = 'Обновить кабинет/корпус';
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="item-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= Html::label('Корпус', 'corps', ['class' => 'control-label']) ?>
    <?= Html::dropDownList('corps', '',
        ArrayHelper::map($corps, 'id', 'corps'),
        [
            'prompt' => 'Select corp ...',
            'class' => 'form-control',
            'id' => 'corps',
            'onchange' => '
                 $.post(
                    "' . Url::toRoute('cabinets') . '",
                    {id: $(this).val()},
                    function(data){
                      $("select#item-cabinet_id").html(data).attr("disabled", false);
                    }
                  );
                ',
        ]); ?>


    <?= $form->field($model, 'cabinet_id')
        ->dropDownList(
                [],
            [
                'prompt' => 'Select cabinet ...',
            ]
        )
        ->label('Кабинет') ?>

    <div class="form-group field-item-cabinet_id required">


        <div class="form-group">
            <?= Html::a(
                'Сохранить',
                ['item/multi-update-corps-cabinet'],
                [
                    'class' => 'btn btn-primary',
                    'name' => 'signup-button',
                    'data' =>
                        [
                            'method' => 'post',
                            'params' =>[
                                'arrKey'=>$arrKey
                            ]
                        ],
                ]) ?>

<!--    <div class="form-group">-->
<!--        --><?php //= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
<!--    </div>-->

    <?php ActiveForm::end(); ?>
</div>
