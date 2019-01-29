<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;
/* @var $this yii\web\View */
/* @var $model app\models\Journals */

$this->title = 'Обновить';
?>
<div class="journals-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= ListView::widget([
            'dataProvider' => $record,
            'summary' => false,
            'options' => false,
            'itemOptions' => false,
            'itemView' => function ($model, $key, $index, $widget) {
                echo $model->formAddEvaUp($model);
                echo $model->formAddVisitUp($model);
            },
        ]) 
    ?>

    <div class="form-group">
        <?= Html::submitButton('Обновить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>