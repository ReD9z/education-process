<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Button;


/* @var $this yii\web\View */
/* @var $model app\models\Journals */

$this->title = 'Оплата';
$this->params['breadcrumbs'][] = 'Оплата';
?>
<?php $form = ActiveForm::begin(); ?>
<table class="table table-striped table-bordered">
    <tr>
        <td>
            ФИО
        </td>
        <td>
            Статус оплаты
        </td>
    </tr>
    <?php foreach ($students as $students_value): ?>
        <tr>
            <td>
                <?=$students_value->users->username?>
                <?= $form->field($model, 'students_id[]')->hiddenInput(['value' => $students_value->id])->label(false) ?>
                <td>
                    <?= $form->field($model, 'status[]')->dropDownList(['1' => 'Бюджетник', '2' => 'Оплатил', '3' => 'Не оплатил'])->label(false)?>
                </td>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success'])?>
<?php ActiveForm::end(); ?>
