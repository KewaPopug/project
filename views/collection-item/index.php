<?php

use app\models\CollectionItem;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\CollectionItemSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Collection Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collection-item-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Collection Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'id',
            [
                'label' => ' Пользователь',
                'attribute' => 'username',
                'value' => 'user.username',
            ],
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
            'collection_type_id',
            [
                'format'=>'raw',
                'value' => function($data){
                    return Html::a('Подтвердить', ['accept', 'id'=>$data->id, 'action' => $data->action],
                    [
                        'id' => 'btn-multi-view',
                        'class' => 'btn btn-success',
                        'data' => [
                            'method' => 'post'
                        ]
                    ]);
                }
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, CollectionItem $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
