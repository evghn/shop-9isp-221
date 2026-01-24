<?php

namespace app\controllers;

use app\models\Product;
use app\models\CatalogSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CatalogController implements the CRUD actions for Product model.
 */
class RbacController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Product models.
     *
     * @return string
     */
    public function actionCreate()
    {

        $auth = Yii::$app->authManager;

        $auth->removeAll();

        $admin = $auth->createRole('admin');
        $auth->add($admin);

        $client = $auth->createRole('client');
        $auth->add($client);


        $canAdmin = $auth->createPermission('canAdmin');
        $canAdmin->description = 'Permission for admin';
        $auth->add($canAdmin);
        $auth->addChild($admin, $canAdmin);

        $canClient = $auth->createPermission('canClient');
        $canClient->description = 'Permission for client';
        $auth->add($canClient);
        $auth->addChild($client, $canClient);


        $auth->assign($admin, 2);
        $auth->assign($client, 1);


        var_dump("ok");
    }
}
