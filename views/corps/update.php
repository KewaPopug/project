<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Corps $model */

$this->title = 'Update Corps: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Corps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="corps-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
