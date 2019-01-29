<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\UsersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<?
$this->registerJs(
   '$("document").ready(function(){ 
        $("#teacher-form").on("pjax:end", function() {
            $.pjax.reload({container:"#teacher-list"}); 
        });
    });'
);
?>


<div class="teacher-search">
    <?php Pjax::begin(['id' => 'teacher-form']) ?>
        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'options' => ['data-pjax' => true],
        ]); ?>

        <?= $form->field($model, 'globalSearch')->textInput(['placeholder' => 'Поиск'])->label(false) ?>

        <?php ActiveForm::end(); ?>
    <?php Pjax::end() ?>
</div>