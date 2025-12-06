<?php

namespace app\modules\account\controllers;

use app\models\Cart;
use app\models\CartItem;
use app\models\Product;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CartController implements the CRUD actions for Cart model.
 */
class CartController extends Controller
{


    /**
     * Lists all Cart models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $cart = Cart::findOne(["user_id" => Yii::$app->user->id]);
        $dataProvider = new ActiveDataProvider([
            'query' => CartItem::find()
                ->with(["product"])
                ->filterWhere(["cart_id" => $cart?->id ?? 0]),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        // var_dump($dataProvider->query->createCommand()->rawSql);
        // die;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            "cart" => $cart,
        ]);
    }

    /**
     * Displays a single Cart model.
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

    /**
     * Creates a new Cart model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionAdd($product_id)
    {
        if ($this->request->isPost) {

            $cart = Cart::findOne(["user_id" => Yii::$app->user->id]);
            if (!$cart) {
                $cart = new Cart();
                $cart->user_id = Yii::$app->user->id;
                $cart->save();
            }

            $cart_item = CartItem::findOne(["cart_id" => $cart->id, "product_id" => $product_id]);
            $product = Product::findOne($product_id);

            if (!$cart_item) {
                $cart_item = new CartItem();
                $cart_item->cart_id = $cart->id;
                $cart_item->product_id = $product_id;
                $cart_item->price = $product->price;
                $cart_item->save();
            }

            if ($product->amount > $cart_item->amount) {
                $cart_item->amount++;
                $cart_item->total += $cart_item->price;

                $cart->amount++;
                $cart->total += $cart_item->price;

                if ($cart->save() && $cart_item->save()) {
                    return $this->asJson(true);
                }
            }
        }

        return $this->asJson(false);
    }


    public function actionCount()
    {
        if ($this->request->isPost) {
            return $this->asJson(Cart::getCount());
        }

        return $this->asJson(false);
    }

    public function actionChangeItem($item_id, $action = "")
    {
        $cart_item = CartItem::findOne($item_id);

        if ($cart_item) {
            $cart = Cart::findOne($cart_item->cart_id);

            switch ($action) {
                case "minus":
                    $cart_item->amount--;
                    $cart_item->total -= $cart_item->price;
                    $cart_item->save();

                    $cart->amount--;
                    $cart->total -= $cart_item->price;
                    $cart->save();

                    if (!$cart_item->amount) {
                        $cart_item->delete();
                    }
                    return $this->asJson(true);
                    break;
                default:
                    return $this->actionAdd($cart_item->product_id);
            }
        }
        return $this->asJson(false);
    }



    public function actionRemoveItem($id)
    {
        if ($this->request->isPost) {
            CartItem::findOne($id)->delete();
            return $this->asJson(true);
        }

        return $this->asJson(false);
    }

    /**
     * Finds the Cart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Cart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cart::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
