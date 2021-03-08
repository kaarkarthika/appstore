<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use backend\models\AppsManagement;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UploadAppSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Upload Apps';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="upload-app-index">
<div class="box box-primary  ">
    <div class=" ">
   
      <div class=" box-header with-border box-header-bg">
          <h3 class="box-title "><?= Html::encode($this->title) ?></h3><br><br>
          <?= Html::a('Add App', ['create'], ['class' => 'btn btn-success pull-left']) ?>
  </div>
  </div>
  
  <div class="table-responsive">
  
  <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
           'attribute' => 'appsname',
               'filter' => Html::activeDropDownList($searchModel, 'appsname', ArrayHelper::map(AppsManagement::find()->asArray()->all(), 'auto_id', 'apps_name'),['class'=>'form-control','prompt' => 'Search Apps']),
                ],
                   'app_description',
              [
               'attribute' => 'upload_apk',
               //'label' => 'Partner Name',
                   'format' => 'raw',
              // 'headerOptions' => ['class' => 'actionPartnername'],
               'value' => function ($data) {
                   $options = array_merge([
                                            'class' => 'btn btn-warning btn-xs update gridbtncustom',
                                            'data-toggle'=>'tooltip',
                                            'title' => Yii::t('yii', 'upload_apk'),
                                            'aria-label' => Yii::t('yii', 'upload_apk'),
                                            'data-pjax' => '0',
                                        ]);
                   $url=Url::base().'/'.$data->upload_apk; 
                                        return Html::a('<span class="fa fa-download">Apk</span>', $url, $options);


                       }
           ],
                    [
               'attribute' => 'create_date',
                'label'=>'Create Date',
               'headerOptions' =>['style'=>'color:#ff0000;'],
               'value' => function($model, $key, $index){
                     
                    if($model->create_date!='0000-00-00 00:00:00' && $model->create_date!='')
                    {
                        
                        return  date("d-m-Y ",strtotime($model->create_date));
                        //return  ucwords(date("d-m-Y",strtotime($model->created_at)));
                    }else{
                        return "-";
                    }
           },
         ],
                 [
                      'attribute' => 'update_date',
                'label'=>'update Date',
               'headerOptions' =>['style'=>'color:#ff0000;'],
               'value' => function($model, $key, $index){
                     
                    if($model->update_date!='0000-00-00 00:00:00' && $model->update_date!='')
                    {
                        
                        return  date("d-m-Y ",strtotime($model->update_date));
                        //return  ucwords(date("d-m-Y",strtotime($model->created_at)));
                    }else{
                        return "-";
                    }
           },
         ],
                    
           ['class' => 'yii\grid\ActionColumn',
                           'header'=> 'Action',
        'headerOptions' => ['style' => 'width:150px;color:#337ab7;'],

               'template'=>'{view}{update}{delete}',
                            'buttons'=>[
                              'view' => function ($url, $model, $key) {
                               
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
                            $current_date= date('Y-m-d h:i:s');
                            $date_check =$model->update_date;
                            $next_due_date = date('Y-m-d h:i:s', strtotime($date_check. ' +5 days'));
                                if($current_date > $next_due_date){
                                   $disabled =true;
                                        return Html::button('<i class="fa fa-trash"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-danger btn-xs delete gridbtncustom modalDelete', 'data-toggle'=>'tooltip', 'title' =>'Delete','disabled'=>$disabled]);
                                      }else{
                                         $disabled =false;
                                          return Html::button('<i class="fa fa-trash"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-danger btn-xs delete gridbtncustom modalDelete', 'data-toggle'=>'tooltip', 'title' =>'Delete','disabled'=>$disabled]);
                                      }
                                  },
                          ] ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div></div></div>

<script type="text/javascript">
     $('body').on("click",".modalView",function(){
            
             var url = $(this).attr('value');
             $('#operationalheader').html('<span> <i class="fa fa-fw fa-th-large"></i>View Apps</span>');
             $('#operationalmodal').modal('show').find('#modalContenttwo').load(url);
             return false;
         });
</script>











