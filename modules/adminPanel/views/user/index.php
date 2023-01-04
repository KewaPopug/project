<?php

use yii\helpers\Html;
use yii\grid\GridView;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\adminPanel\models\searchs\User */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('rbac-admin', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            [
                'label' => 'Имя',
                'attribute'=>'first_name',
                'value' => function($data){
                    return $data->profile->first_name;
                },
            ],
            [
                'label' => 'Фамилия',
                'attribute'=>'second_name',
                'value' => function($data){
                    return $data->profile->second_name;
                },
            ],
            [
                'label' => 'Должность',
                'attribute'=>'position',
                'value' => function($data){
                    return $data->profile->position;
                },
            ],
            [
                'label' => 'Номер',
                'attribute'=>'status',
                'value' => function($data){
                    return $data->profile->number;
                },
            ],
            'email:email',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->status == 0 ? 'Inactive' : 'Active';
                },
                'filter' => [
                    0 => 'Inactive',
                    10 => 'Active'
                ]
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}',
                ],
            ],
        ]);
        ?>
</div>
