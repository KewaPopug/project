<?php

use app\models\Item;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\CollectionItem $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Collection Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="collection-item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user.username',
            [
                'label' => 'Инвентаризационные номера',
                'value' => function($data){
                    $itemsArr = json_decode($data->collection);
                    $numArr = '';
                    foreach ($itemsArr as $id){
                        $itemModel = \app\models\Item::findOne(['id' => $id]);
                        if ($numArr !== '')
                            $numArr .= ', ' . $itemModel->number_item;
                        else
                            $numArr = $itemModel->number_item;
                    }
                    return $numArr;
                }
            ],
            'action',
            'collectionType.name',

        ],
    ]) ?>

</div>
