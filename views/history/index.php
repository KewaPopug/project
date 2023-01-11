<?php

use app\models\History;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\HistorySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'История изменений';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="history-index">

    <h1><?= Html::encode($this->title) ?></h1>

<!--    <p>-->
<!--        --><?php //= Html::a('Create Corps', ['create'], ['class' => 'btn btn-success']) ?>
<!--    </p>-->

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
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, History $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
