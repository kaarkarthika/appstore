<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\UploadApp */

$this->title = 'Upload App';
$this->params['breadcrumbs'][] = ['label' => 'Upload Apps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="upload-app-create">
<div class="box box-primary  ">
	  <div class=" ">
   
    	<div class=" box-header with-border box-header-bg">
	      <h3 class="box-title "><i class="fa fa-fw fa-plus-square"></i><?= Html::encode($this->title) ?></h3>
</div>
</div>
</div>
    <?= $this->render('_form', [
        'model' => $model,
        'applist'=>$applist,
    ]) ?>


</div>
