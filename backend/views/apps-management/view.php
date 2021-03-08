<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AppsManagement */

/*$this->title = $model->auto_id;*/
$this->params['breadcrumbs'][] = ['label' => 'Apps Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apps-management-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           /* 'auto_id',*/
            /*'apps_logo',*/
            'apps_name',
            'apps_description',
            [
                'attribute' =>   'apps_logo',
                'value'=>$model->apps_logo,           
               'format' => ['image',['width'=>'80']],
            ],
             'company_name',
            [
               'attribute' =>   'company_logo',
               'value'=>$model->company_logo,           
               'format' => ['image',['width'=>'80']],
            ],
        ],
    ]) ?>

</div>


