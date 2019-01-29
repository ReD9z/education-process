<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ListView;

$this->title = 'Профиль';
?>

<div class="col-md-7">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Отзывы</h3>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'status')->dropDownList($model->message())->label(false) ?>
                <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Заголовок'])->label(false) ?>
                <?= $form->field($model, 'text')->textarea(['rows' => 2, 'placeholder' => 'Отзыв'])->label(false) ?>
                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <?= ListView::widget([
            'dataProvider' => $messages,
            'summary' => false,
            'options' => false,
            'itemOptions' => false,
            'emptyText' => '<div class="list-group-item">Отзывы отсутствуют!</div>',
            'itemView' => function ($model, $key, $index, $widget) {
                return $model->messages($model);
            },
        ]) 
    ?>
</div>

<div class="col-md-5">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Профиль</h3>
        </div>
        <div class="panel-body">
            <?= ListView::widget([
                    'dataProvider' => $profile,
                    'summary' => false,
                    'options' => false,
                    'itemOptions' => ['class' => 'thumbnail'],
                    'itemView' => function ($model, $key, $index, $widget) {
                        return $model->profileGet($model);
                    },
                ]) 
            ?>
        </div>
    </div>
</div>
