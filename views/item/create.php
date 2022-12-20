<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Item $model */
/** @var app\models\Item $modelCabinet */
/** @var yii\widgets\ActiveForm $form */
/** @var yii\widgets\ActiveForm $categories */
/** @var yii\widgets\ActiveForm $corps */
/** @var yii\widgets\ActiveForm $cabinets */

$this->title = 'Create Item';
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
//        'modelCabinet' =>  $modelCabinet,
        'model' => $model,
        'corps' => $corps,
        'cabinets' => $cabinets,
//        'cabinet' => $cabinet,
        'categories' => $categories,
    ]) ?>

</div>
