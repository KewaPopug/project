<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Item $model */
/** @var app\models\HistorySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="item-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php if($model->active == '0'):?>
        <?= Html::a('Восстановить', ['restore', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php endif?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
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
            [
                'label' => 'Номер предмета',
                'attribute'=>'number_item',
                'value' => function($data){
                    return $data->number_item;
                },
            ],
            [
                'label' => 'Имя',
                'attribute'=>'name_item',
                'value' => function($data){
                    return $data->name_item;
                },
            ],
            [
                'label' => 'Кабинет',
                'attribute'=>'cabinet',
                'value' => function($data){
                    return $data->cabinet->cabinet . '( корпус: '.$data->cabinet->corps->corps.')';
                },
            ],
            [
                'label' => 'Категория',
                'attribute'=>'category',
                'value' => function($data){
                    return $data->category->category;
                },
            ],
            [
                'label' => 'Статус',
                'attribute'=>'status',
                'value' => function($data){
                    return $data->status;
                },
            ],
            [
                'label' => 'Имя',
                'attribute'=>'first_name',
                'value' => function($data){
                    return $data->user->profile->first_name;
                },
            ],
            [
               'label' => 'Фамилия',
                'attribute'=>'profile',
                'value' => function($data){
                    return $data->user->profile->second_name;
                },
            ],
            [
                'label' => 'Должность',
                'attribute'=>'position',
                'value' => function($data){
                    return $data->user->profile->position;
                },
            ],
            [
                'label' => 'Почта',
                'attribute'=>'email',
                'value' => function($data){
                    return $data->user->email;
                },
            ],
            [
                'label' => 'Номер',
                'attribute'=>'status',
                'value' => function($data){
                    return $data->user->profile->number;
                },
            ],
        ],
    ]) ?>
    <br />
    <br />
    <h2>История изменений</h2>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'id',
            [
                'label' => 'Номер',
                'attribute'=>'item',
                'value' => 'item.number_item',
            ],
            [
                'label' => 'Имя изменившего',
                'attribute'=>'profile',
                'value' => 'profile.second_name',
            ],
            'title:text:Изменение',
            'description:text:Описание',
            'date:datetime:Дата и время',
        ],
    ]); ?>
</div>
