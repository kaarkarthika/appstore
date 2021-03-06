<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ApiVersion */

$this->title = 'Create Api Version';
$this->params['breadcrumbs'][] = ['label' => 'Api Versions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="api-version-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
