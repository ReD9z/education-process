<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Qualification */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Направление обучения', 'url' => ['/admin/direction']];
$this->params['breadcrumbs'][] = ['label' => 'Квалификация обучения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qualification-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
