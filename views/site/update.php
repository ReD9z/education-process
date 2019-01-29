<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $messages app\models\Messages */
/* @var $form ActiveForm */
?>
<div class="view-site-messages">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($messages, 'title') ?>
        <?= $form->field($messages, 'text')->textarea(['rows' => 5]) ?>
    
        <div class="form-group">
            <?= Html::submitButton('Обновить', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>