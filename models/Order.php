<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $amount
 * @property float $total
 * @property int $user_id
 * @property string $created_at
 * @property int $status_id
 * @property int $pay_type_id
 *
 * @property OrderItem[] $orderItems
 * @property PayType $payType
 * @property Status $status
 * @property User $user
 */
class Order extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount'], 'default', 'value' => 0],
            [['amount', 'user_id', 'status_id', 'pay_type_id'], 'integer'],
            [['total', 'user_id', 'status_id', 'pay_type_id'], 'required'],
            [['total'], 'number'],
            [['created_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['pay_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PayType::class, 'targetAttribute' => ['pay_type_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'amount' => 'Количество товара',
            'total' => 'Общая стоимость (₽)',
            'user_id' => 'User ID',
            'created_at' => 'Дата время заказа',
            'status_id' => 'Статус заказа',
            'pay_type_id' => 'Тип оплаты',
        ];
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
    }

    /**
     * Gets query for [[PayType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayType()
    {
        return $this->hasOne(PayType::class, ['id' => 'pay_type_id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }


    public static function sendMail($params)
    {
        $order = Order::findOne($params['order_id']);

        $dataProvider = new ActiveDataProvider([
            'query' => OrderItem::find()
                ->with(["product"])
                ->filterWhere(["order_id" => $params['order_id']]),
        ]);

        Yii::$app->mailer->htmlLayout = $params['layout']; //"@app/mail/layouts/html";
        return Yii::$app->mailer
            ->compose($params['letter'], ['model' => $order, 'dataProvider' => $dataProvider])
            ->setFrom("iv2-22-web@mail.ru")
            ->setTo($order->user->email)
            ->setSubject($params['subject'])
            ->send();
    }

    public static function totalOrders()
    {
        return static::find()->count();
    }
}
