<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\ClientManagement */
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
<div class="video-management-form">
   <?php $form = ActiveForm::begin(); ?>
   <div class="panel">
      <div class="panel-body">
         <div class="row">
            <div class='col-sm-6 form-group' >
                     <label class="control-label">Name</label>
              <?= $form->field($model, 'client_name')->textInput(['maxlength' => true,'placeholder'=>'Name','class'=>'form-control','required'=>true])->label(false) ?>
                  </div> 
                 <div class='col-sm-6 form-group' >
                     <label class="control-label">Email Id</label>
              <?= $form->field($model, 'email_id')->textInput(['maxlength' => true,'placeholder'=>'Email Id','class'=>'form-control','required'=>true])->label(false) ?>
                  </div>
                  </div>
              <div class="row">
                     <div class='col-sm-6 form-group' >
               <?php if($model->isNewRecord){ ?>
               <?php 
                  echo $form->field($model, 'password_hash')->passwordInput(['maxlength' => true,'placeholder'=>'Password','class'=>'form-control', 'value'=>'', 'required'=>true])->label('Password');?>
               <?php }else{ ?>
               <?php 
                  echo $form->field($model, 'password_hash')->passwordInput(['maxlength' => true,'placeholder'=>'Password','class'=>'form-control', 'value'=>''])->label('Password');?>
               <?php } ?>
            </div>

                  <div class='col-sm-2 form-group'> 
                      <?php if($model->isNewRecord){ ?>
               <?php 
               echo $form->field($model, 'apps_name')->checkboxlist($applist);?>
                <?php }else{

                  $congi = ArrayHelper::map($model1,'app_id','app_id');
              
                 ?>
               <?php
                 $model->apps_name=$congi; 
                echo $form->field($model, 'apps_name')->checkboxlist($applist);?>
             <?php } ?>
            </div>
         </div>
            <div class="panel-footer text-right">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
         </div>
      </div>
   </div>
   <?php ActiveForm::end(); ?>
</div>
