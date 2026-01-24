<?php

namespace app\modules\adminlte;

use Yii;
use yii\filters\AccessControl;

/**
 * admin-lte module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\adminlte\controllers';
    public $layoutPath = 'app\modules\adminlte\views\layouts';
    public $layout = "admin";


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                        "controllers" => ['admin-lte/login'],
                        // 'actions' => ["admin-lte/login/index"]
                    ],
                    // разрешаем аутентифицированным пользователям
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        "matchCallback" => fn() => Yii::$app->user->identity->isAdmin
                    ],
                    // всё остальное по умолчанию запрещено
                ],
                "denyCallback" => fn() => Yii::$app->response->redirect("/"),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
