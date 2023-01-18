<?php

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\adminPanel\models\searchs\User */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $users app\modules\adminPanel\models\User */
/* @var $items app\models\Item*/
/* @var $model app\models\User*/
/* @var $arrKey*/

//$this->title = Yii::t('rbac-admin', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->dropDownList(
        ArrayHelper::map($users, 'id', 'username'),
        [
            'prompt' => 'Выберите пользователя для замены',
            'class' => 'form-control',
        ])->label('Пользователь'); ?>

    <div class="form-group">
        <?= Html::a(
            'Далее',
            ['item/transfer-item-multi'],
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
            ]) ?>.
<!--        --><?php //= Html::submitButton('Далее', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
