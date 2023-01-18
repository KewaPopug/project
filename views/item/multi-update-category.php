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

$this->title = 'Обновить категорю предмета';
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="item-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')
        ->dropDownList(ArrayHelper::map($categories, 'id', 'category'),
            [
                'prompt' => 'Select category ...',
            ])
        ->label('Категория') ?>

    <div class="form-group field-item-cabinet_id required">
        <div class="form-group">
            <?= Html::a(
                'Сохранить',
                ['item/multi-update-category'],
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
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
