<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Timetable */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Timetables', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

	<div class="timetable-create">

	    <h1><?= Html::encode($this->title) ?></h1>

	    <?= $this->render('_form', [
	        'model' => $model,
	        'arrPlan' => $arrPlan,
	        'arrChoice' => $arrChoice,
	        'instituteArr' => $instituteArr,
            'institutes' => $institutes,
            'arrAudiences' => $arrAudiences,
	        'arrUsers' => $arrUsers,
	    ]) ?>
	</div>