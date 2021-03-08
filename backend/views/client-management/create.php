<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ClientManagement */

$this->title = 'Client Management';
$this->params['breadcrumbs'][] = ['label' => 'Client Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class=" ">

<div class="apps-management-create">

<div class="box-body no-pad">
     <div class="box box-primary  ">
    	<div class="box-header with-border box-header-bg">
         <h3 class="box-title pull-left"> <i class="fa fa-fw fa-plus-square"></i> <?= Html::encode($this->title) ?></h3>
        </div>
     </div>
    <?= $this->render('_form', [
        'model' => $model,
        'applist'=>$applist,
        //'model1'=>$model1,
    ]) ?>

</div>
</div>
</div>
