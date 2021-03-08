<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AppsManagement */

$this->title = 'Update Apps';
$this->params['breadcrumbs'][] = ['label' => 'Apps Managements', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->auto_id, 'url' => ['view', 'id' => $model->auto_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="apps-management-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
