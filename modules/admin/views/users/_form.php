<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use nex\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'role_id')->dropDownList(ArrayHelper::map(\app\models\Role::find()->all(),'id','name')) ?>

    <?= $form->field($model, 'date')->widget(
        DatePicker::className(), [
        'language' => 'ru',
        'name' => 'DateTimePicker',
        'clientOptions' => [
            'format' => 'L LT',
        ],
    ]); 
    ?>
    <?= $form->field($profile, 'address')->textInput(['maxlength' => true]) ?>
    <?= $form->field($profile, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($profile, 'phone')->textInput(['maxlength' => true]) ?>
    <?= $form->field($profile, 'image')->fileInput(['maxlength' => true]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
