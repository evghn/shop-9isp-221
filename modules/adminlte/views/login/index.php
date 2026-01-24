<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\web\JqueryAsset;

?>

<div class="login-box">
    <div class="login-logo">
        Авторизация
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <?php
            $form = ActiveForm::begin([
                'id' => 'login-form',
            ]);
            ?>

            <div class="input-group mb-3 field-loginform-username required">
                <input type="text" id="loginform-username" class="form-control" name="LoginForm[username]" autofocus="" aria-required="true" aria-invalid="true" placeholder="Login">
                <div class="input-group-text">
                    <span class="bi bi-envelope"></span>
                </div>
                <div class="invalid-feedback"></div>
            </div>
            <div class="input-group mb-3 field-loginform-password required">
                <input type="password" id="loginform-password" class="form-control" name="LoginForm[password]" autofocus="" aria-required="true" aria-invalid="true" placeholder="Password">
                <div class="input-group-text">
                    <span class="bi bi-lock-fill"></span>
                </div>
                <div class="invalid-feedback"></div>
            </div>

            <!--begin::Row-->
            <div class="row">
                <div class="col-8">
                    <div class="form-check pt-2">
                        <?= $form->field($model, 'rememberMe')->checkbox([
                            'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                        ]) ?>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                    <div class="d-grid gap-2">
                        <?= Html::submitButton('Вход', ['class' => 'btn btn-outline-primary', 'name' => 'login-button']) ?>
                    </div>
                </div>
                <!-- /.col -->
            </div>


            <div class="d-none">

                <? # $form->field($model, 'username')->textInput(['autofocus' => true])
                ?>

                <? # $form->field($model, 'password')->passwordInput()
                ?>
            </div>




            <?php ActiveForm::end(); ?>







        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<?php

$this->registerJsFile("/js/login.js", ["depends" => JqueryAsset::class]);
