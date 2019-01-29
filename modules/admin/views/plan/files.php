<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $model app\models\Files */
/* @var $form ActiveForm */
$this->title = 'Добавить файл';
$this->params['breadcrumbs'][] = ['label' => 'Учебный план', 'url' => ['/admin/plan']];
$this->params['breadcrumbs'][] = ['label' => 'Добавить файл'];
?>
<div class="files">

    <?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'name') ?>
    	<?= $form->field($model, 'path')->fileInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- files -->
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => false,
    'options' => ['class' => 'table table-responsive'],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
    	  	[
            	'attribute'=>'path',
            	'format' => 'html',
	            'content' => function($data){
	                return Html::a($data->name, ['/uploads/files/'.$data->path], ['title' => $data->name]);
	            }
	        ],
        [
        'class' => 'yii\grid\ActionColumn',
     	'template' => '{del}',
            'buttons' => [
                'del' => function ($url, $dataProvider) {
                    return Html::a(
                    '<span class="glyphicon glyphicon-remove"></span>',
                    [$url = Url::to(['/admin/plan/del','id' => $dataProvider->id, 'training' => $dataProvider->training_choice_id, 'plan' => $dataProvider->plan_id])],
                    [
                        'data' => [
                            'confirm' => 'Вы уверены, что хотите удалить файл?',
                            'method' => 'post',
                        ],
                    ]);
                },
            ],
        ],
    ],
]); 
?>
