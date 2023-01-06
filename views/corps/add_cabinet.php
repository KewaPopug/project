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
            'corps',
            [
                'format' => 'raw',
                'value' => function(Corps $model) {
                    return Html::a(
                        'Выбрать корпус',
                        ['view', 'id'=>$model->id],
                        [
                            'name' => 'signup-button',

                            'data' =>
                                [
                                    'method' => 'post',
                                ],
                        ]);
                }
            ],
        ],
    ]); ?>


</div>
