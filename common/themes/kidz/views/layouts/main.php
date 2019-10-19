<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 19/11/2561
 * Time: 22:42
 */

use yii\bootstrap\Modal;

$themeAsset = Yii::$app->assetManager->getPublishedUrl('@kidz/assets/dist');
?>
<?php $this->beginContent('@kidz/views/layouts/_base.php', ['class' => 'body-wrapper']); ?>
    <!-- ====================================
      ——— PRELOADER
      ===================================== -->
    <!--<div id="preloader" class="smooth-loader-wrapper">
       <div class="smooth-loader">
         <div class="loader">
           <span class="dot dot-1"></span>
           <span class="dot dot-2"></span>
           <span class="dot dot-3"></span>
           <span class="dot dot-4"></span>
         </div>
       </div>
     </div>-->

    <div class="main-wrapper" id="myApp">
        <?= $this->render('_header', ['themeAsset' => $themeAsset]); ?>
        <?= $this->render('_content', ['content' => $content, 'themeAsset' => $themeAsset]); ?>
        <?= $this->render('_footer', ['themeAsset' => $themeAsset]); ?>
    </div>
    <div class="scrolling">
        <a href="#pageTop" class="backToTop hidden-xs" id="backToTop"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
    </div>
    <!-- ====================================
        ——— LOGIN MODAL
        ===================================== -->
<?php
Modal::begin([
    "id" => "ajaxCrudModal",
    "footer" => "",
    'options' => ['class' => 'modal', 'tabindex' => false,],
]);

Modal::end();
?>
    <!-- <div class="modal fade customModal" id="loginModal" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="panel panel-default formPanel">
            <div class="panel-heading bg-color-1 border-color-1">
              <h3 class="panel-title">Login</h3>
            </div>
            <div class="panel-body">
              <form action="#" method="POST" role="form">
                <div class="form-group formField">
                  <input type="text" class="form-control" placeholder="User name">
                </div>
                <div class="form-group formField">
                  <input type="password" class="form-control" placeholder="Password">
                </div>
                <div class="form-group formField">
                  <input type="submit" class="btn btn-primary btn-block bg-color-3 border-color-3" value="Log in">
                </div>
                <div class="form-group formField">
                  <p class="help-block"><a href="#">Forgot password?</a></p>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div> -->

    <!-- ====================================
    ——— CREATE ACCOUNT MODAL
    ===================================== -->
    <div class="modal fade customModal" id="createAccount" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="panel panel-default formPanel">
                    <div class="panel-heading bg-color-1 border-color-1">
                        <h3 class="panel-title">Create an account</h3>
                    </div>
                    <div class="panel-body">
                        <form action="#" method="POST" role="form">
                            <div class="form-group formField">
                                <input type="text" class="form-control" placeholder="Name">
                            </div>
                            <div class="form-group formField">
                                <input type="text" class="form-control" placeholder="User name">
                            </div>
                            <div class="form-group formField">
                                <input type="text" class="form-control" placeholder="Phone">
                            </div>
                            <div class="form-group formField">
                                <input type="password" class="form-control" placeholder="Password">
                            </div>
                            <div class="form-group formField">
                                <input type="password" class="form-control" placeholder="Re-Password">
                            </div>
                            <div class="form-group formField">
                                <input type="submit" class="btn btn-primary btn-block bg-color-3 border-color-3"
                                       value="Register">
                            </div>
                            <div class="form-group formField">
                                <p class="help-block">Allready have an account? <a href="#">Log in</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->endContent(); ?>