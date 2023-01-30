<?php

use app\models\Item;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\ButtonDropdown;
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
$script = "
        function forDelete(){
            var keyList = $('#grid').yiiGridView('getSelectedRows');
            if(keyList != '') {
                $('#btn-multi-del').attr('data-params', JSON.stringify({keyList}));
            } else {
                $('#btn-multi-del').removeAttr('data-params');
            }
        };
        function forRestore(){
            var keyList = $('#grid').yiiGridView('getSelectedRows');
            if(keyList != '') {
                $('#btn-multi-restore').attr('data-params', JSON.stringify({keyList}));
            } else {
                $('#btn-multi-restore').removeAttr('data-params');
            }
        };
        function forTransfer(){
            var keyList = $('#grid').yiiGridView('getSelectedRows');
            if(keyList != '') {
                $('#btn-multi-transfer').attr('data-params', JSON.stringify({keyList}));
            } else {
                $('#btn-multi-transfer').removeAttr('data-params');
            }
        };
        function forUpdateCorpsCabinet(){
            var keyList = $('#grid').yiiGridView('getSelectedRows');
            if(keyList != '') {
                $('#btn-multi-update-corps-cabinet').attr('data-params', JSON.stringify({keyList}));
            } else {
                $('#btn-multi-update-corps-cabinet').removeAttr('data-params');
            }
        };
        function forUpdateCategory(){
            var keyList = $('#grid').yiiGridView('getSelectedRows');
            if(keyList != '') {
                $('#btn-multi-update-category').attr('data-params', JSON.stringify({keyList}));
            } else {
                $('#btn-multi-update-category').removeAttr('data-params');
            }
        };
        function forUpdateStatus(){
            var keyList = $('#grid').yiiGridView('getSelectedRows');
            if(keyList != '') {
                $('#btn-multi-update-status').attr('data-params', JSON.stringify({keyList}));
            } else {
                $('#btn-multi-update-status').removeAttr('data-params');
            }
        };";

$this->registerJs($script, yii\web\View::POS_BEGIN);
?>

<div class="item-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php \yii\widgets\Pjax::begin(); ?>

    <?= GridView::widget([
        'id' => 'grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
//        'pagination' => 10,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
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
            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    return ['form'=>'delete-multi','value' => $key, 'checked' => 'checked'];
                }

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

    \yii\widgets\Pjax::end();

    echo Html::a('Удалить выбранные', ['item/multi-delete'], [
        'id' => 'btn-multi-del',
        'class' => 'btn btn-light',
        'onclick' => 'forDelete()',
        'data' => [
            'method' => 'post'
        ]
    ]);

    echo Html::a('Восстановить выбранные', ['item/multi-restore'], [
        'id' => 'btn-multi-restore',
        'class' => 'btn btn-light',
        'onclick' => 'forRestore()',
        'data' => [
            'method' => 'post'
        ]
    ]);

    echo Html::a('Сменить материальноответственного', ['item/transfer-item-multi'], [
        'id' => 'btn-multi-transfer',
        'class' => 'btn btn-light',
        'onclick' => 'forTransfer()',
        'data' => [
            'method' => 'post'
        ]
    ]);

    echo Html::a('Сменить корпус/кабинет', ['item/multi-update-corps-cabinet'], [
        'id' => 'btn-multi-update-corps-cabinet',
        'class' => 'btn btn-light',
        'onclick' => 'forUpdateCorpsCabinet()',
        'data' => [
            'method' => 'post'
        ]
    ]);

    echo Html::a('Сменить категорию', ['item/multi-update-category'], [
        'id' => 'btn-multi-update-category',
        'class' => 'btn btn-light',
        'onclick' => 'forUpdateCategory()',
        'data' => [
            'method' => 'post'
        ]
    ]);

    echo Html::a('Сменить Статус', ['item/multi-update-status'], [
        'id' => 'btn-multi-update-status',
        'class' => 'btn btn-light',
        'onclick' => 'forUpdateStatus()',
        'data' => [
            'method' => 'post'
        ]
    ]);

//
//    echo Html::a('Сменить имя', ['multi-update-name'], [
//        'id' => 'btn-multi-update-corps',
//        'class' => 'btn btn-light',
//        'onclick' => 'forTransfer()',
//        'data' => [
//            'method' => 'post'
//        ]
//    ]);




//    echo ButtonDropdown::widget([
//        'label' => 'Поменять',
//        'dropdown' => [
//            'items' => [
//                ['label' => 'Кабинет', 'url' => '/'],
//                ['label' => 'Корпус', 'url' => '/'],
//                ['label' => 'Категорию', 'url' => '/'],
//                ['label' => 'Статус', 'url' => '/'],
//                ['label' => 'Имя', 'url' => '/'],
//            ],
//        ],
//    ]);
    ?>
</div>