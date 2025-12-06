<?php

namespace app\modules\account\controllers;

use app\models\Favourite;
use app\models\Product;
use app\models\UserReaction;
use app\modules\account\models\FavouriteSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;

/**
 * FavouriteController implements the CRUD actions for Favourite model.
 */
class FavouriteController extends Controller
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
     * Lists all Favourite models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new FavouriteSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }




    public function actionChange($product_id)
    {
        if ($this->request->isPost) {
            $model = Favourite::findOne(["product_id" => $product_id, "user_id" => Yii::$app->user->id]);

            if ($model) {
                $model->status = $model->status ? 0 : 1;
                if ($model->save()) {
                    return $this->asJson(true);
                }
            } else {
                $model = new Favourite();
                $model->product_id = $product_id;
                $model->user_id = Yii::$app->user->id;
                $model->status = 1;
                if ($model->save()) {
                    return $this->asJson(true);
                }
            }
        }

        return $this->asJson(false);
    }



    public function actionLikeChange($product_id, $reaction)
    {
        if ($this->request->isPost) {
            $model = UserReaction::findOne(["product_id" => $product_id, "user_id" => Yii::$app->user->id]);

            if (!$model) {
                $model = new UserReaction();
                $model->product_id = $product_id;
                $model->user_id = Yii::$app->user->id;
            }

            if ($model) {
                if ($product = Product::findOne($product_id)) {
                    // VarDumper::dump($product->id, 10, true);
                    // VarDumper::dump($model->attributes, 10, true);
                    // VarDumper::dump($reaction, 10, true);
                    // die;


                    if ($model->status !== null && $model->status == $reaction) {
                        if ($reaction) {
                            $product->like--;
                        } else {
                            $product->dislike--;
                        }
                        $product->save();
                    } elseif ($model->status === null) {
                        if ($reaction) {
                            $product->like++;
                        } else {
                            $product->dislike++;
                        }
                        $product->save();
                    }
                }
                if ($model->status !== null && $model->status == $reaction) {
                    $model->status = null;
                    if ($model->save()) {
                        return $this->asJson(true);
                    }
                } elseif ($model->status === null) {
                    $model->status = $reaction;
                    if ($model->save()) {
                        return $this->asJson(true);
                    }
                }
            }
        }

        return $this->asJson(false);
    }
}
