<?php

use app\models\Item;
use yii\bootstrap5\ActiveForm;
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
        function forView(){
            var keyList = $('#grid').yiiGridView('getSelectedRows');
            if(keyList != '') {
                $('#btn-multi-del').attr('data-params', JSON.stringify({keyList}));
            } else {
                $('#btn-multi-del').removeAttr('data-params');
            }
        };";
$js = <<<JS

jQuery(document).on("pjax:start", function(){
    var selectionStorage = $(document).data('selectionStorage') || {};
    jQuery("tbody input[type='checkbox']").each(function(){
        this.checked ? selectionStorage[this.value] = true : delete selectionStorage[this.value];
    });
    jQuery(document).data('selectionStorage', selectionStorage);
});

jQuery(document).on("pjax:end", function() {
    var selectionStorage = $(document).data('selectionStorage') || {};
    for(var prop in selectionStorage) if (selectionStorage.hasOwnProperty(prop)) {
       jQuery('tbody input[type="checkbox"][value="' + prop + '"]').prop('checked', 'checked');
    }
});

JS;
$this->registerJs($js);
$this->registerJs($script, yii\web\View::POS_BEGIN);
?>
<div class="item-index">


    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->can('content_access')):?>
    <p>
        <?= Html::a('Create Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif; ?>

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php \yii\widgets\Pjax::begin() ?>

    <?= GridView::widget([
        'id' => 'grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
                    return ['form'=>'delete-multi','value' => $key];
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
    echo Html::a('Выбрать отмеченные', ['multi-view'], [
        'id' => 'btn-multi-del',
        'class' => 'btn btn-light',
        'onclick' => 'forView()',
        'data-pjax' => 0,
        'data' => [
            'method' => 'post'
        ]
    ]);
    ?>

</div>
