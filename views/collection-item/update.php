<?php

use app\models\CollectionItem;
use app\models\Item;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\CollectionItem $model */
/** @var $collNumbers */

$this->title = 'Update Collection Item: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Collection Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="collection-item-view">


    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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

<div class="collection-item-index">
    <div class="item-index">
        <?= GridView::widget([
            'id' => 'grid',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
//                'id',
                [
                    'label' => 'Имя',
                    'attribute'=>'name_item',
                    'value' => 'name_item',
                ],
                [
                    'label' => 'Номер',
                    'attribute'=>'number_item',
                    'value' => 'number_item',
                ],
                [
                    'label' => 'Кабинет',
                    'attribute'=>'cabinet',
                    'value' => function($data){
                        return $data->cabinet->cabinet . '( корпус: '.$data->cabinet->corps->corps.')';
                    },
                ],
                [
                    'label' => 'Фамилия',
                    'attribute'=>'profile',
                    'value' => 'profile.second_name',
                ],
                [
                    'filter' => [
                        '' => \yii\helpers\ArrayHelper::map($categories, 'category','category')
                    ],
                    'format' => 'raw',
                    'label' => 'Категория',
                    'attribute'=>'category',
                    'value' => 'category.category',
                ],
                [
                    'label' => 'Статус',
                    'attribute'=>'status',
                    'value' => 'status',
                ],
                [
                    'filter' => [
                        '' => 'Все',
                        0 => 0,
                        1 => 1,
                    ],
                    'label' => 'Актив',
                    'attribute'=>'active',
                    'value' => 'active',
                    'visible' => Yii::$app->user->can('admin_access')
                ],
                (Yii::$app->user->can('content_access')) ? [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, Item $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
                ] :[
                    'class' => ActionColumn::className(),
                    'template' => '{view}',
                    'urlCreator' => function ($action, Item $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
                ],
            ],
        ]);

        echo Html::a('Добавить/Удалить предмет', ['add-delete-items', 'collectionId'=>$model->id], [
            'id' => 'btn-multi-view',
            'class' => 'btn btn-success',
            'data' => [
                'method' => 'post',
                'params' => [
                    'items' => $items,
                ]
            ],

        ]);
        ?>
    </div>
</div>
<!--<div class="collection-item-update">-->
<!---->
<!---->
<!--    --><?//= $this->render('_form_update', [
//        'collNumber' => $collNumbers,
//        'model' => $model,
//        ]) ?>
<!---->
<!--</div>-->
