<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Orders */
?>
<div class="orders-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', ['models' => $models]) ?>

</div>
