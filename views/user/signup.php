<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap5\ActiveForm */
/* @var $model app\models\Signup*/
/* @var $modelProfile app\models\Profile*/
/* @var $modelDepartment app\models\Department*/
/* @var $departments app\models\Department*/


$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::errorSummary($model)?>
    <?= Html::errorSummary($modelProfile)?>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model, 'username')->label('Пользовательское имя') ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
                <?= $form->field($model, 'retypePassword')->passwordInput()->label('Повторный пароль') ?>
                <?= $form->field($modelProfile, 'first_name')->textInput(['maxlength' => true])->label('Имя') ?>
                <?= $form->field($modelProfile, 'middle_name')->textInput()->label('Отчество') ?>
                <?= $form->field($modelProfile, 'second_name')->textInput(['maxlength' => true])->label('Фамилия') ?>
                <?= $form->field($modelProfile, 'department_id')->dropDownList(\yii\helpers\ArrayHelper::map($departments, 'id', 'department_name'))->label('Департамент')?>
<!--            <?= $form->field($modelProfile, 'position')->textInput(['maxlength' => true])->label('Должность') ?>
                <?= $form->field($modelProfile, 'number')->textInput()->label('Контактный номер') ?>
                <?= Html::checkboxList('Content', false, ['Материально ответсвенный'])?>
                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
