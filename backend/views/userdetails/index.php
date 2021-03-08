<?php


use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductSolutionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'User Details';
?>

<div class="partner-solution-index">
 <div class="box-body">
    <div class="box box-primary cgridoverlap">
        <div class="">
        </div> <br><p>
     <?= Html::a('<i class="fa fa-plus"></i> Add User', ['create'], ['class' => 'btn btn-success btn-md pull-left']) ?>
    </p><br><div class="box-body">
    
       <?php Pjax::begin(); ?>
          <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'first_name',
            'last_name',
            //'dob',
            // 'email:email',
            // 'city',
            // 'status',
            // 'created_at',
            // 'updated_at',
            // 'rights:ntext',

             ['class' => 'yii\grid\ActionColumn',
                           'header'=> 'Action',
        'headerOptions' => ['style' => 'width:150px;color:#337ab7;'],
               'template'=>'{view1}{update}{delete}',
                            'buttons'=>[
                              'view1' => function ($url, $model, $key) {
                               
                                   // return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
                                   return Html::button('<i class="glyphicon glyphicon-eye-open"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-primary btn-xs view view gridbtncustom modalView', 'data-toggle'=>'tooltip', 'title' =>'View' ]);
                                }, 
                             'update' => function ($url, $model, $key) {
                                        $options = array_merge([
                                            'class' => 'btn btn-warning btn-xs update gridbtncustom',
                                            'data-toggle'=>'tooltip',
                                            'title' => Yii::t('yii', 'Update'),
                                            'aria-label' => Yii::t('yii', 'Update'),
                                            'data-pjax' => '0',
                                        ]);
                                        return Html::a('<span class="fa fa-edit"></span>', $url, $options);
                                    },
                              
                                'delete' => function ($url, $model, $key) {
                                    $user_type=$model->user_type;
                                     if($user_type!=='A'){
                                        return Html::button('<i class="fa fa-trash"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-danger btn-xs delete gridbtncustom modalDelete', 'data-toggle'=>'tooltip', 'title' =>'Delete' ]);
                                    }
                                  },
                          ] ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
   </div>
  </div>
 </div>
</div>
<script type="text/javascript">
     $('body').on("click",".modalView",function(){
            
             var url = $(this).attr('value');
             $('#operationalheader').html('<span> <i class="fa fa-fw fa-th-large"></i>View User</span>');
             $('#operationalmodal').modal('show').find('#modalContenttwo').load(url);
             return false;
         });
</script>

