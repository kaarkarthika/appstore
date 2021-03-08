<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AppsManagementSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="apps-management-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'auto_id') ?>

    <?= $form->field($model, 'apps_logo') ?>

    <?= $form->field($model, 'apps_name') ?>

    <?= $form->field($model, 'apps_description') ?>

    <?= $form->field($model, 'company_logo') ?>

    <?= $form->field($model, 'company_name') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
