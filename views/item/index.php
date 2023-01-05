<?php

use app\models\Item;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ItemSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\Category $categories */

$this->title = 'Инвентаризация';
$this->params['breadcrumbs'][] = $this->title;
//$dataProvider->sort = false;

//var_dump(\yii\helpers\ArrayHelper::map($categories, 'id','category'));
//die;
?>

<div class="item-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->can('content_access')):?>
    <p>
        <?= Html::a('Create Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif; ?>

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'id',
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
    ]); ?>
</div>
