<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Direction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="direction-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'small_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'chair_id')->textInput()->dropDownList(ArrayHelper::map(\app\models\Chair::find()->all(),'id','full_name')) ?>

    <?= $form->field($model, 'study_id')->textInput()->dropDownList(ArrayHelper::map(\app\models\Study::find()->all(),'id','name')) ?>
    
    <?= $form->field($model, 'qualification_id')->textInput()->dropDownList(ArrayHelper::map(\app\models\Qualification::find()->all(),'id','name')) ?>

    <?= $form->field($model, 'period')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
