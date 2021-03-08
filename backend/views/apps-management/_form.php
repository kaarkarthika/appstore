<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\models\AppsManagement */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
   .score {
   background-color: #0c9cce;
   color: #fff;
   font-weight: 600;
   border-radius: 50%;
   width: 40px;
   height: 40px;
   line-height: 40px;
   text-align: center;
   margin: auto;
   /* padding: 21% 14%;*/
   }
   .checkbox input[type="checkbox"] {
   cursor: pointer;
   opacity: 0;
   z-index: 1;
   outline: none !important;
   }
   .upper {
   text-transform: uppercase;
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
            <div class="panel-body   ">
               <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
               <div class="row">
                <?php if($model->isNewRecord){ ?>
                <div class='col-sm-6 form-group' >
                     <label class="control-label">Company Logo</label>
                     <?= $form->field($model, 'company_logo')->fileInput(['id'=> 'company_logo','maxlength' => true,'placeholder'=>'Logo','class'=>'form-control','required'=>true])->label(false) ?>

                               <?php
                  if($model->company_logo!=""){
                   $base=Url::base(true);
                   $upload_apk=$base."/".$model->company_logo;
                   //echo $video_image;
                   ?>

                   <img src="<?php echo $upload_apk;?>" style="width:70px;height:70px;">
                   <?php
                   }
                   else{

                 echo "No Images !!!";
                   }
                   
                     ?>


                      </div>
                      <?php }else{ ?>
                        <div class='col-sm-6 form-group' >
                     <label class="control-label">Company Logo</label>
                     <?= $form->field($model, 'company_logo')->fileInput(['id'=> 'company_logo','maxlength' => true,'placeholder'=>'Logo','class'=>'form-control'])->label(false) ?> 

                      <?php
                  if($model->company_logo!=""){
                   $base=Url::base(true);
                   $upload_apk=$base."/".$model->company_logo;
                   //echo $video_image;
                   ?>

                   <img src="<?php echo $upload_apk;?>" style="width:70px;height:70px;">
                   <?php
                   }
                   else{

                   //  echo "No Images !!!";
                   }
                   
                     ?>


                     </div>                
                     <?php } ?>

                     <div class='col-sm-6 form-group' >
                     <label class="control-label">Company Name</label>
                     <?= $form->field($model, 'company_name')->textInput(['maxlength' => true,'placeholder'=>'Company Name','class'=>'form-control','required'=>true])->label(false) ?>
                  </div>
                 <?php if($model->isNewRecord){ ?>
               	<div class='col-sm-6 form-group' >
                     <label class="control-label">App Logo</label>
                     <?= $form->field($model, 'apps_logo')->fileInput(['id'=> 'apps_logo','maxlength' => true,'placeholder'=>'Logo','class'=>'form-control','required'=>true])->label(false) ?>

                               <?php
                  if($model->apps_logo!=""){
                   $base=Url::base(true);
                   $upload_apk=$base."/".$model->apps_logo;
                   //echo $video_image;
                   ?>

                   <img src="<?php echo $upload_apk;?>" style="width:70px;height:70px;">
                   <?php
                   }
                   else{

                 echo "No Images !!!";
                   }
                   
                     ?>


                      </div>
                      <?php }else{ ?>
                        <div class='col-sm-6 form-group' >
                     <label class="control-label">App Logo</label>
                     <?= $form->field($model, 'apps_logo')->fileInput(['id'=> 'apps_logo','maxlength' => true,'placeholder'=>'Logo','class'=>'form-control'])->label(false) ?> 

                      <?php
                  if($model->apps_logo!=""){
                   $base=Url::base(true);
                   $upload_apk=$base."/".$model->apps_logo;
                   //echo $video_image;
                   ?>

                   <img src="<?php echo $upload_apk;?>" style="width:70px;height:70px;">
                   <?php
                   }
                   else{

                   //  echo "No Images !!!";
                   }
                   
                     ?>


                     </div>                
                     <?php } ?>
                  <div class='col-sm-6 form-group' >
                     <!-- <h3 class="panel-title" style=" position: relative;right: 14px;">Branch Name</h3> -->
                     <label class="control-label">Name</label>
                     <?= $form->field($model, 'apps_name')->textInput(['maxlength' => true,'placeholder'=>'Name','class'=>'form-control','required'=>true])->label(false) ?>
                  </div>
                  <div class='col-sm-6 form-group' >
                     <!-- <h3 class="panel-title" style=" position: relative;right: 14px;">Branch Name</h3> -->
                     <label class="control-label">Description</label>
                     <?= $form->field($model, 'apps_description')->textarea(['rows' => 6,'placeholder'=>'Description','class'=>'form-control','required'=>true])->label(false) ?>
                  </div>
                  </div>
            </div>
            <br>
            <br>
            <div class="panel-footer text-right">
        <?= Html::submitButton($model->isNewRecord ? 'create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
 <nav></nav>
         </div>
      </div>
   </div>
</div>
</div>
