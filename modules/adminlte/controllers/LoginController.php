<?php

namespace app\modules\adminlte\controllers;

use app\models\LoginForm;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;

/**
 * Default controller for the `admin-lte` module
 */
class LoginController extends Controller
{
    public $layout = "login";

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            // VarDumper::dump(Yii::$app->request->post(), 10, true);
            // VarDumper::dump($model->attributes, 10, true);
            // VarDumper::dump($_POST, 10, true);
            // die;
            if ($model->login()) {
                if (!Yii::$app->user->identity->isAdmin) {
                    Yii::$app->user->logout();
                    return $this->goHome();
                }

                return $this->redirect("/admin-lte");
            } else {
                Yii::$app->session->setFlash("error", "Некорректные логин или пароль");
            }
        }

        $model->password = '';
        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
