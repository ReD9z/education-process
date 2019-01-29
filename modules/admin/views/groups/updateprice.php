<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\Journals */

$this->title = 'Обновить';
$this->params['breadcrumbs'][] = 'Обновить оплату за обучение: ' . $model->students->users->username;
?>
<div class="journals-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'status')->dropDownList(['1' => 'Бюджетник', '2' => 'Оплатил', '3' => 'Не оплатил'])->label(false)?>

    <?= $form->field($model, 'date')->hiddenInput(['value' => $model->date])->label(false)  ?>

    <div class="form-group">
        <?= Html::submitButton('Обновить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
