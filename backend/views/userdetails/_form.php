<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\dropDownList;

/* @var $this yii\web\View */
/* @var $model backend\models\Userdetails */
/* @var $form yii\widgets\ActiveForm */
?>
<section class="content">
<!-- Info boxes -->
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
            <div class="">
                     <h3 class="box-title"><?= $model->isNewRecord ? '<i class="fa fa-fw fa-user-plus"></i>User Details' : '<i class="fa fa-fw fa-user"></i>' ?>  <?= Html::encode($this->title) ?></h3>
              </div><!-- /.box-header -->
<div class="userdetails-form">
<div class="box-body">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-12">

    <div class="form-group col-md-6">
    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true, 'placeholder' => 'First Name']) ?>
    </div>
        <div class="form-group col-md-6">

	<?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'placeholder' => 'Last Name']) ?>
	</div>
	</div>
	<div class="col-md-12">
	<div class="form-group col-md-6">
	<?= $form->field($model, 'designation')->textInput(['maxlength' => true, 'placeholder' => 'Designation']) ?>
	</div>
	<div class="form-group col-md-6">
	<?= $form->field($model, 'mobile_number')->textInput(['maxlength' => true, 'placeholder' => 'Mobile Number']) ?>
	</div>
	</div>
	<div class="col-md-12">
	 <div class="form-group col-md-6">
    <?php echo $form->field($model, 'user_type')->dropDownList(
            ['A' => 'Admin', 'U' => 'User', 'P' => 'Other'] ); ?>
    	</div>
	</div>
	<div class="col-md-12">
	</div>

	 <div class="col-md-12">
	    <div class="form-group col-md-6">

    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => 'Login Username']) ?>
    </div>
       <div class='col-sm-6 form-group' >
               <?php if($model->isNewRecord){ ?>
               <?php 
                  echo $form->field($model, 'password_hash')->passwordInput(['maxlength' => true,'placeholder'=>'Password','class'=>'form-control', 'value'=>'', 'required'=>true])->label('Password');?>
               <?php }else{ ?>
               <?php 
                  echo $form->field($model, 'password_hash')->passwordInput(['maxlength' => true,'placeholder'=>'Password','class'=>'form-control', 'value'=>''])->label('Password');?>
               <?php } ?>
            </div>
	</div>

   <div class="box-footer pull-right">
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    </div>
    <?php ActiveForm::end(); ?>
    </div>

</div>
</div>
</div>
</div>
</section>



<script type="text/javascript">
    $(".datepicker").datepicker();
    </script>