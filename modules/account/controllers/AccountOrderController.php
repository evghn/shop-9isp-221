<?php

namespace app\modules\account\controllers;

use app\models\Cart;
use app\models\CartItem;
use app\models\Order;
use app\models\OrderItem;
use app\models\Status;
use app\modules\account\models\AccountSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;

/**
 * AccountController implements the CRUD actions for Order model.
 */
class AccountOrderController extends Controller
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
        $searchModel = new AccountSearch();
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
        $dataProvider = new ActiveDataProvider([
            'query' => OrderItem::find()
                ->with(["product"])
                ->filterWhere(["order_id" => $id]),
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            "dataProvider" => $dataProvider
        ]);
    }

    public function actionSendMail()
    {
        if (Order::sendMail(7)) {
            Yii::$app->session->setFlash("success", "Письмо успешно отправлено");
            return $this->actionIndex();
        }
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Order();
        $cart = Cart::findOne(["user_id" => Yii::$app->user->id]);
        $dataProvider = new ActiveDataProvider([
            'query' => CartItem::find()
                ->with(["product"])
                ->filterWhere(["cart_id" => $cart?->id ?? 0]),
            'pagination' => [
                'pageSize' => 3
            ],
        ]);

        if ($this->request->isPost) {

            if ($model->load($this->request->post())) {
                $model->status_id = Status::getStatusId("new");
                $model->load($cart->attributes, "");

                if ($model->save()) {
                    $cart_item = CartItem::find()
                        ->where(["cart_id" => $cart->id])
                        ->asArray()
                        ->all();
                    foreach ($cart_item as $item) {
                        $orderItem = new OrderItem();
                        $orderItem->order_id = $model->id;
                        $orderItem->load($item, "");
                        $orderItem->save();
                    }
                    Yii::$app->session->setFlash("success", "Ваш заказ успешно создан");
                    Cart::clear();


                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'cart' => $cart,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
