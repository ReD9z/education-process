<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\Chair */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chair-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'institute_id')->dropDownList(ArrayHelper::map(\app\models\Institute::find()->all(),'id','full_name'))?>

    <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'small_name')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Удалить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
