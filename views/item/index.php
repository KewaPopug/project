<?php

use app\models\Item;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ItemSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Items';
$this->params['breadcrumbs'][] = $this->title;
$dataProvider->sort = false;
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
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'id',
//            [
//                    'attribute' => 'category',
//                    'filter' => \app\models\Category::find()->select(['category'])->indexBy('id')->column(),
//                    'value' => 'category.category'
//            ],
            'category.category',
            'user.profile.position',
            'user.profile.number',
            'user.profile.second_name',
            'status',
            'name_item',
            'cabinet.cabinet',
            'cabinet.corps.corps',
            'number',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Item $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
