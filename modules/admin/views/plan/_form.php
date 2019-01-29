<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\Plan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'discipline_id')->dropDownList(ArrayHelper::map(\app\models\Discipline::find()->all(),'id','name')) ?>

    <?= $form->field($model, 'direction_id')->dropDownList(ArrayHelper::map(\app\models\Direction::find()->all(),'id','full_name')) ?>

    <?= $form->field($model, 'time')->textInput() ?>

    <?= $form->field($model, 'course_id')->dropDownList(ArrayHelper::map(\app\models\Course::find()->all(),'id','name')) ?>

    <?= $form->field($model, 'semester_id')->dropDownList(ArrayHelper::map(\app\models\Semester::find()->all(),'id','name')) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
  
    <?php ActiveForm::end(); ?>

</div>
