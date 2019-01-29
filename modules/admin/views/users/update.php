<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Обновить : ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="users-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить пароль', ['/admin/users/password', 'id' => $model->id], ['class' => 'btn btn-success btn-sm']) ?>
        <?= Html::a('Изменить аватар', ['/admin/users/image', 'id' => $model->id], ['class' => 'btn btn-success btn-sm']) ?>
    </p>

  	<?php $form = ActiveForm::begin(); ?>

	    <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>

	    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

	    <?= $form->field($model, 'role_id')->dropDownList(ArrayHelper::map(\app\models\Role::find()->all(),'id','name')) ?>

	    <?= $form->field($profile, 'address')->textInput(['maxlength' => true]) ?>

	    <?= $form->field($profile, 'email')->textInput(['maxlength' => true]) ?>

	    <?= $form->field($profile, 'phone')->textInput(['maxlength' => true]) ?>
	  
	    <div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

    <?php ActiveForm::end(); ?>
</div>
