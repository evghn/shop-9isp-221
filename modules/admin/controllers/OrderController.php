<?php

namespace app\modules\admin\controllers;

use app\models\Order;
use app\models\Status;
use app\modules\admin\models\OrderSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
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
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Order models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionDelete($id)
    {
        if ($model = Order::findOne($id)) {
            $model->delete();
        }

        return $this->redirect('/admin');
    }


    public function actionChangeStatus($id, $status)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            $model->status_id = Status::getStatusId($status);

            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Статус заявки успешно зменен.');
                Order::sendMail([
                    "order_id" => $id,
                    "layout" =>  "@app/mail/layouts/html-status-order",
                    "subject" => "Смена статуса заказа",
                    "letter" => "mail-status-order"
                ]);

                return $this->redirect(['index']);
            } else {
                VarDumper::dump($model->errors, 10, true);
                die;
            }
        }
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
