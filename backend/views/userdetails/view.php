<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Userdetails */

$this->title = 'User Detail View';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box-body">
    <div class="box box-primary cgridoverlap">
     <div class="">
    </div>
<div class="userdetails-view">

    <div class="col-md-12">

              <!-- Profile Image -->
              
                  <img class="profile-user-img img-responsive img-circle" src="dist/img/user2-160x160.jpg" alt="User profile picture">
                  <h3 class="profile-username text-center"><?= $model->first_name .' '. $model->last_name  ?></h3>
                  <p class="text-muted text-center"><?php echo $model->user_type == 'A' ? 'Admin' : "Others"; ?></p>

                  <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                      <b>User Name</b> <a class="pull-right"><?= $model->username ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Status</b> <a class="pull-right"><?= $model->status_flag == 'A'? 'Active' : 'Inactive' ?></a>
                    </li>
                  </ul>

                
              
            </div><!-- /.col -->

    
</div>
</div>
</div>