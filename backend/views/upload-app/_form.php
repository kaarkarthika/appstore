<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\UploadApp */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
  .checkbox input[type="checkbox"] {
   cursor: pointer;
   opacity: 0;
   z-index: 1;
   outline: none !important;
   }
   .checkbox-custom input[type="checkbox"]:checked + label::before {
   background-color: #5fbeaa;
   border-color: #5fbeaa;
   }
   .checkbox label::before {
   -o-transition: 0.3s ease-in-out;
   -webkit-transition: 0.3s ease-in-out;
   background-color: #ffffff;
   /* border-radius: 3px; */
   border: 1px solid #cccccc;
   content: "";
   display: inline-block;
   height: 17px;
   left: 0!important;
   margin-left: -20px!important;
   position: absolute;
   transition: 0.3s ease-in-out;
   width: 17px;
   outline: none !important;
   }
   .checkbox input[type="checkbox"]:checked + label::after {
   content: "\f00c";
   font-family: 'FontAwesome';
   color: #fff;
   position: relative;
   right: 59px;
   bottom: 1px;
   }
   .checkbox label {
   display: inline-block;
   padding-left: 5px;
   position: relative;
   }
</style>

<div id="page-content">
   <div class="">
      <div class="eq-height">
         <div class="panel">
            <div class="panel-body">
               <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
              <!-- <?php echo "<pre>"; print_r($model->auto_id); echo "</pre>"; ?>-->
               <input type="hidden" name="autoid" value="$model->auto_id">
               <div class="row">
                  <div class='col-sm-6 form-group' >
               <?php if($model->isNewRecord){ ?>
               <?php 
                  echo $form->field($model, 'upload_id')->dropDownList($applist,['prompt'=>'--Select App--','data-live-search'=>'true','class'=>'form-control selectpicker tabind','data-style'=>'btn-default btn-custom'])->label('Select App');?>
               <?php }else{ ?>
               <?php 
                  echo $form->field($model, 'upload_id')->dropDownList($applist,['prompt'=>'--Select App--','data-live-search'=>'true','class'=>'form-control selectpicker tabind','data-style'=>'btn-default btn-custom'])->label('Select App');?>
               <?php } ?>
            </div>
             <?php if($model->isNewRecord){ ?>
               	<div class='col-sm-6 form-group' >
                     <label class="control-label">APK</label>
                     <?= $form->field($model, 'upload_apk')->fileInput(['id'=> 'upload_apk','maxlength' => true,'placeholder'=>'APK','class'=>'form-control','required'=>true])->label(false) ?>
                      <?php
                  if($model->upload_apk!=""){
                   $base=Url::base(true);
                   $file=$base."/".$model->upload_apk;
                   ?>
                   <a href="<?php echo $file;?>"  class="fa fa-download"  style="color: #4CAF50 !important;"download>APK                   
                    <!--<img src="<?php// echo $file;?>" alt="APK" width="104" height="142">-->
                   </a>
                   <?php
                   }
                   else{

                 echo "No Records !!!";
                   }
                   
                     ?>

                      </div>
              <?php }else{ ?>
               <div class='col-sm-6 form-group' >
                     <label class="control-label">APK</label>
                     <?= $form->field($model, 'upload_apk')->fileInput(['id'=> 'upload_apk','maxlength' => true,'placeholder'=>'APK','class'=>'form-control'])->label(false) ?>
                         <?php
                  if($model->upload_apk!=""){
                   $base=Url::base(true);
                   $file=$base."/".$model->upload_apk;
                   ?>
                   <a href="<?php echo $file;?>"  class="fa fa-download"  style="color: #4CAF50 !important;"download>APK
                   <!--<img src="<?php //echo $file;?>" alt="APK" width="104" height="142">-->
                   </a>
                   <?php
                   }
                   else{

                 echo "No Records !!!";
                   }
                   
                     ?>
                     </div>
                       <?php } 
                      ?>
                       
                      <div class='col-sm-6 form-group' >
                     <label class="control-label">Description</label>
                     <?= $form->field($model, 'app_description')->textarea(['rows' => 6,'placeholder'=>'Description','class'=>'form-control','required'=>true])->label(false) ?>
                  </div>
                  <div class='col-sm-6 form-group' >
                     <label class="control-label">Version</label>
                     <?= $form->field($model, 'app_version')->textinput(['placeholder'=>'Version','class'=>'form-control','required'=>true])->label(false) ?>
                  </div>
                  </div>
            </div>
            <br>
            <br>
            <div class="panel-footer text-right">
   <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

<nav></nav>
         </div>
      </div>
   </div>
</div>
</div>

