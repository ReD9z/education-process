<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\Timetable */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="timetable-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'plan_id')->dropDownList($arrPlan, [
            'prompt' => '',
            'onchange' => '
                $.post("/admin/timetable/list?id='.'"+$(this).val(), function(data) {
                    $("select#timetable-training_choice_id").html(data);
                });
                $.post("/admin/timetable/users?id='.'"+$(this).val(), function(data) {
                    $("select#timetable-users_id").html(data);
                });',

        ])?>

        <?= $form->field($model, 'users_id')->dropDownList($arrUsers, ['prompt' => '']) ?>

        <?= $form->field($model, 'training_choice_id')->dropDownList($arrChoice, ['prompt' => '']) ?>

        <?= $form->field($model, 'couple_id')->dropDownList(ArrayHelper::map(\app\models\Couple::find()->all(),'id','name'))  ?>

        <?= $form->field($institutes, 'id')->dropDownList($instituteArr, [ 
            'prompt' => '',
            'onchange' => '
                $.post("/admin/timetable/audiences?id='.'"+$(this).val(), function(data) {
                    $("select#timetable-audiences_id").html(data);
                });
            ',
        ])?>

        <?= $form->field($model, 'audiences_id')->dropDownList($arrAudiences, ['prompt' => ''])  ?>

        <?= $form->field($model, 'date')->textInput();?>
      
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
