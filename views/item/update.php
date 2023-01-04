<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Item $model */
/** @var app\models\Item $modelCabinet */
/** @var yii\widgets\ActiveForm $form */
/** @var yii\widgets\ActiveForm $categories */
/** @var yii\widgets\ActiveForm $corps */
/** @var yii\widgets\ActiveForm $cabinets */
/** @var yii\widgets\ActiveForm $users */

$this->title = 'Update Item: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelCabinet' =>  $modelCabinet,
        'categories' => $categories,
        'cabinets' => $cabinets,
        'corps' => $corps,
        'model' => $model,
        'users' => $users,
    ]) ?>

</div>
