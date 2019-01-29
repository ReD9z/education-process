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
        $("#users-form").on("pjax:end", function() {
            $.pjax.reload({container:"#users-list"}); 
        });
    });'
);
?>


<div class="users-search">
    <?php Pjax::begin(['id' => 'users-form']) ?>
        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'options' => ['data-pjax' => true],
        ]); ?>

        <?= $form->field($model, 'globalSearch')->textInput(['placeholder'=>'Поиск'])->label(false) ?>

        <?php ActiveForm::end(); ?>
    <?php Pjax::end() ?>
</div>
