<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ClientManagement */

$this->title = 'Update Client';
$this->params['breadcrumbs'][] = ['label' => 'Client Managements', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->auto_id, 'url' => ['view', 'id' => $model->auto_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="client-management-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'applist'=>$applist,
        'model1'=>$model1,
    ]) ?>

</div>
