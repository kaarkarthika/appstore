<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\UploadApp */

//$this->title = $model->auto_id;
$this->params['breadcrumbs'][] = ['label' => 'Upload Apps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="upload-app-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          /*  'auto_id',*/
           'apps_name',
          'app_description',
            'upload_apk',

        ],
    ]) ?>

</div>
