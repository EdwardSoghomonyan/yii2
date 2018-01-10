<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Orders */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
    $this->registerAssetBundle(\yii\web\JqueryAsset::className(), \yii\web\View::POS_HEAD);
    $this->registerJsFile('js/main/order_form.js', ['position' => \yii\web\View::POS_END]);
?>
<div class="orders-form">
    <?php
        $form = ActiveForm::begin([
            'action' => isset($models) ? 'index.php?r=orders/update&id=' . $models[0]->order_id : 'index.php?r=orders/store'
        ]);
    ?>
    <div class="row labels_form">

        <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label">Price</label>
        <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label">Description </label>
        <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label">Available </label>
        <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label">Actions</label>
    </div>
    <div class="row main_form">
        <?php if(isset($models)):
            foreach ($models as $key => $model): ?>
            <div class="row order-row" data-index="<?= $key ?>">
                <div class="row element_form">
                    <input type="hidden" class="removed_orders" name="removed_orders" value="">
                    <?=
                        $form->field($model, '['.$model->id.']id')
                            ->hiddenInput(['value' => $model->id, 'label' => '', 'class' => 'id'])
                            ->label(false)
                    ?>
                    <?=
                        $form->field($model, '['.$model->id.']order_id')
                            ->hiddenInput(['value' => $model->order_id, 'label' => '', 'class' => 'order_id'])
                            ->label(false)
                    ?>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <?=
                        $form->field($model, '['.$model->id.']price')
                            ->textInput(['class' => 'price form-control', 'label' => ''])
                            ->label(false)
                    ?>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <?=
                        $form->field($model, '['.$model->id.']description')
                            ->textInput(['maxlength' => true, 'class' => 'description form-control', 'label' => ''])
                            ->label(false)
                    ?>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <?=
                        $form->field($model, '['.$model->id.']available')
                            ->checkbox(['class' => 'available', 'label' => ''])
                    ?>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <div class="form-group">
                        <?php if(count($models) > $key + 1): ?>
                            <button type="button" class="remove_row">-</button>
                        <?php else: ?>
                            <button type="button" class="add_row">+</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach;
        else: ?>
            <div class="row order-row" data-index=" ">
                <div class="row">
                    <?=
                        $form->field($model, '[0]order_id')
                            ->hiddenInput(['value' => time(), 'label' => '', 'class' => 'order_id'])
                            ->label(false)
                    ?>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <?=
                        $form->field($model, '[0]price')
                            ->textInput(['class' => 'price form-control', 'label' => ''])
                            ->label(false)
                    ?>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <?=
                        $form->field($model, '[0]description')
                            ->textInput(['maxlength' => true, 'class' => 'description form-control', 'label' => ''])
                            ->label(false)
                    ?>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <?=
                        $form->field($model, '[0]available')
                            ->checkbox(['class' => 'available', 'label' => ''])
                    ?>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <div class="form-group">
                        <button type="button" class="add_row">+</button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="form-group">
        <?= Html::a('Back', ['/'], ['class' => 'btn btn-primary']) ?>
        <?= isset($models) ?
            Html::submitButton('Update', ['class' => 'btn btn-primary']) :
            Html::submitButton('Create', ['class' => 'btn btn-success'])
        ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
