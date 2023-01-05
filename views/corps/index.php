<?php

use app\models\Corps;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\CorpsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\Corps $model */

$this->title = 'Выберите корпус';
$this->params['breadcrumbs'][] = $this->title;
//var_dump($searchModel->id);
//die;
?>
<div class="corps-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Corps', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'id',
            'corps',
            [
                'label' => 'Ссылка',
                'format' => 'raw',
                'value' => function($data) use ($model) {
                    return Html::a(
                        'Перейти',
                        Url::to(['corps/view', 'id' => $model->id ]),
                        [
                            'data' => ['method' => 'post'],
//                            'title' => 'Смелей вперед!',
                            'target' => '_blank'
                        ]
                    );
                }
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{update} {delete}',
                'urlCreator' => function ($action, Corps $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
