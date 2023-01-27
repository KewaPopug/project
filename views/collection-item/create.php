<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\CollectionItem $model */

$this->title = 'Create Collection Item';
$this->params['breadcrumbs'][] = ['label' => 'Collection Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collection-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
