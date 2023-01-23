<?php

use app\models\Item;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
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
$js = <<<JS
var a = [];
var b = [];
var c = [];

jQuery(document).on("pjax:start", function(){
    var selectionStorage = $(document).data('selectionStorage') || {};
    var keyList = $('#grid').yiiGridView('getSelectedRows');
    a.push(keyList);
    // console.log(a);
    for (var i=0;i<a.length;i++){
      for (number in a[i]){
          // console.log(b.find((el) => number))
          b.push(a[i][number]);
          // console.log(i)
        // if(!b.filter(a[i][number]))
        // console.log(a[i][number]);
        // }
      }
    }
    
    for(var j = 0; j < b.length; j++) {
        
        // if(c.find((el) => b[j])){
        if(c.includes(b[j])){
            console.log('Не попал');
        } else {
            console.log('Попал');
            c.push(b[j]);
            // c.push(b[j]);
        }
        // console.log(b[j])
    }
    console.log(c)
    // $('#btn-multi-view').attr('data-params', JSON.stringify({a}));
    // console.log(b)
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

$script = "
function forView(){
             var keyList = $('#grid').yiiGridView('getSelectedRows');
            if(keyList != '') {
                $('#btn-multi-view').attr('data-params', JSON.stringify({keyList}));
            } else {
                $('#btn-multi-view').removeAttr('data-params');
            }
        }
        ";

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
                    'format'=>'raw',
                    'value' => function($data){
                        return Html::a('Выбрать отмеченные', ['multi-change','id'=>$data->id], (array_search($data->id, Yii::$app->session->get('key'))) ? [
                            'id' => 'btn-multi-view',
                            'class' => 'btn btn-light',
                            'data' => [
                                'method' => 'post'
                            ]
                        ]: [
                            'id' => 'btn-multi-view',
                            'class' => 'btn btn-red',
                            'data' => [
                                'method' => 'post'
                            ]
                        ]);
                    }
            ],
            [
                'format'=>'raw',
                'value' => function($data){
                    var_dump(Yii::$app->session->get('key'));
                }
            ],
            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    if($model->active == 1)
                        $class = 'ticked';
                    else
                        $class = 'unticked';
                    return ['form'=>'delete-multi','value' => $key, 'class' => $class];
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

    var_dump(Yii::$app->session->get('key'));

    echo Html::a('Выбрать отмеченные', ['multi-view'], [
        'id' => 'btn-multi-view',
        'class' => 'btn btn-light',
        'onclick' => 'forView()',
        'data-pjax' => 0,
        'data' => [
            'method' => 'post'
        ]
    ]);
    ?>
</div>
