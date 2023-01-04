<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $model app\modules\adminPanel\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$controllerId = $this->context->uniqueId . '/';


//var_dump(function ($data){
//    return $data->profile->second_name;
//});

?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if ($model->status == 0 && Helper::checkRoute($controllerId . 'activate')) {
            echo Html::a(Yii::t('rbac-admin', 'Activate'), ['activate', 'id' => $model->id], [
                'class' => 'btn btn-primary',
                'data' => [
                    'confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                    'method' => 'post',
                ],
            ]);
        }
        ?>
        <?php
        if (Helper::checkRoute($controllerId . 'delete')) {
            echo Html::a(Yii::t('rbac-admin', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]);
        }
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
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
                'attribute'=>'secondname',
                'value' => 'profile.second_name',
            ],
            [
                'label' => 'Должность',
                'attribute'=>'position',
                'value' => function($data){
                    return $data->profile->position;
                },
            ],
            [
                'label' => 'Почта',
                'attribute'=>'email:email',
                'value' => function($data){
                    return $data->email;
                },
            ],
            [
                'label' => 'Номер',
                'attribute'=>'status',
                'value' => function($data){
                    return $data->profile->number;
                },
            ],
            'created_at:date',
            'status',
        ],
    ])
    ?>

    <div style="color:#999;margin:1em 0">
        <?= Html::a('Восстановить пароль', ['request-password-reset', 'id'=>$model->id], ['class' => 'btn btn-primary', 'name' => 'signup-button',
            'data' => [
                'method' => 'post',
            ],
        ]) ?>.
    </div>
    <?php if(ArrayHelper::getValue(Yii::$app->authManager->getAssignments($model->id), 'content') || ArrayHelper::getValue(Yii::$app->authManager->getAssignments($model->id), 'admin')):?>
    <div style="color:#999;margin:1em 0">
        <?= Html::a(
                'Переназначить материально ответственного',
                ['transfer-item', 'id'=>$model->id],
                [
                    'class' => 'btn btn-primary',
                    'name' => 'signup-button',

                    'data' =>
                    [
                        'confirm' => 'Помните, если вы переназначаете пользователя все предметы материальной ценности переносятся на перезначаемого. Процесс не обратимый.',
                        'method' => 'post',
                    ],
        ]) ?>.
    </div>
    <?php endif;?>
</div>
