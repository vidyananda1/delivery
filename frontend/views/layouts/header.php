<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */
date_default_timezone_set('Asia/Kolkata');

?>

<header class="main-header " style="box-shadow: 0px 0px 10px;" >
<!-- <img src="images/nk2.png"> -->
<?= Html::csrfMetaTags() ?>

    <?= Html::a('<span class="logo-mini"></span><span class="logo-lg">DEMO</span>', Yii::$app->homeUrl, ['class' => 'logo' ]) ?>

    <nav class="navbar navbar-static-top " role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            
        </a>

        <div class="navbar-custom-menu">
            
            <ul class="nav navbar-nav ">

               
                <!-- User Account: style can be found in dropdown.less -->
                <?php if(Yii::$app->user->isGuest){?>
                <li><?=Html::a('Login',Url::to(['site/login']),['class'=>'glyphicon glyphicon-user']) ?></li>
                <?php }else{ ?>

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" >
                       
                        <span class="hidden-xs glyphicon glyphicon-user"> <?= strtoupper(Yii::$app->user->identity->username)?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header"  style="background-color: #bdbebf;">
                            
                            <i class="glyphicon glyphicon-user fa-5x" style="color: white"></i>
                        <p>
                            <?= Yii::$app->user->identity->username ?>       
                        </p>
                            
                        </li>
                  
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="index.php?r=user/change_password" class="btn btn-default btn-flat">Change Password</a>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Log out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>

                         <li>
            
          </li>
                        
                    </ul>
                </li>
            

                <!-- User Account: style can be found in dropdown.less -->
               <?php } ?>
            </ul>
        </div>
    </nav>
</header>

