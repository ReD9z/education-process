<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
$this->title = 'Чат';
?>

<div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Чат</h3>
        </div>
        <div class="panel-body">
        	<div class="current-chat-area">
	        	<?= ListView::widget([
				        'dataProvider' => $chat,
				        'summary' => false,
				        'options' => ['class' => 'media-list'],
				        'itemOptions' => ['class' => 'media'],
				        'emptyText' => '<h4>Нет сообщений</h4>',
				        'itemView' => function ($model, $key, $index, $widget) {
				            return 
				            	$model->chatList($model)
				            ;
				        },
				    ]) 
				?>
			</div>
        </div>
        <div class="panel-footer">
    	  	<?php $form = ActiveForm::begin(); ?>
			<div class="input-group">
        		<?= $form->field($model, 'text', ['options' => ['class' => 'chat-input']])->textInput(['maxlength' => true, 'options' => ['class' => 'form-control']])->label(false) ?>
	           <span class="input-group-btn">
	                <?= Html::submitButton('Отправить', ['class' => 'btn btn-default']) ?>
     			</span>
	 		</div>
	 		<?php ActiveForm::end();?>
        </div>
    </div>
</div>
