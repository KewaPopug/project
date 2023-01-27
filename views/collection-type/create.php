<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\CollectionType $model */

$this->title = 'Create Collection Type';
$this->params['breadcrumbs'][] = ['label' => 'Collection Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collection-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
